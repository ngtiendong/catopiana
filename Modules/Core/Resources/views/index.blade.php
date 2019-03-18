@extends('layouts.admin_default')
@section('title', 'Dashboard')
@section('content')
    <section class="content-header">
        <h1>
            Bảng điều khiển
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active">Bảng điều khiển</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <!--Thông tin khách hàng-->
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin khách hàng</h3>

                        <div class="box-tools pull-right">
                            <div class="form-group">
                                <div class="input-group">
                                    <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                        <span>Lọc theo thời gian </span>
                                        <i class="fa fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                    {{--<div class="box-footer">--}}

                    {{--</div>--}}
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!--phan loai khach hang-->
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Biểu đồ</h3>

                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row chart_info">

                            <div class="col-md-6">
                                <div style="border: #e6e6e6 1px solid; height: 100%">
                                    <p class="text-center" style="background: #92D050; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
                                        <strong>Bản tin eroscare</strong>
                                    </p>
                                    <div class="clearfix"></div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div style="border: #e6e6e6 1px solid; height: 100%">
                                    <p class="text-center" style="background: #92D050; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
                                        <strong>Theo loại hình bảo hiểm</strong>
                                    </p>
                                    <div class="clearfix"></div>
                                    <div class="progress-group" style="padding: 1px 8px">
                                        <canvas id="contract_type" style="height:300px;width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div style="border: #e6e6e6 1px solid; height: 100%">
                                    <p class="text-center" style="background: #92D050; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
                                        <strong>Nguồn khách hàng</strong>
                                    </p>
                                    <div class="clearfix"></div>
                                    <div class="progress-group" style="padding: 1px 8px">
                                        <canvas id="customer_source" style="height:300px;width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!--số hợp đồng chưa thanh toán-->
        </div>


    </section>
@stop

@section('scripts')
<script src="{{ asset('js/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('js/chartjs/chart.pieceLabel.min.js') }}"></script>
<script src="{{asset('/js/articleChartReport.js')}}"></script>
    <script>

        function addCommas(nStr)
        {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges   : {
                    'Hôm nay'       : [moment(), moment()],
                    'Hôm qua'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 ngày trước' : [moment().subtract(6, 'days'), moment()],
                    '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                    'Tháng này'  : [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment(),
                locale: {
                    customRangeLabel: 'Thời gian khác',
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Hủy',
                    applyLabel: 'Chọn'
                }
            },
            function (start, end) {
                var myUrl = window.location.pathname;
                window.location = myUrl+'?start='+start.format('YYYY-MM-DD')+'&end='+end.format('YYYY-MM-DD');
                $('#daterange-btn span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            }
        )

        function createChart(id, type, labelArray, DataArray, ColorArray) {
            var data = {
                labels: labelArray,
                datasets: [
                    {
                        label: 'My First dataset',
                        data: DataArray,
                        backgroundColor: ColorArray
                    }
                ]
            };
            new Chart(document.getElementById(id), {
                type: type,
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    pieceLabel: {
                        render: 'percentage'
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var value = data.datasets[0].data[tooltipItem.index];
                                value = data.labels[tooltipItem.index] + ' : ' + addCommas(value);
                                return value;
                            }
                        } // end callbacks:
                    } //end tooltips
                }
            });
        }

        //two type: 'pie', 'doughnut'

        //- BAR CHART -
        //-------------

        //charjs.org
        var ctx = document.getElementById("contractChart").getContext('2d');


    </script>

@endsection
