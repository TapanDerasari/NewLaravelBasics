<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Post;
use Datatables;
use Exception;
use Intervention\Image\Facades\Image;
use Response;
use Notification;
use App\Notifications\PostLiked;
use Illuminate\Support\Facades\URL;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('signed')->only(['edit', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::user()->id;
        $post->image = $request->image;
        $post->save();
        $this->storeImage($post);
        return redirect()->back()->with('message', 'Post has been created.');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.create', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::user()->id;
        $post->save();
        if ($post->image) {
            $file = public_path('storage/') . $post->image;
            if (!empty($file)) {
                unlink($file);
            }
        }
        $this->storeImage($post);
        return redirect()->back()->with('message', 'Post has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeImage($post)
    {
        if (request()->has('image')) {
            $post->update([
                'image' => request()->image->store('uploads/postImages', 'public'),
            ]);
            $image = Image::make(public_path('storage/') . $post->image)->crop(request()->input('w'), request()->input('h'), request()->input('x1'), request()->input('y1'));
            $image->save();
        }
    }

    public function likeDislike(Request $request)
    {
        if ($request->ajax()) {
            $responseData = [];
            $post = Post::findOrFail($request->post_id);
            $user = Auth::user();
            if ($user->likes->contains($post->id)) {
                $user->likes()->detach($post);
            } else {
                $user->likes()->attach($post);
                if ($post->user->id != $user->id) {
                    $data['name'] = $user->name;
                    $data['post'] = $post->title;
                    Notification::send($post->user, new PostLiked($data));
                }
            }
            $totalLikes = Like::where('post_id', $post->id)->count();
            $responseData['totalLikes'] = $totalLikes;
            return response()->json($responseData, 200);
        } else {
            return redirect()->back()->with('message', 'Bad Request');
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        $notification->markAsRead();
        return redirect()->back();
    }
}
