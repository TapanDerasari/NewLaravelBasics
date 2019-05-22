@extends('layouts.admin')
@section('title','Users Posts')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Users Posts</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            {{Breadcrumbs::render('user-index')}}
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <table id="userposts" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Likes</th>
                        <th>Author</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('pageScript')
    <script type="text/javascript">
        $(document).ready(function () {

            oTable = $('#userposts').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('admin.users.posts')}}",
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'body', name: 'body'},
                    {data: 'likes', name: 'likes'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'}
                ]
            });
        });
    </script>
@endsection