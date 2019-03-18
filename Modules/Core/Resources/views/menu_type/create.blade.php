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
                <h3 class="box-title">Thêm loại menu mới</h3>
            </div>
            @if ($errors->any())
                <h4 style="color:red">{{$errors->first()}}</h4>
            @endif
            <!-- /.box-header -->
            <div class="box-body">
            {!! Form::open(['method' => 'POST', 'route' => ['core.menu_type.store']]) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Mã loại</label>
                            <input name="code" type="text" class="form-control" placeholder="Nhập vào mã loại menu" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên loại</label>
                            <input name="name" type="text" class="form-control" placeholder="Nhập vào tên loại menu" required>
                        </div>

                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control select2" style="width: 100%;">
                                <option value=1 selected="selected">Kích hoạt</option>
                                <option value=0>Không sử dụng</option>
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <div class="box-footer">
                <a href="{{ route('core.menu_type.index') }}" class="btn btn-default pull-right">Hủy</a>
                {!! Form::button('Thêm mới', ['class' => 'btn btn-primary pull-left', 'type' => "submit"]) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection
