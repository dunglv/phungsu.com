@extends('index') @section('title', 'Đóng góp bài viết mới') 
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
        <h3 class="" style="font-weight: 900;text-align: center;margin-bottom: 30px">Đóng góp bài viết mới</h3>
    </div>
    {!!Form::open(array( 'route' => 'ui.article.create-normal-store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true ))!!}
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
                <input type="text" class="form-control @if(!empty($errors->first('title'))) error-box @endif" name="title" id="inputEmail3" placeholder="Nhập tiêu đề bài viết..." required="required" value="{{old('title')}}">
                @if($errors->count() > 0)<span class="error">{{$errors->first('title')}}</span>@endif
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Alias</label>
            <div class="col-sm-10">
                <input type="text" readonly="true" class="form-control" name="slug" id="inputPassword3" placeholder="Slug sẽ hiển thị trên thanh address trình duyệt" value="{{old('slug')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Mô tả</label>
            <div class="col-sm-10">
                <textarea name="description" id="input" class="form-control @if(!empty($errors->first('description'))) error-box @endif" rows="3"  placeholder="Nhập mô tả ngắn gọn về bài viết...">{{old('description')}}</textarea>
                @if($errors->count() > 0)<span class="error">{{$errors->first('description')}}</span>@endif
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Nội dung</label>
            <div class="col-sm-10">
                <textarea name="content" id="content" class="form-control @if(!empty($errors->first('content'))) error-box @endif" rows="50" required="required" placeholder="Nội dung chi tiết bài viết...">{{old('content')}}</textarea>
                 @if($errors->has('content') > 0)<span class="error">{{$errors->first('content')}}</span>@endif
                 <div class="btn btn-success btn-preview" style="margin-top: 10px;"><i class="fa fa-eye"></i> Xem trước</div>
                 <div id="preview">
                    <div class="btn-close" title="Đóng xem trước"><i class="fa fa-remove"></i></div>
                     <div class="contain-preview"><span style="color: #ccc;font-size:1.2em;">Chưa có nội dung để hiển thị</span></div>
                 </div>
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
                    <select name="" id="" class="tag-select-in" multiple="multiple" style="width: 100%;border: 1px solid #ccc;display: block;">
                        @foreach($tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->title}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('tags') > 0)<span class="error">{{$errors->first('tags')}}</span>@endif
                    <input type="hidden" name="tags" value="{{old('tags')}}">
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
                    <input type="hidden" name="format" value="0">
                    <button type="submit" class="btn btn-sm btn-success">Lưu</button>
                    <a href="{{ url('/') }}" title="Quay lại trang chủ" class="btn btn-sm btn-danger">Hủy bỏ</a>
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
        // $('.bl-tag').on('click', function(){
        //     $(this).children('.tag-in').focus();
        // });
        
        $('.tag-select-in').select2({
            placeholder: 'Chọn một thẻ...',
        }).on('select2:select', function(evt, e){
                var atag = $('input[name="tags"]').val();
                atag += ','+evt.params.data.id;
                $('input[name="tags"]').val(atag.replace(/^\,+/, ''));
        })
        .val(JSON.parse('['+$('input[name="tags"]').val()+']')).trigger('change')
        .on('select2:unselect', function(evt){
            var atag = $('input[name="tags"]').val();
            var rg = new RegExp('\,'+evt.params.data.id+'|'+evt.params.data.id+'\,|^'+evt.params.data.id+'$', 'g');
            atag = atag.replace(rg, '');
            $('input[name="tags"]').val(atag.replace(/^\,+/, ''));
        });
    });
</script>
@stop
