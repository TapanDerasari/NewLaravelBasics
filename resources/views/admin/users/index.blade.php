@extends('layouts.admin')
@section('title','Users')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Users</h1>
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
                <table id="users" class="table table-borderless">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th>Activity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="statusModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">User Status</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="uid" id="uid" value="">
                    <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="1">Enabled</option>
                        <option value="0">Disabled</option>
                    </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="save" class="btn btn-primary" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    </div>
@endsection
@section('pageScript')
    <script type="text/javascript">
        $(document).ready(function () {

            oTable = $('#users').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('users.index') }}",
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'activity', name: 'activity'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'}
                ]
            });

            //Change Status event
            $(document).on('click', '#save', function (event) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('users.status') }}",
                    type: "POST",
                    data: {id: $('#uid').val(), status: $("#status").val()},
                    success: function (response) {
                        $("statusModal").modal("hide");
                        oTable.draw();
                        swal.fire({
                            type: 'success',
                            title: 'User status changed successfully.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    },
                    error: function () {
                        $("statusModal").modal("hide");
                        swal.fire({
                            type: 'error',
                            title: 'Something went wrong.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }

                });

            });

        });
        function statusClicked(e){
          var status = $(e).data('status');
          var uid = $(e).data('id');
          $("#status").val(status);
          $("#uid").val(uid);
        }
    </script>
@endsection