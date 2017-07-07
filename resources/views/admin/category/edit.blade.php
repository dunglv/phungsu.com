@extends('admin.index') @section('title', 'Tạo mới chủ đề') 
@section('b-script')
    {!!Html::style('/public/js/lib/jq-ui.css')!!}
    {!!Html::script('/public/js/handle-string.js')!!}
@stop 
@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="" style="font-weight: 900;text-align: center;margin-bottom: 30px">Tạo chủ đề mới</h3>
    </div>
    {{-- Show message  --}}
    @if(session()->has('status')) 
        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-{{session()->get('label')}}">
                <strong style="text-transform: capitalize;">{{session()->get('label')}}!</strong> {{session()->get('message')}} {{session()->get('label')}} 
            </div>
            
        </div>
    @endif
    {{-- end show message --}}
    {!!Form::open(array( 'route' => 'ad.cate.create_store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true ))!!}
    <div class="col-md-9">

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Tiêu đề</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @if(!empty($errors->first('title'))) error-box @endif" name="title" id="inputEmail3" placeholder="Nhập tiêu đề bài viết..." required="required" value="{{$category->title}}">
                @if($errors->count() > 0)<span class="error">{{$errors->first('title')}}</span>@endif
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Slug</label>
            <div class="col-sm-10">
                <input type="text" readonly="true" class="form-control" name="slug" id="inputPassword3" placeholder="Slug display in browser" value="{{$category->slug}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Mô tả</label>
            <div class="col-sm-10">
                <textarea name="description" id="input" class="form-control @if(!empty($errors->first('description'))) error-box @endif" rows="3"  placeholder="Nhập mô tả ngắn gọn về bài viết...">{{$category->description}}</textarea>
                @if($errors->count() > 0)<span class="error">{{$errors->first('description')}}</span>@endif
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Ảnh</label>
            <div class="col-sm-10">
                <input type="file" class="form-control @if(!empty($errors->first('thumbnail'))) error-box @endif" name="thumbnail" id="inputEmail3" value="{{old('thumbnail')}}" placeholder="Email">
                 @if($errors->has('thumbnail') > 0)<span class="error">{{$errors->first('thumbnail')}}</span>@endif
            </div>
        </div>
        
    </div>
    <div class="col-md-3">
        <div class="sidebar">
            <div class="bl-sc">
                <div class="bl-t">Hoạt động</div>
                <div class="bl-ct">
                    <div class="radio">
                        <div class="bl-s-t">Cho phép bình luận</div>
                        <div class="radio-two">
                            <input type="radio" name="opencomment" data-text="on"  value="1" checked="checked" >
                            <input type="radio" name="opencomment" data-text="off"  value="0">
                        </div>
                        
                    </div>
                </div>
                <div class="bl-ct">
                    <div class="radio">
                        <div class="bl-s-t">Cho phép chỉnh sửa</div>
                        <div class="radio-two">
                            <input type="radio" name="openedit" data-text="on" value="1">
                            <input type="radio" name="openedit"  data-text="off" value="0" checked="checked">
                        </div>
                            
                    </div>
                </div>
                <div class="bl-ct">
                    <div class="radio">
                        <div class="bl-s-t">Nhận thông báo từ bài viết</div>
                        <div class="radio-two">
                            <input type="radio" name="notify" data-text="on" value="1">
                            <input type="radio" name="notify" data-text="off" value="0" checked="checked">
                        </div>
                    </div>
                </div>
                
                <div class="bl-ct">
                    <button type="submit" class="btn btn-sm btn-success">Lưu</button>
                    <button type="button" class="btn btn-sm btn-danger">Hủy bỏ</button>
                </div>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>
<script>
    $(function(){
        $('input[name="title"]').on('change', function(e){
            var t = slug($(this).val());
                $('input[name="slug"]').val(t);
        });
        $('.bl-tag').on('click', function(){
            $(this).children('.tag-in').focus();
        });
        var dt;
        // var dt =[{"label": "gdgjdhhd", "id": 1}];
    });
</script>
@stop
