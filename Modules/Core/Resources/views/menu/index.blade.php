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
        <div class="row">
            <div class="col-xs-12">
                @if ($errors->any())
                    <h4 style="color:red">{{$errors->first()}}</h4>
                @endif
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="box-title">Quản lý menu</h3>
                            </div>
                        </div>
                        <div class="row">
                            <form method="get" action="{{ route('core.menu.index') }}">
                                <div class="col-md-3">
                                    <select name="type" class="form-control">
                                        @if (isset($menuTypes) && !empty($menuTypes))
                                            @foreach($menuTypes as $type)
                                                <option @if (isset($menuType) && $menuType->id == $type->id) selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3 text-left">
                                    <button type="submit" class="btn btn-primary">Chọn</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a class="btn btn-primary" href="{{ route('core.menu.create', isset($menuType->id) ? ['type' => $menuType->id] : []) }}">Thêm menu mới</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if (isset($menus) && !empty($menus))
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Liên kết</th>
                                        <th>Trạng thái</th>
                                        <th>Sửa</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menu)
                                    <tr>
                                        <td>{{ $menu->id }}</td>
                                        <td>{{ $menu->title }}</td>
                                        <td>{{ $menu->external_url }}</td>
                                        <td>{{ $menu->getStatusName() }}</td>
                                        <td>
                                            {!! Form::open(['method' => 'GET', 'route' => ['core.menu.edit', $menu->id]]) !!}
                                                <a href="#" class="btn btn-warning btn-xs" onclick="$(this).closest('form').submit();"><i class="fa fa-pencil"></i></a>
                                            {!! Form::close() !!}
                                        </td>
                                        <td>
                                            @if ($menuType->status != constant('Modules\Core\Models\Menu::STATUS_DELETED'))
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['core.menu.destroy', $menu->id]]) !!}
                                                    <a href="#" class="btn btn-danger btn-xs" onclick="if(confirm('Bạn có chắc muốn xóa bản ghi này không?')) $(this).closest('form').submit();"><i class="fa fa-trash"></i></a>
                                                {!! Form::close() !!}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            {{ $menus->links() }}
                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection
