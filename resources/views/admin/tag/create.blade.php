@extends('admin.index') @section('title', 'Tạo mới chủ đề') 
@section('b-script')
    {!!Html::style('/public/js/lib/jq-ui.css')!!}
    {!!Html::script('/public/js/handle-string.js')!!}
@stop 
@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="" style="font-weight: 900;text-align: center;margin-bottom: 30px">Tạo thẻ bài viết mới</h3>
    </div>
    {!!Form::open(array( 'route' => 'ad.tag.store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true ))!!}
    {{-- Show message  --}}
    @if(session()->has('status')) 
        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-{{session()->get('label')}}">
                <strong style="text-transform: capitalize;">{{session()->get('label')}}!</strong> {{session()->get('message')}} {{session()->get('label')}} 
            </div>
            
        </div>
    @endif
    {{-- end show message --}}
    <div class="col-md-9">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Thẻ</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @if(!empty($errors->first('title'))) error-box @endif" name="title" id="inputEmail3" placeholder="Nhập tiêu đề bài viết..." required="required" value="{{old('title')}}">
                @if($errors->count() > 0)<span class="error">{{$errors->first('title')}}</span>@endif
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Slug</label>
            <div class="col-sm-10">
                <input type="text" readonly="true" class="form-control" name="slug" id="inputPassword3" placeholder="Slug display in browser" value="{{old('slug')}}">
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
                            <input type="radio" name="active" data-text="on"  value="1" checked="checked" >
                            <input type="radio" name="active" data-text="off"  value="0">
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
