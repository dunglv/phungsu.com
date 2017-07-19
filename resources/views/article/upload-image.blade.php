@extends('index') @section('title', 'Đóng góp audio mới') 
{{-- @section('b-script')
    {!!Html::script('/public/js/handle-string.js')!!}
    {!!Html::script('/public/froala/js/froala_editor.min.js')!!}
    {!!Html::script('/public/froala/js/languages/vi.js')!!}
    {!!Html::script('/public/froala/js/plugins/font_family.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/font_size.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/image.min.js')!!}
    {!!Html::script('/public/froala/js/plugins/paragraph_format.min.js')!!}
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
@stop --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Beta Confirm</h3>
            </div>
            <div class="panel-body">
                Comming soon! Hiện tại chức năng này đang được nâng cấp và hoàn thiện hơn. Bạn vui lòng thực hiện điều này sau khi chúng tôi hoàn thiện website. Mọi ý kiến đóng góp của bạn sẽ là sự khuyến khích cho chúng tôi. Xin cảm ơn.
                <p style="margin-top: 10px"><a href="{{ route('ui.home') }}"><i class="fa fa-arrow-left"></i> Quay lại trang chủ</a></p>
            </div>
        </div>
    </div>
</div>
@stop
