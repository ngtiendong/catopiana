@extends('layouts.admin_default')
@section('title', 'Quản lý người dùng')
@section('content')
    <section class="content-header">
        <h1>Quản lý người dùng</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('core.user.index') }}"> Danh sách người dùng</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Chỉnh sửa người dùng</h3>
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
            {!! Form::open(['method' => 'PUT', 'route' => ['core.user.update', $user->id], 'class' => 'validate']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Email(*)</label>
                            <input name="email" type="email" value="{{$user->email}}" class="form-control" placeholder="Nhập vào email người dùng" required>
                        </div>
                        <div class="form-group">
                            <label>Username(*)</label>
                            <input name="username" type="textbox" value="{{$user->username}}" class="form-control" placeholder="Nhập vào tên người dùng" required>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Họ Tên</label>
                            <input name="fullname" type="text" class="form-control" value="{{$user->fullname}}" placeholder="Nhập tên người dùng..." required>
                        </div>
                        <div class="form-group">
                            <label>Điện thoại</label>
                            <input name="phone" type="text" class="form-control" value="{{$user->phone}}" placeholder="Nhập số điện thoại..." required>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Phân quyền người dùng</label>
                            {!! Form::select('roles[]', $roles, $user_roles, ['class'=>'form-control select2', 'multiple'=>'true']) !!}
                        </div>
                        <div class="form-group">
                            <label>Phân nhóm người dùng</label>
                            {!! Form::select('groups[]', $groups, $user_groups, ['class'=>'form-control select2', 'multiple'=>'true']) !!}
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <div class="box-footer">
                <a href="/admin/user" class="btn btn-default pull-right">Hủy</a>
                {!! Form::button('Cập nhật', ['class' => 'btn btn-primary pull-left', 'type' => "submit"]) !!}
            </div>
            {!! Form::close() !!}
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </section>
@endsection
