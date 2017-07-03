@extends('index') @section('title', 'Đóng góp bài viết mới') @section('style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.1.3/mediaelementplayer.min.css"> @stop @section('content')
<div id="fb-root"></div>
<script>
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.9&appId=982256208566545";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.1.3/mediaelement-and-player.min.js"></script> --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.1.3/mediaelementplayer.min.js"></script>
<div class="row">
    <div class="col-md-9">
        <div class="bl-dt bl-dt-mp3">
            <h1 class="dt-tit">Bài hát: {{$article[0]->title}}</h1>
            <div class="dt-sta">
                <span>Trong: @foreach($article[0]->category as $c)<a href="{{ route('ui.category.detail', $c->slug) }}">{{$c->title}}</a>@endforeach</span> <span><i class="fa fa-eye"></i> 10</span> <span><i class="fa fa-heart"></i> 10</span>
            </div>
            @if(!empty($article[0]->description))
                <div class="dt-desc">
                    {{$article[0]->description}}
                </div>
            @else
                <div class="dt-desc">
                {{str_limit($article[0]->content, 170, '...')}}
                </div>
            @endif
            <div class="dt-ct dt-lr">
                <div class="dt-player">
                    <audio id="player2" preload="none" controls style="max-width:100%;">
                        <source src="{{ $article[0]->thumbnail }}" title="{{ $article[0]->title }}" type="audio/mp3">
                    </audio>
                    <script>
                    var au = $('video, audio').mediaelementplayer({
                        // Do not forget to put a final slash (/)
                        // pluginPath: 'https://cdnjs.com/libraries/mediaelement/',
                        // this will allow the CDN to use Flash without restrictions
                        // (by default, this is set as `sameDomain`)
                        shimScriptAccess: 'always',
                        autoplay: true,
                        title: 'fhsdjfsj'
                            // more configuration
                    });
                    console.log(au);
                    </script>
                </div>
                <div class="click-expand">
                    <div class="lr-t">Lời bài hát</div>
                </div>
                <div class="dt-lr-expand ct-expand">
                    @if(empty($article[0]->content))
                        @if(!Auth::check())
                            Đăng nhập tại <a href="{{ url('/login') }}">đây</a> và đóng góp lời cho bài hát {{$article[0]->title}}
                        @else
                            Hiện chưa có lời bài hát. Đóng góp lời cho bài hát {{$article[0]->title}} tại <a href="#">đây</a>
                        @endif
                    @else
                        {!!$article[0]->content!!}
                    @endif
                </div>
            </div>
            <div class="dt-ac">
                Do you like this article?
                <ul>
                    <li class="like">
                        <a href="#"><i class="fa fa-heart"></i></a>
                    </li>
                    <li class="fb">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{route('ui.article.detail', $article[0]->slug)}}" target="_blank"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li class="gg">
                        <a href="https://plus.google.com/share?url={{route('ui.article.detail', $article[0]->slug)}}" target="_blank"><i class="fa fa-google-plus"></i></a>
                    </li>
                </ul>
            </div>
            <div class="dt-tag">@foreach($article[0]->tags as $t)<a href="{{ route('ui.tag.detail', $t->slug) }}">{{$t->title}}</a>@endforeach</div>
            {{-- About author --}}
            <div class="dt-author">
                <div class="fll">
                    <div class="fl-top">
                        <div class="fl-ava">
                            @if(empty($article[0]->user->avatar))
                            {!!Html::image('/public/images/upload/user/user-male.png', $article[0]->user->name)!!}
                            @else
                                <img src="{{$article[0]->user->avatar}}" alt="{{$article[0]->user->name}}">
                            @endif
                        </div>
                        <div class="fl-name">
                            <p><a href="#">{{$article[0]->user->name}}</a></p>
                            <p>{{$article[0]->user->email}}</p>
                            @if(!empty($article[0]->user->fullname))
                                <p>{{$article[0]->user->fullname}}</p>
                            @else
                                <p>Tham gia: {{$article[0]->user->created_at->format('d-m-Y')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="fl-bottom">
                        @if(empty($article[0]->user->bio))
                            <p>Tác giả bài viết không muốn người khác biết quá nhiều về mình. Nếu bạn cảm thấy bài viết hay. Chỉ cần thả tim là đã khuyến khích tác giả có cảm hứng và động lực viết bài sau này. Xin cảm ơn.</p>
                        @else
                            {!!$article[0]->user->bio!!}
                        @endif
                    </div>
                </div>
                <div class="flr">
                    <ul>
                        <li><i class="fa fa-calendar"></i> Join: 10-10-2017</li>
                        <li><i class="fa fa-pencil-square-o"></i> Post: 100</li>
                        <li><i class="fa fa-thumbs-o-up"></i> Like: 10</li>
                    </ul>
                </div>
            </div>
            {{-- End About author --}}
            <div class="dt-cmt">
                <div class="cmt-t"><label>Comments ({{$article[0]->comments->count()}})</label> <span><i class="fa fa-chevron-down"></i></span></div>
                <div class="cmt-list">
                    @if($article[0]->comments->count() > 0)
                    <div id="" class="cmt-i">
                        <div class="cmt-inf">
                            <div class="fll">
                                {!!Html::image('/public/images/upload/user/user-female.png', 'luong viet dung')!!}
                            </div>
                            <div class="flr">
                                <p><a href="#">dunglv</a></p>
                                <p>10 phút trước</p>
                            </div>
                            <div class="cmt-opt">
                                <span><i class="fa fa-ellipsis-v"></i></span>
                                <ul>
                                    <li><a href="#"><i class="fa fa-remove"></i> Delete comment</a></li>
                                    <li><a href="#"><i class="fa fa-pencil"></i> Edit comment</a></li>
                                    <li><a href="#"><i class="fa fa-backward"></i> Report comment</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="cmt-ct">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias molestiae recusandae aliquid quas explicabo, odit voluptates dolores distinctio. Corporis iusto quae nemo suscipit ad omnis voluptatem adipisci laudantium, sequi voluptate tempore eius magni explicabo sint ducimus, blanditiis hic maxime, similique nostrum obcaecati optio. Mollitia beatae excepturi eligendi! Recusandae accusantium amet corrupti itaque. Impedit veniam, autem vitae rerum aut eos obcaecati beatae nihil quia, quisquam provident rem. Repellendus tempore iure tempora facere aliquam praesentium corporis quasi dolorum! Neque perspiciatis tenetur doloribus, molestiae porro maxime inventore sapiente expedita iure rerum quibusdam deserunt accusantium fugiat, quasi vero, eos dicta impedit cupiditate beatae! Id assumenda cupiditate, quia, velit sit dolore inventore alias, laborum architecto adipisci veniam aliquam quibusdam est hic, ipsum nostrum voluptatum aliquid rem deserunt illum deleniti natus porro? Eaque reiciendis eum repellat excepturi incidunt, expedita pariatur distinctio officiis aut numquam possimus, consequatur enim sint dolorum provident alias odit iure hic assumenda dolores odio iste culpa atque nulla! Veritatis consequatur similique explicabo, rem incidunt quam cupiditate ea accusantium, nobis delectus nisi ratione illo. Sunt nobis consectetur iste natus totam dolorum sequi ratione cumque ipsa ipsum sed doloribus unde esse, autem vitae, maxime perspiciatis molestiae amet eius. Vitae nisi animi a fuga. Dolores expedita, porro?
                        </div>
                        <div class="cmt-ac">
                            <a href="#">Quote</a>
                            <a href="#">Reply</a>
                        </div>
                    </div>
                    <div id="" class="cmt-i cmt-rep">
                        <div class="cmt-inf">
                            <div class="fll">
                                {!!Html::image('/public/images/upload/user/user-female.png', 'luong viet dung')!!}
                            </div>
                            <div class="flr">
                                <p><a href="#">dunglv</a></p>
                                <p>10 phút trước</p>
                            </div>
                        </div>
                        <div class="cmt-ct">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias molestiae recusandae aliquid quas explicabo, odit voluptates dolores distinctio. Corporis iusto quae nemo suscipit ad omnis voluptatem adipisci laudantium, porro?
                        </div>
                        <div class="cmt-ac">
                            <a href="#">Quote</a>
                            <a href="#">Reply</a>
                        </div>
                    </div>
                    <div id="" class="cmt-i">
                        <div class="cmt-inf">
                            <div class="fll">
                                {!!Html::image('/public/images/upload/user/user-female.png', 'luong viet dung')!!}
                            </div>
                            <div class="flr">
                                <p><a href="#">dunglv</a></p>
                                <p>10 phút trước</p>
                            </div>
                        </div>
                        <div class="cmt-ct">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias molestiae recusandae aliquid quas explicabo, odit voluptates dolores distinctio. Corporis iusto quae nemo suscipit ad omnis voluptatem adipisci laudantium, sequi voluptate tempore eius magni explicabo sint ducimus, blanditiis hic maxime, similique nostrum obcaecati optio. Mollitia beatae excepturi eligendi! Recusandae accusantium amet corrupti itaque. Impedit veniam, autem vitae rerum aut eos obcaecati beatae nihil quia, quisquam provident rem. Repellendus tempore iure tempora facere aliquam praesentium corporis quasi dolorum! Neque perspiciatis tenetur doloribus, molestiae porro maxime inventore sapiente expedita iure rerum quibusdam deserunt accusantium fugiat, quasi vero, eos dicta impedit cupiditate beatae! Id assumenda cupiditate, quia, velit sit dolore inventore alias, laborum architecto adipisci veniam aliquam quibusdam est hic, ipsum nostrum voluptatum aliquid rem deserunt illum deleniti natus porro? Eaque reiciendis eum repellat excepturi incidunt, expedita pariatur distinctio officiis aut numquam possimus, consequatur enim sint dolorum provident alias odit iure hic assumenda dolores odio iste culpa atque nulla! Veritatis consequatur similique explicabo, rem incidunt quam cupiditate ea accusantium, nobis delectus nisi ratione illo. Sunt nobis consectetur iste natus totam dolorum sequi ratione cumque ipsa ipsum sed doloribus unde esse, autem vitae, maxime perspiciatis molestiae amet eius. Vitae nisi animi a fuga. Dolores expedita, porro?
                        </div>
                        <div class="cmt-ac">
                            <a href="#">Quote</a>
                            <a href="#">Reply</a>
                        </div>
                    </div>
                    @else
                        @if(Auth::check())
                            Trở thành người đầu tiên bình luận bài viết này.
                        @else
                            Đăng nhập tại <a href="{{ url('/login') }}">đây</a> và trở thành người đầu tiên bình luận bài viết này.
                        @endif
                    @endif
                </div>
            </div>
            <div class="dt-fb">
                <div class="fb-comments" data-href="{{{route('ui.article.detail', $article[0]->slug)}}}" data-width="100%" data-numposts="5"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="sidebar">
            <div class="bl-sc">
                <div class="bl-t">Nằm trong mục</div>
                <div class="bl-ct">
                    <select name="" id="input" class="form-control">
                        <option value="">-- Select One --</option>
                    </select>
                </div>
            </div>
            <div class="bl-sc">
                <div class="bl-t">Tag</div>
                <div class="bl-ct">
                    <textarea name="tags" id="inputTags" class="form-control" rows="3" required="required" placeholder="Nhập môt vài tag liên quan bài viết..."></textarea>
                </div>
            </div>
            <div class="bl-sc">
                <div class="bl-t">Hoạt động</div>
                <div class="bl-ct">
                    <div class="radio">
                        <div class="bl-s-t">Cho phép bình luận</div>
                        <label>
                            <input type="radio" name="opencoment" id="inputOpencoment" value="" checked="checked"> Enable
                        </label>
                        <label>
                            <input type="radio" name="opencoment" id="inputOpencoment" value="" checked="checked"> Disable
                        </label>
                    </div>
                </div>
                <div class="bl-ct">
                    <div class="radio">
                        <div class="bl-s-t">Cho phép chỉnh sửa</div>
                        <label>
                            <input type="radio" name="openedit" id="inputOpencoment" value="" checked="checked"> Enable
                        </label>
                        <label>
                            <input type="radio" name="openedit" id="inputOpencoment" value="" checked="checked"> Disable
                        </label>
                    </div>
                </div>
                <div class="bl-ct">
                    <div class="radio">
                        <div class="bl-s-t">Nhận thông báo từ bài viết</div>
                        <label>
                            <input type="radio" name="notify" id="inputOpencoment" value="" checked="checked"> Enable
                        </label>
                        <label>
                            <input type="radio" name="notify" id="inputOpencoment" value="" checked="checked"> Disable
                        </label>
                    </div>
                </div>
                <div class="bl-ct">
                    <button type="button" class="btn btn-sm btn-success">Lưu</button>
                    <button type="button" class="btn btn-sm btn-danger">Hủy bỏ</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
