@extends('layouts.admin_default')

@section('content')
    <section class="content-header">
        <h1>
            Thiết lập menu
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Thiết lập menu</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật menu</h3>
            </div>
            @if ($errors->any())
                <h4 style="color:red">{{$errors->first()}}</h4>
            @endif
        <!-- /.box-header -->
            <div class="box-body">
                {!! Form::open(['method' => 'PUT', 'route' => ['core.menu.update', $menu->id]]) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Loại menu</label>
                            {{ $menuType->name }}
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Tiêu đề</label>
                            <input name="title" type="text" class="form-control" value="{{ isset($menu) ? $menu->title : '' }}" placeholder="Nhập vào tiêu đề menu" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Liên kết</label>
                            <input name="external_url" type="text" value="{{ isset($menu) ? $menu->external_url : '' }}" class="form-control" placeholder="Nhập vào liên kết cho menu" required>
                        </div>

                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control select2" style="width: 100%;">
                                <option value=1 @if (isset($menu->status) && $menu->status == 1) selected @endif>Kích hoạt</option>
                                <option value=0 @if (isset($menu->status) && $menu->status == 0) selected @endif>Không sử dụng</option>
                                <option value=-1 @if (isset($menu->status) && $menu->status == -1) selected @endif>Đã xóa</option>
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <div class="box-footer">
                <a href="{{ route('core.menu.index') }}" class="btn btn-default pull-right">Hủy</a>
                {!! Form::button('Cập nhật', ['class' => 'btn btn-primary pull-left', 'type' => "submit"]) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection
