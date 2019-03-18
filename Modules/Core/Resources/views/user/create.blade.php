@extends('layouts.admin_default')
@section('title', 'Quản lý người dùng')
@section('content')
    <section class="content-header">
        <h1>Quản lý người dùng</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('core.user.index') }}"> Quản lý người dùng</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm mới người dùng</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            {!! Form::open(['method' => 'POST', 'route' => ['core.user.store'], 'class' => 'validate']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Email(*)</label>
                            <input name="email" type="email" value="{{ old('email') }}" class="form-control" placeholder="Nhập vào email người dùng" required>
                        </div>
                        <div class="form-group">
                            <label>Username(*)</label>
                            <input name="username" type="textbox" value="{{ old('username') }}" class="form-control" placeholder="Nhập vào tên người dùng" required>
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu(*)</label>
                            <input name="password" type="password" class="form-control" placeholder="Nhập vào password người dùng" required>
                        </div>
                        <div class="form-group">
                            <label>Nhập lại mật khẩu(*)</label>
                            <input name="password_confirmation" type="password" class="form-control" placeholder="Nhập vào password người dùng" required>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Họ Tên</label>
                            <input name="fullname" type="text" class="form-control" placeholder="Nhập tên người dùng..." required>
                        </div>
                        <div class="form-group">
                            <label>Điện thoại</label>
                            <input name="phone" type="text" class="form-control" placeholder="Nhập số điện thoại..." required>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Phân quyền người dùng</label>
                            {!! Form::select('roles[]', $roles, old('roles[]'), ['class'=>'form-control select2', 'multiple'=>'true']) !!}
                        </div>
                        <div class="form-group">
                            <label>Phân nhóm người dùng</label>
                            {!! Form::select('groups[]', $groups, old('groups[]'), ['class'=>'form-control select2', 'multiple'=>'true']) !!}
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <div class="box-footer">
                <a href="/admin/user" class="btn btn-default pull-right">Hủy</a>
                {!! Form::button('Thêm mới', ['class' => 'btn btn-primary pull-left', 'type' => "submit"]) !!}
            </div>
            {!! Form::close() !!}
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </section>
@endsection
