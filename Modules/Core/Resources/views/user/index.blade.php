@extends('layouts.admin_default')
@section('title', 'Quản lý người dùng')
@section('content')
    <section class="content-header">
        <h1>Quản lý người dùng</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Danh sách người dùng</li>
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
                        <h3 class="box-title">Danh sách người dùng</h3>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="/admin/user/create">Thêm người dùng</a>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th class="text-center">Bàn giao</th>
                                    <th class="text-center">Đặt lại mật khẩu</th>
                                    <th class="text-center">Sửa</th>
                                    <th class="text-center">Xóa</th>
                                    <th class="text-center">Khôi phục</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-success btn-sm" id="btnOpenCustomerMove" href="javascript:void(0)" onclick="return customerHelper.moveManager({{$user->id}});"><i class="fa fa-user"></i> Bàn giao người quản lý</a>
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open(['method' => 'POST', 'route' => ['core.user.reset_password', $user->id]]) !!}
                                            <a href="#" class="btn btn-danger btn-xs"  onclick="$(this).closest('form').submit();"><i class="fa fa-refresh"></i></a>
                                        {!! Form::close() !!}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('core.user.edit', $user->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        @if (!$user->deleted_at && $user->id != 1)
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['core.user.destroy', $user->id]]) !!}
                                            <a href="#" class="btn btn-danger btn-xs"  onclick="if(confirm('Bạn có chắc muốn xóa bản ghi này không?')) $(this).closest('form').submit();"><i class="fa fa-trash"></i></a>
                                        {!! Form::close() !!}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($user->deleted_at)
                                        {!! Form::open(['method' => 'POST', 'route' => ['core.user.restore', $user->id]]) !!}
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
                        {{ $users->appends($params)->links() }}
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
@section('scripts')
    <script type="text/javascript">

        var customerHelper = (function () {
            return {
                moveManager : function (user_id) {
                    btn_loading.loading('btnOpenCustomerMove');
                    $.post('/admin/user/move', {user_id : user_id}, function (result) {
                        btn_loading.hide('btnOpenCustomerMove');
                        dialog.show('Bàn giao người quản lý', result);
                    });
                }
            }
        })();
    </script>
@endsection
