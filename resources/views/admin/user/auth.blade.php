@extends('admin.index') @section('title', 'Thay đổi quyền người dùng') @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                    Quản lý <small>Thành viên đã khóa</small>
                </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Trang chủ
                </li>
                <li>
                    Thành viên đã khóa
                </li>
            </ol>
            {{-- Show message --}} @if(session()->has('status'))
            <div class="alert alert-{{session()->get('alert')}}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>{{session()->get('label')}}!</strong> {{session()->get('message')}}
            </div>
            @endif {{-- end show message --}}
        </div>
        {!!Form::open(array( 'route' => ['ad.u.auth_update', $user->id], 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true ))!!}
        <div class="col-md-9">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Quyền</label>
                <div class="col-sm-10">
                    <select name="auth" class="form-control" required="required">
                        <option @if ($user->auth === '0') selected="selected" @endif value="0">Người dùng thông thường</option>
                        <option @if ($user->auth === '1') selected="selected" @endif value="1">Quản lý</option>
                    </select>
                    @if($errors->count() > 0)<span class="error">{{$errors->first('auth')}}</span>@endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-md-offset-1">
                    <div class="bl-ct">
                        <button type="submit" class="btn btn-sm btn-success">Lưu</button>
                        <button type="button" class="btn btn-sm btn-danger">Hủy bỏ</button>
                    </div>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>
@stop
