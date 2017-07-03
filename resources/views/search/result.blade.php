@extends('index') @section('content')
<div class="row">
    <div class="col-md-10">
        <div class="row">
            @if(isset($articles) && $articles->count() > 0)
                @foreach($articles as $a)
                <div class="col-md-6">
                    <div class="h-item">
                        <div class="h-thumb">
                            @if(empty($a->thumbnail) && $a->format === 0)
                                <img src="{{ url('/public/images/ui/logo.png') }}" alt="{{$a->title}}">
                            @elseif($a->format > 0)
                                <span><i class="fa fa-music"></i></span>
                            @else
                                <img src="{{$a->thumbnail}}" alt="{{$a->title}}">
                            @endif
                        </div>
                        <div class="h-i-item">
                            @if($a->format === 0)
                                <h3><a href="{{route('ui.article.detail', $a->slug)}}">{{$a->title}}</a></h3>
                            @elseif($a->format === 1)
                                <h3><a href="{{route('ui.article.detail-mp3', $a->slug)}}">{{$a->title}}</a></h3>
                            @endif
                            <div class="h-desc">
                                @if(empty($a->description))
                                    {{str_limit($a->content, 150, '...')}}
                                @else
                                    {{str_limit($a->description, 150, '...')}}
                                @endif
                            </div>
                            <div class="h-sta">
                                @foreach($a->tags as $t)
                                    <a href="{{ route('ui.tag.detail', $t->slug) }}" class="t-tag">{{$t->title}}</a>
                                @endforeach
                                
                                <div class="h-rr">
                                    <span><i class="fa fa-eye"></i> 1000</span>
                                    <span><i class="fa fa-heart"></i> 100</span>
                                    <span><i class="fa fa-comment"></i> 100</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-md-6">
                    Chưa có bài viết nào. Hãy trở thành người đầu tiên viết bài bằng việc click vào <a href="{{ route('ui.create') }}">đây</a> để được đề xuất lên trang chủ.
                </div>
            @endif
        </div>
        @if($articles->total() > 1)
        <div class="row">
            <div class="col-md-6">
                {{$articles->appends(['q' => \Request::get('q')])->links()}}
            </div>
        </div>
        @endif
    </div> {{-- end content--}}
    <div class="col-md-2">
        <div class="sidebar">
            <div class="bl-sc bl-tag">
                <div class="bl-t">TAGS</div>
                <div class="bl-ct">
                    <a href="#">tag1<span>10</span></a>
                    <a href="#">tag1<span>10</span></a>
                    <a href="#">tag1<span>10</span></a>
                    <a href="#">tag1<span>10</span></a>
                    <a href="#">tag1<span>10</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
