@extends('layouts.admin_default')
@section('title', 'Quản lý nhóm người dùng')
@section('content')
    <section class="content-header">
        <h1>Quản lý nhóm người dùng</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin_home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('core.group.index') }}"> Danh sách nhóm người dùng</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Chỉnh sửa nhóm người dùng</h3>
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
            {!! Form::open(['method' => 'PUT', 'route' => ['core.group.update', $group->id], 'class' => 'validate']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Tên(*)</label>
                            <input name="name" type="text" value="{{$group->name}}" class="form-control" placeholder="Nhập vào tên nhóm người dùng" required>
                        </div>
                        <div class="form-group">
                            <label>Loại nhóm(*)</label>
                            {!! Form::select('type', [
                                    0 => "Nhân viên công ty",
                                    1 => "Nhân viên đại lý"
                                ],
                                $group->type,
                                ['id' => 'selectType', 'class'=>'form-control select2', 'required'=>true]
                            ) !!}
                        </div>
                        @if ($group->type == 0)
                            <div class="form-group" id="typeCompany">
                                <label>Chọn công ty BH</label>
                                {!! Form::select('companies[]', $companies, $objectIds, ['class'=>'form-control select2', 'multiple'=>'true', 'style'=>'width: 100%']) !!}
                            </div>
                            <div class="form-group" id="typeAgency" style="display: none">
                                <label>Chọn đại lý BH</label>
                                {!! Form::select('agencies[]', $agencies, null, ['class'=>'form-control select2', 'multiple'=>'true', 'style'=>'width: 100%']) !!}
                            </div>
                        @else
                            <div class="form-group" id="typeCompany" style="display: none">
                                <label>Chọn công ty BH</label>
                                {!! Form::select('companies[]', $companies, null, ['class'=>'form-control select2', 'multiple'=>'true', 'style'=>'width: 100%']) !!}
                            </div>
                            <div class="form-group" id="typeAgency">
                                <label>Chọn đại lý BH</label>
                                {!! Form::select('agencies[]', $agencies, $objectIds, ['class'=>'form-control select2', 'multiple'=>'true', 'style'=>'width: 100%']) !!}
                            </div>
                        @endif
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <div class="box-footer">
                <a href="/admin/group" class="btn btn-default pull-right">Hủy</a>
                {!! Form::button('Cập nhật', ['class' => 'btn btn-primary pull-left', 'type' => "submit"]) !!}
            </div>
            {!! Form::close() !!}
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
<script src="{{ Module::asset('core:js/group_action.js') }}"></script>
@endsection
