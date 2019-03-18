@extends('layouts.admin_default')
@section('title', 'Quản lý quyền')
@section('content')
    <section class="content-header">
        <h1>Quản lý quyền</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('core.role.index') }}"> Quản lý quyền</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm mới quyền</h3>
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
            {!! Form::open(['method' => 'POST', 'route' => ['core.role.store'], 'class' => 'validate']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Tên(*)</label>
                            <input name="name" type="text" value="{{ old('name') }}" class="form-control" placeholder="Nhập vào tên quyền" required>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <div class="col-md-6">
                        <h4>Chọn quyền hạn</h4>
                        <!-- /.form-group -->
                        @foreach ($permissions as $permission)
                        <?php
                            $arr = [];
                        ?>
                        <section>
                            <label>{{ $permission['name'] }}</label>
                            <div class="form-group">
                            @foreach ($permission['actions'] as $action)
                                @if (!in_array($action["id"], $arr))
                                    <?php
                                        array_push($arr, $action["id"]);
                                    ?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permissions[]" class="minimal" value="{{$action['id']}}" {{ old('permissions') !== null && in_array($pId, old('permissions')) ? 'checked' : '' }}>
                                            {{ $action["name"] }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                            </div>
                        </section>
                        @endforeach
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <div class="box-footer">
                <a href="/admin/role" class="btn btn-default pull-right">Hủy</a>
                {!! Form::button('Thêm mới', ['class' => 'btn btn-primary pull-left', 'type' => "submit"]) !!}
            </div>
            {!! Form::close() !!}
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </section>
@endsection
