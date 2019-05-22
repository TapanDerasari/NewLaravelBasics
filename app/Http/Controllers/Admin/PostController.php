<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Datatables;
use Exception;
use Response;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $usersPosts = Post::query();
            return (Datatables::of($usersPosts)
                ->editColumn('body', function ($data) {
                    return Str::limit($data->body, $limit = 75, $end = '...');
                })
                ->editColumn('user_id', function ($data) {
                    return $data->user->name;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d/m/Y');
                })
                ->addColumn('likes', function ($data) {
                    return $data->likes->count();
                })
                ->addColumn('action', function ($data) {
                    return '
                      <a href="' . route('admin.users.posts.show', $data->id) . '" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i> View</a>
                      <a href="' . route('users.edit', $data->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                })
                ->rawColumns(['action'])
                ->make(true));
        } else {
            return view('admin.posts.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
        $post = Post::findOrFail($id);
        dd($post);
        return view('admin.posts.view', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.view', compact($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function StatusUpdate(Request $request)
    {
        if ($request->ajax()) {
            $user = User::findOrFail($request->id);
            if ($request->has('status')) {
                $user->status = $request->status;
                $user->save();
                response()->json('User status has been updated', 200);
            }
        } else {
            response()->json('Bad request', 500);
        }
    }
}
