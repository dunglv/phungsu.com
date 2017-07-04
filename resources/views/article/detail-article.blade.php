@extends('index') @section('title', 'Đóng góp bài viết mới') @section('content')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.9&appId=982256208566545";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="row">
    <div class="col-md-9">
        <div class="bl-dt">
            <h1 class="dt-tit">Bài viết: {{$article[0]->title}}</h1>
            <div class="dt-sta">
                <span>Trong: @foreach($article[0]->category as $c)<a href="{{ route('ui.category.detail', $c->slug) }}">{{$c->title}}</a>@endforeach</span> <span><i class="fa fa-eye"></i> {{$article[0]->stat->view}}</span> <span><i class="fa fa-heart"></i> {{$article[0]->stat->like}}</span>
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
            <div class="dt-ct">
                {!!$article[0]->content!!}
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
                        <li><i class="fa fa-calendar"></i> Join: {{$article[0]->created_at->format('d-m-Y')}}</li>
                        <li><i class="fa fa-pencil-square-o"></i> Post: {{$article[0]->user->count()}}</li>
                        <li><i class="fa fa-thumbs-o-up"></i> Like: {{$article[0]->stat->like}}</li>
                    </ul>
                </div>
            </div>
            {{-- End About author --}}
            <div class="dt-cmt">
                <div class="cmt-t"><label>Comments ({{$article[0]->comments->count()}})</label> <span><i class="fa fa-chevron-down"></i></span></div>
                <div class="cmt-list">
                     @if(Auth::check())
                        <div class="form-comment">
                            {!!Form::open(['method'=>'POST', 'route'=> ['ui.comment.store', 'slug' => $article[0]->slug]])!!}
                                <div class="form-group">
                                    <textarea name="comment" id="comment_input" class="form-control" rows="3" required="required" placeholder="Nhập ý kiến của bạn vào đây..."></textarea>
                                    <input type="hidden" name="parent">
                                    <input type="hidden" name="article" value="{{$article[0]->id}}">
                                </div>
                                <button type="submit" class="btn btn-success">Gủi bình luận</button>
                            {!!Form::close()!!}
                        </div>
                    @else
                        <p>Đăng nhập tại <a href="{{ url('/login') }}">đây</a> và bình luận bài viết này.</p>
                    @endif
                    @if($comments->total() > 0)
                        @foreach($comments as $cmt)
                            @if(empty($cmt->parent) || is_null($cmt->parent))
                                <div id="cmt_{{$cmt->id}}" class="cmt-i">
                                    <div class="cmt-inf">
                                        <div class="fll">
                                            {!!Html::image('/public/images/upload/user/user-female.png', 'luong viet dung')!!}
                                        </div>
                                        <div class="flr">
                                            <p><a href="#">{{$cmt->user[0]->name}}</a></p>
                                            <p>{{$cmt->created_at->format('d-m-Y H:i:s')}}</p>
                                        </div>
                                        <div class="cmt-opt">
                                            <span><i class="fa fa-ellipsis-v"></i></span>
                                            <ul>
                                                <li class="cmt-delete" data-c = "{{$cmt->id}}"><a href="#"><i class="fa fa-remove"></i> Delete comment</a></li>
                                                <li><a href="#"><i class="fa fa-pencil"></i> Edit comment</a></li>
                                                <li><a href="#"><i class="fa fa-backward"></i> Report comment</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="cmt-ct">
                                        {{$cmt->comment}}
                                    </div>
                                    <div class="cmt-ac">
                                        <a id="rep_{{$cmt->id}}" class="action-rep" data-c ="{{$cmt->id}}" data-u="{{$cmt->user[0]->id}}" href="#">Reply</a>
                                    </div>
                                </div>
                                @if(count($cmt->children($cmt->id)) > 0)
                                    @foreach($cmt->children($cmt->id) as $child)
                                        <div id="cmt_{{$child->id}}" class="cmt-i cmt-rep">
                                            <div class="cmt-inf">
                                                <div class="fll">
                                                    {!!Html::image('/public/images/upload/user/user-female.png', 'luong viet dung')!!}
                                                </div>
                                                <div class="flr">
                                                    <p><a href="#">{{$child->user[0]->name}}</a></p>
                                                    <p>{{$child->created_at->format('d-m-Y H:i:s')}}</p>
                                                </div>
                                                <div class="cmt-opt">
                                                    <span><i class="fa fa-ellipsis-v"></i></span>
                                                    <ul>
                                                        <li class="cmt-delete" data-c = "{{$child->id}}"><a href="#"><i class="fa fa-remove"></i> Delete comment</a></li>
                                                        <li><a href="#"><i class="fa fa-pencil"></i> Edit comment</a></li>
                                                        <li><a href="#"><i class="fa fa-backward"></i> Report comment</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="cmt-ct">
                                                {{$child->comment}}
                                            </div>
                                            <div class="cmt-ac">
                                                <a id="rep_{{$cmt->id}}" class="action-rep" data-c ="{{$cmt->id}}" data-u="{{$cmt->user[0]->id}}" href="#">Reply</a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    @else
                        <p>Trở thành người đầu tiên bình luận bài viết này.</p>
                    @endif
                    {{$comments->links()}}
                   
                </div>
            </div>
            <div class="dt-fb">
                <div class="fb-comments" data-href="{{{route('ui.article.detail', $article[0]->slug)}}}" data-width="100%" data-numposts="5"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="sidebar">
            {{-- <div class="bl-sc">
                <div class="bl-t">Nằm trong mục</div>
                <div class="bl-ct">
                    <select name="" id="input" class="form-control">
                        <option value="">-- Select One --</option>
                    </select>
                </div>
            </div> --}}
           @include('layouts.sidebar-hot')
        </div>
    </div>
</div>
<script>
    $(function(){
        var qt = $('.action-quote');
        var rep = $('.action-rep');
        rep.on('click', function(e){
            var parent_id = $(this).data('c');
            $('input[name="parent"]').val(parent_id);
            $('textarea[name="comment"]').focus();
            
            if ($('.form-comment').find('.btn-reply').length === 0) {
                $('.form-comment').addClass('form-reply').append('<span class="btn-reply error">Hủy bỏ phản hồi</span>');
            }
            e.preventDefault();
            // alert(parent_id);
        });
        $(document).on('click', '.btn-reply', function(){
            $(this).remove();
            $('input[name="parent"]').val('');
        });
        $('.cmt-t').on('click', function(e){
            if ($(this).hasClass('c-collapse')) {
                $(this).removeClass('c-collapse');
                $('.cmt-list').removeClass('c-collapse');
            }else{
                $(this).addClass('c-collapse');
                $('.cmt-list').addClass('c-collapse');
            }
        });

        $('.cmt-delete').on('click', function(e){
            e.preventDefault();
            var _this = $(this);
            $(this).ownConfirm({
                ok_action: function(){
                    var _id = _this.data('c');
                    $.ajax({
                        type: 'GET',
                        url: "{{route('ui.comment.handle-req-comment')}}",
                        data: {'q': window.btoa('d-c-r'), 'id': _id},
                        success: function(data){
                            if (data.status === 'OK') {
                                $('#cmt_'+_id).remove();
                                alert('Delete successful comment');
                            }
                        },
                        error: function(e){

                        }
                    })
                }
            });
        });
    });
</script>
@stop
