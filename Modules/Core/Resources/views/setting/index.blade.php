@extends('layouts.admin_default')
@section('title', 'Thiết lập hệ thống')
@section('content')
    <section class="content-header">
        <h1>
            Thiết lập hệ thống
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Thiết lập</li>
        </ol>
    </section>
    <section class="content">
        {!! Form::open(['method' => 'POST', 'route' => ['core.settings.update']]) !!}
        @if ($errors->any())
            <h4 style="color:red">{{$errors->first()}}</h4>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3>Thông tin liên hệ</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Điện thoại liên hệ</label>
                            <input type="text" class="form-control" name="website_phone" value="{{ isset($settings['website_phone']) ? $settings['website_phone'] : '' }}"/>
                        </div>
                        <div class="form-group">
                            <label>Website Email</label>
                            <input type="text" class="form-control" name="website_email" value="{{ isset($settings['website_email']) ? $settings['website_email'] : '' }}"/>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề website</label>
                            <input type="text" class="form-control" name="website_title" value="{{ isset($settings['website_title']) ? $settings['website_title'] : '' }}"/>
                        </div>
                        <div class="form-group">
                            <label>Hotline</label>
                            <input type="text" class="form-control" name="website_hotline" value="{{ isset($settings['website_hotline']) ? $settings['website_hotline'] : '' }}"/>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" class="form-control" name="website_address" value="{{ isset($settings['website_address']) ? $settings['website_address'] : '' }}"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3>Thông tin thanh toán</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        if (isset($settings['payment_info']) && !empty($settings['payment_info'])) {
                            $listPaymentInfo = json_decode($settings['payment_info'], true);
                        }
                        ?>
                        @if (isset($listPaymentInfo) && !empty($listPaymentInfo))
                            <?php $i = 0; ?>
                            @foreach($listPaymentInfo as $paymentInfo)
                                <div class="form-group">
                                    <label>Ngân hàng</label>
                                    <input type="text" class="form-control" name="payment_info[{{ $i }}][bank_name]" value="{{ isset($paymentInfo['bank_name']) ? $paymentInfo['bank_name'] : '' }}"/>
                                </div>
                                <div class="form-group">
                                    <label>Chủ tài khoản</label>
                                    <input type="text" class="form-control" name="payment_info[{{ $i }}][account_name]" value="{{ isset($paymentInfo['account_name']) ? $paymentInfo['account_name'] : '' }}"/>
                                </div>
                                <div class="form-group">
                                    <label>Số tài khoản</label>
                                    <input type="text" class="form-control" name="payment_info[{{ $i }}][account_number]" value="{{ isset($paymentInfo['account_number']) ? $paymentInfo['account_number'] : '' }}"/>
                                </div>
                                <?php $i++; ?>
                            @endforeach
                        @else
                            <div class="form-group">
                                <label>Ngân hàng</label>
                                <input type="text" class="form-control" name="payment_info[0][bank_name]" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Chủ tài khoản</label>
                                <input type="text" class="form-control" name="payment_info[0][account_name]" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Số tài khoản</label>
                                <input type="text" class="form-control" name="payment_info[0][account_number]" value=""/>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3>Email template</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        if (isset($settings['email_templates']) && !empty($settings['email_templates'])) {
                            $emailTemplates = json_decode($settings['email_templates'], true);
                        }
                        ?>
                        <div class="form-group">
                            <label>Gửi báo giá</label>
                            <textarea class="textarea" style="width: 100%; height: 200px; border: 1px solid #ddd; padding: 10px;" name="email_templates[insurance_quotation]">{!! isset($emailTemplates['insurance_quotation']) ? $emailTemplates['insurance_quotation'] : '' !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">@lang('core::general.update')</button>
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection