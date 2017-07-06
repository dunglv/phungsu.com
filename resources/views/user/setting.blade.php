@extends('index') @section('title', 'Đóng góp bài viết mới') 
@section('title', 'Cài đặt tài khoản')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('user.sidebar')
    </div>
    {!!Form::open(array( 'route' => 'ui.user.update-detail', 'method' => 'POST', 'class' => '', 'files' => true ))!!}
        <div class="col-md-9">
            @if(session()->has('status'))
                <div class="alert alert-{{session()->get('label')}}">
                    <strong>Cập nhật thành công!</strong> Thông tin của bạn đã được thay đổi và cập nhật thành công.
                </div>
            @endif
            <div class="panel panel-default">
            	<div class="panel-heading">
            		<h3 class="panel-title">Dịch vụ</h3>
            	</div>
            	<div class="panel-body">
	    			<div class="form-group">
	    				<div class="checkbox">
	    					<label>
	    						<input type="checkbox" value="">
	    						Nhận thông báo khi đăng nhập vào website
	    					</label>
	    				</div>
	    				<div class="checkbox">
	    					<label>
	    						<input type="checkbox" value="">
	    						Nhận thông báo email khi có bài viết mới trên website
	    					</label>
	    				</div>
	    				<div class="checkbox">
	    					<label>
	    						<input type="checkbox" value="">
	    						Nhận thông báo về bài viết của tôi
	    					</label>
	    				</div>
	    				<div class="checkbox">
	    					<label>
	    						<input type="checkbox" value="">
	    						Nhận thông báo khi có sự thay đổi về tài khoản như cập nhật thông tin, thay đổi mật khẩu...
	    					</label>
	    				</div>
	    			</div>
            	</div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Tài khoản</h3>
                </div>
                <div class="panel-body">
                    <a href="{{ route('ui.user.deactivate') }}" class="btn btn-warning"><i class="fa fa-remove"></i> Xóa tất cả bài viết và comment của tôi</a>
                    <a href="{{ route('ui.user.deactivate') }}" class="btn btn-danger"><i class="fa fa-remove"></i> Xóa tài khoản</a>
                </div>
            </div>

            <div class="form-group ">
                <button type="submit" class="btn btn-success">Lưu thông tin</button>
            </div>
            
                
            
                
        </div>
    
    {!!Form::close()!!}
</div>

@stop
