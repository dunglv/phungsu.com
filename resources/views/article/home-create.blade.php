@extends('index') 
@section('title', 'Đóng góp bài viết mới')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="" style="font-weight: 900;text-align: center;margin-bottom: 30px">Đóng góp bài viết mới</h3>
        
    </div>
    <div class="col-md-12">
        <div class="hc-create">
            <a href="{{ route('ui.article.create-article') }}"><i class="fa fa-pencil"></i> Viết bài</a>
            <a href="{{ route('ui.article.upload-mp3') }}"><i class="fa fa-music"></i> Upload bài hát</a>
            <a href="{{ route('ui.article.upload-video') }}"><i class="fa fa-video-camera"></i> Upload Video</a>
            <a href="{{ route('ui.article.upload-image') }}"><i class="fa fa-camera"></i> Upload ảnh</a>
            <a href="#"><i class="fa fa-inbox"></i> Đóng góp ý kiến</a>
        </div>
    </div>
    {{-- <div class="col-md-3">
    	<div class="sidebar">
    		<div class="bl-sc">
    			<div class="bl-t">Nằm trong mục</div>
    			<div class="bl-ct">
    				<select name="" id="input" class="form-control">
                        <option value="">-- Select One --</option>
                    </select>
    			</div>
    		</div>
            <div class="bl-sc">
                <div class="bl-t">Tag</div>
                <div class="bl-ct">
                    <textarea name="tags" id="inputTags" class="form-control" rows="3" required="required" placeholder="Nhập môt vài tag liên quan bài viết..."></textarea>
                </div>
            </div>
    		<div class="bl-sc">
    			<div class="bl-t">Hoạt động</div>
    			<div class="bl-ct">
    				<div class="radio">
    					<div class="bl-s-t">Cho phép bình luận</div>
    					<label>
    						<input type="radio" name="opencoment" id="inputOpencoment" value="" checked="checked">
    						Enable
    					</label>
    					<label>
    						<input type="radio" name="opencoment" id="inputOpencoment" value="" checked="checked">
    						Disable
    					</label>
    				</div>
    			</div>
    			<div class="bl-ct">
    				<div class="radio">
    					<div class="bl-s-t">Cho phép chỉnh sửa</div>
    					<label>
    						<input type="radio" name="openedit" id="inputOpencoment" value="" checked="checked">
    						Enable
    					</label>
    					<label>
    						<input type="radio" name="openedit" id="inputOpencoment" value="" checked="checked">
    						Disable
    					</label>
    				</div>
    			</div>
    			<div class="bl-ct">
    				<div class="radio">
    					<div class="bl-s-t">Nhận thông báo từ bài viết</div>
    					<label>
    						<input type="radio" name="notify" id="inputOpencoment" value="" checked="checked">
    						Enable
    					</label>
    					<label>
    						<input type="radio" name="notify" id="inputOpencoment" value="" checked="checked">
    						Disable
    					</label>
    				</div>
    			</div>
    			<div class="bl-ct">
    				<button type="button" class="btn btn-sm btn-success">Lưu</button>
    				<button type="button" class="btn btn-sm btn-danger">Hủy bỏ</button>
    			</div>
    		</div>
    	</div>
    </div> --}}
</div>
@stop
