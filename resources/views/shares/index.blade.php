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
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Charts</b></div>
                    <div class="panel-body">
                        <canvas id="canvas" height="280" width="600"></canvas>
                    </div>
                </div>
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
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js"
                        charset="utf-8"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"
                        charset="utf-8"></script>
                <script>
                    var url = "{{route('shares.getChartData')}}";
                    var Years = new Array();
                    var Labels = new Array();
                    var Prices = new Array();
                    $(document).ready(function () {
                        $.ajax({
                            type: 'GET',
                            url: url,
                            dataType:'json',
                            success: function (response) {
                                console.log(response);
                                $(response).each(function (data) {
                                    Years.push(data.created_at);
                                    Labels.push(data.share_name);
                                    Prices.push(data.share_price);
                                });
                                var ctx = document.getElementById("canvas").getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: Years,
                                        datasets: [{
                                            label: 'Share Prices',
                                            data: Prices,
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        }
                                    }
                                });
                            }
                        });
                    });
                </script>
@endsection