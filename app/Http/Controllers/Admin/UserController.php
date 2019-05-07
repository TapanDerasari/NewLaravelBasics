<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Datatables;
use Exception;
use Response;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=User::findOrFail(1);
        if ($request->ajax()) {
            $users = User::query();
            return (Datatables::of($users)
                ->addColumn('action', function ($data) {
                    return '
                      <a href="' . route('users.show', $data->id) . '" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i> View</a>
                      <a href="' . route('users.edit', $data->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                })
                ->addColumn('activity', function ($data) {
                    if ($data->isOnline()){
                        return '<div class="text-success"><i class="fa fa-circle"></i> Online</div>';
                    }else{
                        return '<div class="text-danger">Offline</div>';
                    }
                })
                ->editColumn('status', function ($data) {
                    if ($data->status){
                        return '<button type="button" id="status-link" class="btn btn-success status-link" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->status.'" data-target="#statusModal" onclick="statusClicked(this);">Enabled</button>';
                    }else{
                        return '<button type="button" id="status-link" class="btn btn-danger status-link" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->status.'" data-target="#statusModal" onclick="statusClicked(this);">Disabled</button>';
                    }
                })
                ->rawColumns(['activity','status','action'])
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d/m/Y');
                })
                ->make(true));
        } else {
            return view('admin.users.index');
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
        $user = User::findOrFail($id);
        return view('admin.users.view',compact('user'));
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
        return view('admin.users.view',compact($user));
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

    public function StatusUpdate(Request $request){
        if ($request->ajax()){
            $user = User::findOrFail($request->id);
            if ($request->has('status')){
                $user->status=$request->status;
                $user->save();
                response()->json('User status has been updated',200);
            }
        }else{
            response()->json('Bad request',500);
        }
    }
}
