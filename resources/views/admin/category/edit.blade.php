@extends('admin.index') @section('title', 'Cập nhật chủ đề chủ đề') 
@section('b-script')
    {!!Html::style('/public/js/lib/jq-ui.css')!!}
    {!!Html::script('/public/js/handle-string.js')!!}
@stop 
@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Quản lý <small>Cập nhật chủ đề</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Trang chủ
            </li>
            <li >
                Cập nhật chủ đề
            </li>
            <li>
                {{$category->title}}
            </li>
        </ol>
        {{-- Show message  --}}
       @if(session()->has('status'))
            <div class="alert alert-{{session()->get('alert')}}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>{{session()->get('label')}}!</strong> {{session()->get('message')}}
            </div>
        @endif
        {{-- end show message --}}
    </div>
    {!!Form::open(array( 'route' => ['ad.cate.create_update', $category->id], 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true ))!!}
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
                        <div class="bl-s-t">Kích hoạt bài viết</div>
                        <div class="radio-two">
                            <input type="radio" name="active" data-text="on"  value="1" checked="checked" >
                            <input type="radio" name="active" data-text="off"  value="0">
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
