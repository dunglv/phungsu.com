@extends('index') 
@section('title', 'Đóng góp bài viết mới')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="mc-t" >Đóng góp bài viết mới</h3>
        <p class="mc-help"><i class="fa fa-question-circle-o"></i> Chọn một thể loại bài viết bạn muốn đóng góp để website dễ dàng phân loại và sắp xếp bài viết chính xác hơn</p>
    </div>
    <div class="col-md-12">
        <div class="hc-create">
            <a href="{{ route('ui.article.create-article') }}"><i class="fa fa-pencil"></i> Viết bài</a>
            <a href="{{ route('ui.article.upload-mp3') }}"><i class="fa fa-music"></i> Upload bài hát</a>
            <a href="{{ route('ui.article.upload-video') }}"><i class="fa fa-video-camera"></i> Upload Video</a>
            <a href="{{ route('ui.article.upload-image') }}"><i class="fa fa-camera"></i> Upload ảnh</a>
            <a href="#"><i class="fa fa-inbox"></i> Đóng góp ý kiến</a>
        </div>
        <div class="row">
            <div class="block-ss block-page-create">
                <div class="col-md-12">
                    <div class="block-tt">
                        <h3>Có thể bạn quan tâm</h3>
                    </div>
                </div>
                <div class="block-ct">
                    @foreach($articles as $ar)
                    <div class="col-md-6">
                        <div class="h-item h-horizontal">
                            <div class="h-thumb">
                                @if(empty($ar->thumbnail) && $ar->format === 0)
                                    <img src="{{ url('/public/images/ui/logo.png') }}" alt="{{$ar->title}}">
                                @elseif($ar->format > 0)
                                    <span><i class="fa fa-music"></i></span>
                                @else
                                    <img src="{{$ar->thumbnail}}" alt="{{$ar->title}}">
                                @endif
                            </div>
                            <div class="h-i-item">
                                @if($ar->format === 0)
                                    <h3><a href="{{route('ui.article.detail', $ar->slug)}}">{{$ar->title}}</a></h3>
                                @elseif($ar->format === 1)
                                    <h3><a href="{{route('ui.article.detail-mp3', $ar->slug)}}">{{$ar->title}}</a></h3>
                                @endif
                                <div class="h-desc">
                                    @if(empty($ar->description))
                                        {{str_limit($ar->content, 70, '...')}}
                                    @else
                                        {{str_limit($ar->description, 70, '...')}}
                                    @endif
                                </div>
                                <div class="h-sta">
                                    <div class="h-rr">
                                        <span><i class="fa fa-eye"></i> {{$ar->stat->view}}</span>
                                        <span><i class="fa fa-heart"></i> {{$ar->stat->like}}</span>
                                        <span><i class="fa fa-comment"></i> {{$ar->comments->count()}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
   
</div>
@stop
