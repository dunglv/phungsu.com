@extends('index') @section('title', 'Chỉnh sửa '.$article->title) 
@section('b-script')
    {!!Html::script('/public/js/handle-string.js')!!}
    {!!Html::script('/public/froala/js/froala_editor.min.js')!!}
    {!!Html::script('/public/froala/js/languages/vi.js')!!}
    {!!Html::script('/public/froala/js/plugins/font_family.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/font_size.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/image.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/paragraph_format.min.js')!!}
    {{-- {!!Html::script('/public/froala/js/plugins/paragraph_style.min.js')!!} --}}
    {!!Html::script('/public/froala/js/plugins/print.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/table.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/video.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/url.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/link.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/save.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/word_paste.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/emoticons.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/align.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/colors.min.js')!!}
@stop 
@section('style')
    {!!Html::style('/public/js/lib/jq-ui.css')!!}
    {!!Html::style('/public/froala/css/froala_editor.min.css')!!}
    {!!Html::style('/public/froala/css/plugins/video.min.css')!!}
    {!!Html::style('/public/froala/css/plugins/table.min.css')!!}
    {!!Html::style('/public/froala/css/plugins/draggable.min.css')!!}
    {!!Html::style('/public/froala/css/plugins/file.min.css')!!}
    {!!Html::style('/public/froala/css/plugins/image.min.css')!!}
    {!!Html::style('/public/froala/css/plugins/emoticons.min.css')!!}
    {!!Html::style('/public/froala/css/plugins/line_breaker.min.css')!!}
    {!!Html::style('/public/froala/css/plugins/colors.min.css')!!}
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="" style="font-weight: 900;text-align: center;margin-bottom: 30px;max-width: 70%;margin-left: auto;margin-right: auto;">Chỉnh sửa <a href="{{ route('ui.article.detail', $article->slug) }}" target="_blank">{{$article->title}}</a></h3>
    </div>
    {!!Form::open(array( 'route' => ['ui.article.edit-normal-update', $article->slug], 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true ))!!}
    <div class="col-md-9">
        @if(session()->has('status'))
            <div class="alert alert-{{session()->get('status')}}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>{{session()->get('label')}}!</strong> {{session()->get('message')}}
            </div>
        @endif
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Tiêu đề</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @if(!empty($errors->first('title'))) error-box @endif" name="title" id="inputEmail3" placeholder="Nhập tiêu đề bài viết..." required="required" value="{{$article->title}}">
                @if($errors->count() > 0)<span class="error">{{$errors->first('title')}}</span>@endif
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Slug</label>
            <div class="col-sm-10">
                <input type="text" readonly="true" class="form-control" name="slug" id="inputPassword3" placeholder="Slug display in browser" value="{{$article->slug}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Mô tả</label>
            <div class="col-sm-10">
                <textarea name="description" id="input" class="form-control @if(!empty($errors->first('description'))) error-box @endif" rows="3"  placeholder="Nhập mô tả ngắn gọn về bài viết...">{{$article->description }}</textarea>
                @if($errors->count() > 0)<span class="error">{{$errors->first('description')}}</span>@endif
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Nội dung</label>
            <div class="col-sm-10">
                <textarea name="content" id="content" class="form-control @if(!empty($errors->first('content'))) error-box @endif" rows="50" required="required" placeholder="Nội dung chi tiết bài viết...">{{$article->content}}</textarea>
                 @if($errors->has('content') > 0)<span class="error">{{$errors->first('content')}}</span>@endif
                 <div class="btn btn-success btn-preview" style="margin-top: 10px;"><i class="fa fa-eye"></i> Xem trước</div>
                 <div id="preview">
                    <div class="btn-close" title="Đóng xem trước"><i class="fa fa-remove"></i></div>
                     <div class="contain-preview">
                         @if(!empty($article->content))
                            {!!$article->content!!}
                         @else
                            <span style="color: #ccc;font-size:1.2em;">Chưa có nội dung để hiển thị</span
                         @endif
                     ></div>
                 </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Ảnh</label>
            <div class="col-sm-10">
                <input type="file" class="form-control @if(!empty($errors->first('thumbnail'))) error-box @endif" name="thumbnail" id="inputEmail3" value="{{old('thumbnail')}}" placeholder="Email">
                 @if($errors->has('thumbnail') > 0)<span class="error">{{$errors->first('thumbnail')}}</span>@endif
                 <input type="hidden" name="old_thumbnail" value="{{$article->thumbnail}}">
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
                                <option @if($article->category[0]->id == $c->id) selected="selected" @endif value="{{$c->id}}">{{$c->title}}</option>
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
                        @php
                            $t = '';
                        @endphp
                            @foreach($article->tags as $tag)
                                <span class="tag-i">{{$tag->title}}</span>
                                @php
                                    $t .= ','.$tag->id;
                                @endphp
                            @endforeach
                        </div>
                        <input type="text" class="tag-in">
                    </div>
                    @if($errors->has('tags') > 0)<span class="error">{{$errors->first('tags')}}</span>@endif
                    <input type="hidden" name="tags" value="{{trim($t, ',')}}">
                </div>
            </div>
            <div class="bl-sc">
                <div class="bl-t">Hoạt động</div>
                <div class="bl-ct">
                    <div class="radio">
                        <div class="bl-s-t">Cho phép bình luận</div>
                        <div class="radio-two">
                            <input type="radio" name="opencomment" data-text="on"  value="1" @if($article->opencomment == 1) checked="checked" @endif>
                            <input type="radio" name="opencomment" data-text="off"  value="0" @if($article->opencomment == 0) checked="checked" @endif>
                        </div>
                        
                    </div>
                </div>
                <div class="bl-ct">
                    <div class="radio">
                        <div class="bl-s-t">Cho phép chỉnh sửa</div>
                        <div class="radio-two">
                            <input type="radio" name="openedit" data-text="on" value="1" @if($article->openedit == 1) checked="checked" @endif>
                            <input type="radio" name="openedit"  data-text="off" value="0" @if($article->openedit == 0) checked="checked" @endif>
                        </div>
                            
                    </div>
                </div>
                <div class="bl-ct">
                    <div class="radio">
                        <div class="bl-s-t">Nhận thông báo từ bài viết</div>
                        <div class="radio-two">
                            <input type="radio" name="notify" data-text="on" value="1" @if($article->notify == 1) checked="checked" @endif>
                            <input type="radio" name="notify" data-text="off" value="0" @if($article->notify == 0) checked="checked" @endif>
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
<style>
  .class1 tbody tr:nth-child(2n) {
    background: #f9f9f9;
  }
 
  .class2 thead tr th, .class2 tbody tr td  {
    border-style: dashed;
  }
  .fr-view table td, .fr-view table th{
        border: 1px solid #dddddd;
  }
  table th, table td{
    padding: 2px 5px;
    vertical-align: middle;
  }
  .fr-view span.fr-emoticon {
    font-weight: normal;
    font-family: "Apple Color Emoji", "Segoe UI Emoji", "NotoColorEmoji", "Segoe UI Symbol", "Android Emoji", "EmojiSymbols";
    display: inline;
    line-height: 0;
}
.fr-view span.fr-emoticon.fr-emoticon-img {
    background-repeat: no-repeat !important;
    font-size: inherit;
    height: 1em;
    width: 1em;
    min-height: 20px;
    min-width: 20px;
    display: inline-block;
    margin: -0.1em 0.1em 0.1em;
    line-height: 1;
    vertical-align: middle;
}
</style>
<script>
    $(function(){
        $('#content').froalaEditor({
            heightMin: 300,
            language: 'vi',
              fontFamilySelection: true,
              fontSizeSelection: true,
              paragraphFormatSelection: true,
              imageEditButtons: ['imageDisplay', 'imageAlign', 'imageInfo', 'imageRemove'],
               tableStyles: {
                    class1: 'Class 1',
                    class2: 'Class 2'
                  },
        }).on('froalaEditor.contentChanged', function (e, editor) {
              $('.contain-preview').html(editor.html.get());
            });
        $('.btn-preview').on('click', function(){
            if ($('#preview').hasClass('display')) {
                $('#preview').removeClass('display');
            }else{
                $('#preview').addClass('display')
            }
        });
        $('#preview').on('click', function(e){
            if (e.target == this) {
                $('#preview').removeClass('display');
            }
        });
        $('.btn-close').on('click', function(e){
            $('#preview').removeClass('display');
        });

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
        // console.log(dt);
        $('.tag-in').autocomplete({
           
            source: dt,
            search: function(e, ui){
                console.log(dt);
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
