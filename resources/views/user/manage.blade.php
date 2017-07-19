@extends('index') 
@section('title', 'Quản lý bài viết của bạn') 

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('user.sidebar')
    </div>
    <div class="col-md-9">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Bài viết của bạn</strong></h3>
            </div>
            <div class="panel-body">
                @if(isset($articles)) @if($articles->count() > 0)
                <table class="table table-striped table-hover">
                    <tbody>
                        @foreach($articles as $a)
                        <tr>
                            <td>
                                <div class="media mn-list mn-list-a">
                                    <div class="media-left">
                                        <a href="#">
                                           @if($a->format === 0)
                                                {!!Html::image($a->thumbnail)!!}
                                           @elseif($a->format=== 1)
                                                <span><i class="fa fa-music"></i></span>
                                           @endif
                                        </a>
                                    </div>
                                    <div class="media-body" style="font-size: 1em;">
                                        <h4 class="media-heading" style="font-size: 1em;font-weight: 700"><a href="{{ route('ui.article.detail-normal', $a->slug) }}">{{$a->title}}</a></h4>
                                        <p>đã đăng <strong title="{{$a->created_at->format('Y-m-d H:i:s')}}">{{Helper::datetime_recent($a->created_at->format('Y-m-d H:i:s'))}} trước</strong> trong <a href="{{ route('ui.category.detail', $a->category[0]->slug) }}">{{$a->category[0]->title}}</a></p>
                                        <p class="mn-tag">
                                            @foreach($a->tags as $tag)
                                                <a href="{{ route('ui.tag.detail', $tag->slug) }}">{{$tag->title}}</a>
                                            @endforeach
                                        </p>
                                        <p class="mn-stat"><span><i class="fa fa-eye"></i> {{$a->stat->view}}</span><span><i class="fa fa-hand-o-up"></i> {{$a->stat->like}}</span><span><i class="fa fa-comment"></i> {{$a->comments->count()}}</span></p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$articles->links()}} @else
                <p>Bạn chưa viết bài viết nào kể từ ngày tham gia. Vào <a href="{{ route('ui.create') }}">đây</a> để viết bài viết đầu tiên của bạn.</p>
                @endif @endif
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Bình luận của bạn</strong></h3>
            </div>
            <div class="panel-body">
                @if(isset($comments)) @if($comments->count() > 0)
                <table class="table table-striped table-hover">
                    <tbody>
                        @foreach($comments as $c)
                        <tr>
                            <td>
                                <div class="media">
                                    <div class="media-body" style="font-size: 1em;">
                                        <h4 class="media-heading" style="font-size: 1em;font-weight: 700"><a href="{{ route('ui.article.detail-normal', $c->id) }}">{{$c->comment}}</a></h4>
                                        {{-- Link format article --}}
                                        @if($a->format === 0)
                                            <p>đã bình luận <strong title="{{$c->created_at->format('Y-m-d H:i:s')}}">{{Helper::datetime_recent($c->created_at->format('Y-m-d H:i:s'))}} trước</strong> trong <a href="{{ route('ui.article.detail-normal', $c->article[0]->slug) }}#cmt_{{$c->id}}">{{$c->article[0]->title}}</a></p>
                                       @elseif($a->format=== 1)
                                            <p>đã bình luận <strong title="{{$c->created_at->format('Y-m-d H:i:s')}}">{{Helper::datetime_recent($c->created_at->format('Y-m-d H:i:s'))}} trước</strong> trong <a href="{{ route('ui.article.detail-audio', $c->article[0]->slug) }}#cmt_{{$c->id}}">{{$c->article[0]->title}}</a></p>
                                       @endif
                                        
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$comments->links()}} @else
                <p>Bạn chưa viết bài viết nào kể từ ngày tham gia. Vào <a href="{{ route('ui.create') }}">đây</a> để viết bài viết đầu tiên của bạn.</p>
                @endif @endif
            </div>
        </div>
    </div>
</div>
@stop
