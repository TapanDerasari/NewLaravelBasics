<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Share;
use App\Http\Requests\ShareRequest;
use Datatables;
use Exception;
use Intervention\Image\Facades\Image;

class ShareController extends Controller
{
    /**
     * Display a listing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $shares = Share::query();
            return (Datatables::of($shares)
                ->addColumn('action', function ($data) {
                    return '
                    <a href="' . route('shares.edit', $data->id) . '" class="btn btn-xs btn-success">Edit</a>
                    <a href="' . route('shares.delete', $data->id) . '" class="btn btn-xs btn-danger">Delete</a>';
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d/m/Y');
                })
                ->editColumn('updated_at', function ($data) {
                    return $data->updated_at->format('d/m/Y');
                })
                ->make(true));
        } else {
            return view('shares.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shares.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShareRequest $request)
    {
        $this->authorize('create',Share::class);
        $share = new Share([
            'share_name' => $request->get('share_name'),
            'share_price' => $request->get('share_price'),
            'share_qty' => $request->get('share_qty'),
            'image' => $request->get('image')
        ]);
        $share->save();
        $this->storeImage($share);
        return redirect('/shares')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $share = Share::find($id);

        return view('shares.edit', compact('share'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShareRequest $request, $id)
    {
        $share = Share::find($id);
        $share->share_name = $request->get('share_name');
        $share->share_price = $request->get('share_price');
        $share->share_qty = $request->get('share_qty');
        $share->save();
        if ($share->image){
            unlink(public_path('storage/').$share->image);
        }
        $this->storeImage($share);
        return redirect('/shares')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $share = Share::find($id);
        $this->authorize('delete',$share);
        $share->delete();

        return redirect('/shares')->with('success', 'Stock has been deleted Successfully');
    }

    public function storeImage($share){
        if (request()->has('image')){
            $share->update([
                'image'=>request()->image->store('uploads','public'),
            ]);
            $image=Image::make(public_path('storage/').$share->image)->crop(request()->input('w'), request()->input('h'), request()->input('x1'), request()->input('y1'));
            $image->save();
        }
    }

    public function getChartData(Request $request)
    {
      return json_decode('helo');
    }
}
