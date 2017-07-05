@if(isset($__ARTICLE) && $__ARTICLE->count() > 0)
<div class="bl-sc bl-sa">
    <div class="bl-t">Bài viết xem nhiều nhất</div>
    <div class="bl-ct">
        <div class="bl-l">
            @foreach($__ARTICLE as $a)
            <div class="bl-i bl-i-hot">
                <div class="bl-ii">
                    <div class="bl-i-l">
                        <span class="bl-ct-l">
                            @if(!is_null($a->thumbnail) || !empty($a->thumbnail))
                                @if($a->format === 0)
                                {!!Html::image($a->thumbnail, $a->title)!!}
                                @elseif($a->format === 1)
                                <i class="fa fa-music"></i>
                                @elseif($a->format === 2)
                                <i class="fa fa-video-camera"></i>
                                @elseif($a->format === 3)
                                <i class="fa fa-carmera"></i>
                                @endif
                            @else
                                {!!Html::image(url('/public/images/upload/default.jpg'), $a->title)!!}
                            @endif
                        </span>
                    </div>
                    <div class="bl-i-r">
                        <div class="bl-hh"><a href="{{ route('ui.article.detail', $a->slug) }}">{{$a->title}}</a></div>
                        <div class="bl-ext">{{str_limit($a->content, 60, '...')}}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif