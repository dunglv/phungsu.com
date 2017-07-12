@extends('admin.index') @section('title', 'Thay đổi quyền người dùng') 
@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="" style="font-weight: 900;text-align: center;margin-bottom: 30px">Phân quyền cho người dùng</h3>
    </div>
    {!!Form::open(array( 'route' => ['ad.u.auth_update', $user->id], 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true ))!!}
    {{-- Show message  --}}
    @if(session()->has('status')) 
        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-{{session()->get('label')}} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong style="text-transform: capitalize;">{{session()->get('label')}}!</strong> {{session()->get('message')}} {{session()->get('label')}} 
            </div>
            
        </div>
    @endif
    {{-- end show message --}}
    <div class="col-md-9">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Quyền</label>
            <div class="col-sm-10">
                <select name="auth" class="form-control" required="required">
                    <option @if ($user->auth === '0') selected="selected" @endif value="0">Người dùng thông thường</option>
                    <option  @if ($user->auth === '1') selected="selected" @endif value="1">Quản lý</option>
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
@stop
