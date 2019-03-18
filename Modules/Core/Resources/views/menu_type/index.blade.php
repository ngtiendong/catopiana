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
                        <h3 class="box-title">Loại menu</h3>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('core.menu_type.create') }}">Thêm loại mới</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Loại menu</th>
                                    <th>Tên</th>
                                    <th>Trạng thái</th>
                                    <th>Sửa</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menuTypes as $menuType)
                                <tr>
                                    <td>{{ $menuType->id }}</td>
                                    <td>{{ $menuType->code }}</td>
                                    <td>{{ $menuType->name }}</td>
                                    <td>{{ $menuType->getStatusName() }}</td>
                                    <td>
                                        {!! Form::open(['method' => 'GET', 'route' => ['core.menu_type.edit', $menuType->id]]) !!}
                                            <a href="#" class="btn btn-warning btn-xs" onclick="$(this).closest('form').submit();"><i class="fa fa-pencil"></i></a>
                                        {!! Form::close() !!}
                                    </td>
                                    <td>
                                        @if ($menuType->status != constant('Modules\Core\Models\MenuType::STATUS_DELETED'))
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['core.menu_type.destroy', $menuType->id]]) !!}
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
                        {{ $menuTypes->links() }}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection
