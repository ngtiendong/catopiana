<div class="col-md-3">
    <div style="border: #e6e6e6 1px solid; height: 100%">
        <p class="text-center" style="background: #0775c9; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
            <strong>Khách hàng</strong>
        </p>
        <p style="background: #7fabdc; height: 20px; padding: 1px 5px; color: #fff"><b class="pull-right">{{$total_customer}}</b></p>
        <div class="clearfix"></div>
        <div class="progress-group" style="padding: 1px 8px">
            <p>Khách hàng TIỀM NĂNG : {{number_format($kh_tiem_nang, 0)}}</p>
            <p>Khách hàng CƠ HỘI : {{number_format($kh_co_hoi, 0)}}</p>
            <p>Khách hàng MUA HÀNG : {{number_format($kh_mua_hang, 0)}}</p>
            <p>Khách hàng TÁI TỤC : {{number_format($kh_tai_tuc, 0)}}</p>
            <p>&nbsp;</p>
            <p class="text-center">
                <a href="{{route('insurance.customer.index')}}?type=moi&start={{$start}}&end={{$end}}" class="small-box-footer">
                    Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                </a>
            </p>
        </div>
    </div>
</div>
<!-- /.col -->
<div class="col-md-3">
    <div style="border: #e6e6e6 1px solid; height: 100%">
        <p class="text-center" style="background: #0775c9; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
            <strong>Tương tác</strong>
        </p>
        <p style="background: #7fabdc; height: 20px; padding: 1px 5px; color: #fff"><b class="pull-right">{{$kh_tiem_nang}}</b></p>
        <div class="clearfix"></div>
        <div class="progress-group" style="padding: 1px 8px">
            <p>Gửi báo giá : {{number_format($total_quotations, 0)}}</p>
            <p>Gửi Email Marketing : 0</p>
            <p>SMS : 0</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="text-center">
                <a href="{{route('insurance.quotation.index')}}?type=tiem_nang&start={{$start}}&end={{$end}}" class="small-box-footer">
                    Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                </a>
            </p>
        </div>
    </div>
</div>
<!-- /.col -->
<div class="col-md-3">
    <div style="border: #e6e6e6 1px solid; height: 100%">
        <p class="text-center" style="background: #0775c9; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
            <strong>Doanh thu</strong>
        </p>
        <p style="background: #7fabdc; height: 20px; padding: 1px 5px; color: #fff"><b class="pull-right">0</b></p>
        <div class="clearfix"></div>
        <div class="progress-group" style="padding: 1px 8px">
            <p>Doanh thu sales : {{number_format($contract_sale)}} đ</p>
            <p>Doanh thu đại lý : {{number_format($contract_agence)}} đ</p>
            <p>Doanh thu đơn BH có hiệu lực : {{number_format($tong_doanh_thu_hieuluc)}} đ</p>
            <p>Doanh thu đơn BH chưa hiệu lực : {{number_format($tong_doanh_thu_khonghieuluc)}} đ</p>
            <p>&nbsp;</p>
            <p class="text-center">
                <a href="{{route('insurance.statistic.revenue')}}?start={{$start}}&end={{$end}}" class="small-box-footer">
                    Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                </a>
            </p>
        </div>
    </div>
</div>
<!-- /.col -->
<div class="col-md-3">
    <div style="border: #e6e6e6 1px solid; height: 100%">
        <p class="text-center" style="background: #0775c9; height: 40px; line-height: 40px; color: #fff; margin-bottom: 0px">
            <strong>Công nợ</strong>
        </p>
        <p style="background: #7fabdc; height: 20px; padding: 1px 5px; color: #fff"><b class="pull-right">0</b></p>
        <div class="clearfix"></div>
        <div class="progress-group" style="padding: 1px 8px">
            <p>Công nợ nhân viên : {{number_format($congno_nhanvien, 0)}} đ</p>
            <p>Công nợ đại lý : {{number_format($congno_daily, 0)}} đ</p>
            <p>Công nợ CTBH : {{number_format($congno_baohiem, 0)}} đ</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="text-center">
                <a href="{{route('insurance.statistic.debt_kh')}}?start={{$start}}&end={{$end}}" class="small-box-footer">
                    Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                </a>
            </p>
        </div>
    </div>
</div>
<!-- /.col -->