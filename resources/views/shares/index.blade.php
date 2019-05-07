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
                    <div>
                        <div class="text-center">
                            <button type="button" id="exportButton" class="btn btn-outline-info">Export as PDF</button>
                        </div>
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
                <script src="{{asset('js/pdf/jspdf.min.js')}}"></script>
                <script>
                    var url = "{{route('shares.getChartData')}}";
                    var Years = new Array();
                    var Labels = new Array();
                    var Prices = new Array();
                    $(document).ready(function () {
                        //pdf
                        $('#exportButton').click(function () {
                            var can = document.getElementsByTagName("canvas");
                            var dataURL = can[0].toDataURL("image/png");
                            var width = 280;
                            var height = 150;
                            var pdf = new jsPDF('landscape');
                            pdf.setFontSize(10);
                            pdf.addImage(dataURL, 'PNG', 0, 0, width, height);
                            pdf.save("Share-details.pdf");
                        });

                        //graph ajax
                        $.ajax({
                            type: 'GET',
                            url: url,
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                                $.each(data, function (i, loop) {
                                    Years.push(loop.created_at);
                                    Labels.push(loop.share_name);
                                    Prices.push(loop.share_price);
                                });
                                var ctx = document.getElementById("canvas").getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: Labels,
                                        datasets: [{
                                            label: 'Share Prices',
                                            data: Prices,
                                            borderWidth: 1,
                                            backgroundColor: 'rgba(0, 99, 132, 0.6)',
                                            borderColor: "rgba(220,220,220,0.8)",
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