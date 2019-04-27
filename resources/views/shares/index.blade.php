@extends('layouts.app')
@section('title','shares')
@section('breadcrumb',Breadcrumbs::render('share-index'))
@section('content')
    <div class="container">
        <div class="uper">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div><br/>
            @endif
            @can('create',\App\Share::class)
                    <div class="float-right mb-3">
                        <a href="{{route('shares.create')}}">Create</a>
                    </div>
            @endcan
            <table id="shares" class="table table-hover table-condensed">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Stock Name</td>
                    <td>Stock Price</td>
                    <td>Stock Quantity</td>
                    <td>Created at</td>
                    <td>Updated at</td>
                    <td>Action</td>
                </tr>
                </thead>
            </table>
            <div>
            </div>
            @endsection
            @section('pageScript')
                <script type="text/javascript">
                    $(document).ready(function () {
                        oTable = $('#shares').DataTable({
                            "processing": true,
                            "serverSide": true,
                            "ajax": "{{ route('shares.index') }}",
                            "columns": [
                                {data: 'id', name: 'id'},
                                {data: 'share_name', name: 'share_name'},
                                {data: 'share_price', name: 'share_price'},
                                {data: 'share_qty', name: 'share_qty'},
                                {data: 'created_at', name: 'created_at'},
                                {data: 'updated_at', name: 'updated_at'},
                                {data: 'action', name: 'action'}
                            ]
                        });
                    });
                </script>
@endsection