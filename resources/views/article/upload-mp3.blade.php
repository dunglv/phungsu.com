@extends('index') 
@section('b-script')
    {!!Html::style('/public/js/lib/jq-ui.css')!!}
    {!!Html::script('/public/js/handle-string.js')!!}
@stop 
@section('title', 'Đóng góp bài viết mới')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="" style="font-weight: 900;text-align: center;margin-bottom: 30px">Đóng góp bài nhạc mới</h3>
    </div>
    {!!Form::open(array( 'route' => 'ui.article.upload-mp3-store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true ))!!}
    <div class="col-md-9">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Tiêu đề</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @if(!empty($errors->first('title'))) error-box @endif" name="title" id="inputEmail3" placeholder="Nhập tiêu đề bài hát..." required="required" value="{{old('title')}}">
                    @if($errors->count() > 0)<span class="error">{{$errors->first('title')}}</span>@endif
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Slug</label>
                <div class="col-sm-10">
                    <input type="text" readonly="true" class="form-control" name="slug" id="inputPassword3" placeholder="Slug url..." value="{{old('slug')}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label ">Tác giả</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @if(!empty($errors->first('author'))) error-box @endif" name="author" id="inputEmail3" placeholder="Tác giả bài hát...">
                     @if($errors->count() > 0)<span class="error">{{$errors->first('author')}}</span>@endif
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Mô tả</label>
                <div class="col-sm-10">
                <textarea name="description" id="input" class="form-control @if(!empty($errors->first('description'))) error-box @endif" rows="3" placeholder="Nhập mô tả ngắn gọn về bài hát...">{{old('description')}}</textarea>
                @if($errors->count() > 0)<span class="error">{{$errors->first('description')}}</span>@endif
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Lời bài hát</label>
                <div class="col-sm-10">
                <textarea name="content" id="input" class="form-control @if(!empty($errors->first('content'))) error-box @endif" rows="10" required="required" placeholder="Nội dung chi tiết bài viết...">{{old('content')}}</textarea>
                 @if($errors->count() > 0)<span class="error">{{$errors->first('content')}}</span>@endif
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Tải nhạc</label>
                <div class="col-sm-10">
                    <input type="file" name="audio" class="form-control @if(!empty($errors->first('audio'))) error-box @endif" id="inputEmail3" placeholder="Email" value="{{old('audio')}}">
                    @if($errors->has('audio') > 0)<span class="error">{{$errors->first('audio')}}</span>@endif
                </div>
            </div>
             @if(\Session::has('flash_error')) <span class="error">Add new article was failed</span>@endif
         @if(\Session::has('flash_success')) <span class="success">Add new article successful</span>@endif
    </div>
    <div class="col-md-3">
        <div class="sidebar">
            <div class="bl-sc">
                <div class="bl-t">Nằm trong mục</div>
                <div class="bl-ct">
                      <select name="category" id="input" class="form-control @if(!empty($errors->first('category'))) error-box @endif">
                        <option value="0">-- Select One --</option>
                        @if (isset($cates) && $cates->count() > 0) 
                            @foreach ($cates as $c)
                                <option @if(old('category') == $c->id) selected="selected" @endif value="{{$c->id}}">{{$c->title}}</option>
                            @endforeach
                        @endif
                    </select>
                     @if($errors->has('category') > 0)<span class="error">{{$errors->first('category')}}</span>@endif
                </div>
            </div>
            <div class="bl-sc">
                <div class="bl-t">Tag</div>
                <div class="bl-ct">
                    <div class="bl-tag @if(!empty($errors->first('tags'))) error-box @endif">
                        <div class="bl-l-tag">
                            
                        </div>
                        <input type="text" class="tag-in">
                    </div>
                    @if($errors->has('tags') > 0)<span class="error">{{$errors->first('tags')}}</span>@endif
                    <input type="hidden" name="tags">
                   {{--  <textarea name="tags" id="inputTags" class="form-control" rows="3" required="required" placeholder="Nhập môt vài tag liên quan bài viết..."></textarea> --}}
                </div>
            </div>
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
        $.ajax({
            async: false,
            type: 'GET',
            url: '{{ route('ui.article.handle-req') }}',
            data: {'q':'l-t-t'},
            success: function(data){
                dt =  data.l;
            }
        });
        // $('.tag-in').on('keyup', function(e){
        //     if (e.keyCode === 188 && e.which === 188) {
        //         var t = $(this).val();
        //         t = t.replace(/(^\,+)/, '');
        //         t = t.replace(/(\,+$)/, '');
        //         if (t.length > 0) {
        //             $(this).val('').parent('.bl-tag').find('.bl-l-tag').append('<span class="tag-i">'+t+'</span>');
        //         }
        //     }
        // });
        $('.tag-in').autocomplete({
           
            source: dt,
            search: function(e, ui){
                
            },
            
            response: function(e, ui){
                // console.log(ui);
            },
            
            close: function(e, ui){
                console.log('close');
            }, 
            focus: function(e, ui){
                console.log('focus');
            },
            open: function(e, ui){
                // console.log(ui);
            },
            select: function(e, ui){
                // console.log(ui);
                var atag = $('input[name="tags"]').val();

                $(this).parent('.bl-tag').find('.bl-l-tag').append('<span class="tag-i">'+ui.item.label+'</span>');
                $('.tag-in').val('');
                atag += ','+ui.item.id;
                $('input[name="tags"]').val(atag.replace(/^\,+/, ''));
            }

        });
    });
</script>
@stop
