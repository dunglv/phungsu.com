@extends('index') @section('content')
<div class="row">
    <div class="col-md-9">
        @if($articles->count() > 0)
        <div class="row">
            <div class="block-ss">
                <div class="col-md-12">
                    <div class="block-tt">
                        <h3>Mới nhất</h3>
                    </div>
                </div>
                <div class="block-ct block-ct-top">
                    @foreach($latests as $a)
                    <div class="col-md-6 layout-msr">
                        <div class="h-item ">
                            <div class="h-thumb">
                                @if(empty($a->thumbnail) && $a->format === 0)
                                    <img src="{{ url('/public/images/ui/logo.png') }}" alt="{{$a->title}}">
                                @elseif($a->format > 0)
                                    <span><i class="fa fa-music"></i></span>
                                @else
                                    <img src="{{$a->thumbnail}}" alt="{{$a->title}}">
                                @endif
                                <div class="h-time">{{Helper::datetime_recent($a->created_at->format('Y-m-d H:i:s'))}} trước</div>
                            </div>
                            <div class="h-i-item">
                                @if($a->format === 0)
                                    <h3><a href="{{route('ui.article.detail-normal', $a->slug)}}">{{$a->title}}</a></h3>
                                @elseif($a->format === 1)
                                    <h3><a href="{{route('ui.article.detail-audio', $a->slug)}}">{{$a->title}}</a></h3>
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
                                        <span><i class="fa fa-eye"></i> {{$a->stat->view}}</span>
                                        <span><i class="fa fa-heart"></i> {{$a->stat->like}}</span>
                                        <span><i class="fa fa-comment"></i> {{$a->comments->count()}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="block-ss">
                <div class="col-md-12">
                    <div class="block-tt">
                        <h3><a href="{{ route('ui.category.detail', $articles[0]->category[0]->slug) }}">{{$articles[0]->category[0]->title}}</a></h3>
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
                                    <h3><a href="{{route('ui.article.detail-normal', $ar->slug)}}">{{$ar->title}}</a></h3>
                                @elseif($ar->format === 1)
                                    <h3><a href="{{route('ui.article.detail-audio', $ar->slug)}}">{{$ar->title}}</a></h3>
                                @endif
                                <div class="h-desc">
                                    @if(empty($ar->description))
                                        {{str_limit($ar->content, 70, '...')}}
                                    @else
                                        {{str_limit($ar->description, 70, '...')}}
                                    @endif
                                </div>
                                <div class="h-sta">
                                    @foreach($ar->tags as $t)
                                        <a href="{{ route('ui.tag.detail', $t->slug) }}" class="t-tag">{{$t->title}}</a>
                                    @endforeach
                                    
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
                @if($articles->lastPage() > 1)
                    {{$articles->links()}}
                @endif
            </div>
        </div>
        @else
            <p>Chưa có bài viết nào. Hãy trở thành người đầu tiên viết bài bằng việc click vào <a href="{{ route('ui.create') }}">đây</a> để được đề xuất lên trang chủ.</p>
        @endif
    </div> {{-- end content--}}
    <div class="col-md-3">
        <div class="sidebar">
            @include('layouts.sidebar-hot')
            @include('layouts.sidebar-tag')
            @include('layouts.sidebar-ad')
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.block-ct-top').masonry({
            itemSelector: '.layout-msr'
        });
    });
</script>
@stop
