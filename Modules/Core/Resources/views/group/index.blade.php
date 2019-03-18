@extends('layouts.admin_default')
@section('title', 'Quản lý nhóm người dùng')
@section('content')
    <section class="content-header">
        <h1>Quản lý nhóm người dùng</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Danh sách nhóm người dùng</li>
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
                        <h3 class="box-title">Danh sách nhóm người dùng</h3>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="/admin/group/create">Thêm nhóm người dùng</a>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Loại nhóm</th>
                                    <th>Tên</th>
                                    <th class="text-center">Sửa</th>
                                    <th class="text-center">Xóa</th>
                                    <th class="text-center">Khôi phục</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $group)
                                <tr>
                                    <td>{{ $group->id }}</td>
                                    <td>{{ $group->getTypeName() }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('core.group.edit', $group->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        @if (!$group->deleted_at)
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['core.group.destroy', $group->id]]) !!}
                                            <a href="#" class="btn btn-danger btn-xs"  onclick="if(confirm('Bạn có chắc muốn xóa bản ghi này không?')) $(this).closest('form').submit();"><i class="fa fa-trash"></i></a>
                                        {!! Form::close() !!}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($group->deleted_at)
                                        {!! Form::open(['method' => 'POST', 'route' => ['core.group.restore', $group->id]]) !!}
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
                        {{ $groups->appends($params)->links() }}
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
