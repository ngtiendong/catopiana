@extends('layouts.admin_default')
@section('title', 'Quản lý quyền')
@section('content')
    <section class="content-header">
        <h1>Quản lý quyền</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Danh sách quyền</li>
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
                        <h3 class="box-title">Danh sách quyền</h3>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="/admin/role/create">Thêm quyền</a>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th class="text-center">Sửa</th>
                                    <th class="text-center">Xóa</th>
                                    <th class="text-center">Khôi phục</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('core.role.edit', $role->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        @if (!$role->deleted_at)
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['core.role.destroy', $role->id]]) !!}
                                            <a href="#" class="btn btn-danger btn-xs"  onclick="if(confirm('Bạn có chắc muốn xóa bản ghi này không?')) $(this).closest('form').submit();"><i class="fa fa-trash"></i></a>
                                        {!! Form::close() !!}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($role->deleted_at)
                                        {!! Form::open(['method' => 'POST', 'route' => ['core.role.restore', $role->id]]) !!}
                                            <a href="#" class="btn btn-danger btn-xs"  onclick="$(this).closest('form').submit();"><i class="fa fa-reply"></i></a>
                                        {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                        {{ $roles->appends($params)->links() }}
                    </div>
                    <!-- /.box-body -->
                    <div class="overlay hide">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection
