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
                <span>Đã đăng <strong title="{{$article[0]->created_at->format('Y-m-d H:i:s')}}">{{Helper::datetime_recent($article[0]->created_at->format('Y-m-d H:i:s'))}} trước</strong> trong: @foreach($article[0]->category as $c)<a href="{{ route('ui.category.detail', $c->slug) }}">{{$c->title}}</a>@endforeach</span> <span><i class="fa fa-eye"></i> {{$article[0]->stat->view}}</span> <span><i class="fa fa-heart"></i> {{$article[0]->stat->like}}</span>
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
            {{-- action user --}}
            <div class="dt-ac">

                @if(auth()->check() && $article[0]->user_id === auth()->user()->id)
                <div class="dt-ac-le">
                    <a href="{{ route('ui.article.edit-normal', $article[0]->slug) }}">Chỉnh sửa</a>
                    <a id="click_remove_{{$article[0]->id}}" href="#" onclick="javascript:void(0);" class="clickRemoveThis click-{{$article[0]->id}}">Xóa bài viết này</a>
                </div>
                @endif
                <div class="dt-ac-ri">
                    Hãy nhấn nút thích và chia sẻ đến tất cả mọi người nhé!
                    <ul>
                        <li class="like">
                            <a href="#"><i class="fa fa-heart"></i></a>
                        </li>
                        <li class="fb">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{route('ui.article.detail-normal', $article[0]->slug)}}" target="_blank"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li class="gg">
                            <a href="https://plus.google.com/share?url={{route('ui.article.detail-normal', $article[0]->slug)}}" target="_blank"><i class="fa fa-google-plus"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- end action user --}}
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
                                <p>Tham gia: {{Helper::datetime_current($article[0]->user->created_at->format('Y-m-d H:i:s'))}}</p>
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
                        <li><i class="fa fa-calendar"></i> Join: {{Helper::datetime_recent($article[0]->user->created_at->format('Y-m-d H:i:s'))}} trước</li>
                        <li><i class="fa fa-pencil-square-o"></i> Post: {{$article[0]->user->count()}}</li>
                        <li><i class="fa fa-thumbs-o-up"></i> Thích: {{$article[0]->stat->like}}</li>
                    </ul>
                </div>
            </div>
            {{-- End About author --}}
            {{-- Comment Main --}}
            <div class="dt-cmt">
                <div class="cmt-t"><label>Comments ({{$article[0]->comments->count()}})</label> <span><i class="fa fa-chevron-down"></i></span></div>
                <div class="cmt-list">
                     @if(Auth::check())
                        @if($article[0]->opencomment === 1)
                        <div class="form-comment">
                            {!!Form::open(['method'=>'POST', 'route'=> ['ui.comment.store', 'slug' => $article[0]->slug]])!!}
                                <div class="form-group">
                                    <textarea name="comment" id="comment_input" class="form-control" rows="3" required="required" placeholder="Nhập ý kiến của bạn vào đây..."></textarea>
                                    <input type="hidden" name="parent">
                                    <input type="hidden" name="comment_edit">
                                    <input type="hidden" name="article" value="{{$article[0]->id}}">
                                </div>
                                @if($errors->has('comment')) <p><span class="error">{{$errors->first('comment')}}</span></p>@endif
                                <button type="submit" class="btn btn-submit btn-success">Gủi bình luận</button>
                            {!!Form::close()!!}
                        </div>
                        @else
                            <div class="not-cc">
                                Tác giả đã tắt tính năng bình luận cho bài viết này. Liên hệ tác giả hoặc quản lý website để biết thêm chi tiết.
                            </div>
                        @endif
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
                                            <p title="{{$cmt->created_at->format('d-m-Y H:i:s')}}">{{Helper::datetime_recent($cmt->created_at->format('d-m-Y H:i:s'))}} trước</p>
                                        </div>
                                        @if(auth()->check() && $cmt->user[0]->id === auth()->user()->id)
                                        <div class="cmt-opt">
                                            <span><i class="fa fa-ellipsis-v"></i></span>
                                            <ul>
                                                <li class="cmt-delete" data-c = "{{$cmt->id}}"><a href="#"><i class="fa fa-remove"></i> Delete comment</a></li>
                                                <li class="cmt-edit" data-c="{{$cmt->id}}"><a href="#"><i class="fa fa-pencil"></i> Edit comment</a></li>
                                            </ul>
                                        </div>
                                        @endif
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
                                                @if(auth()->check() && $child->user[0]->id === auth()->user()->id)
                                                <div class="cmt-opt">
                                                    <span><i class="fa fa-ellipsis-v"></i></span>
                                                    <ul>
                                                        <li class="cmt-delete" data-c = "{{$child->id}}"><a href="#"><i class="fa fa-remove"></i> Delete comment</a></li>
                                                        <li class="cmt-edit" data-c="{{$child->id}}"><a href="#"><i class="fa fa-pencil"></i> Edit comment</a></li>
                                                    </ul>
                                                </div>
                                                @endif
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
            {{-- End Comment Main --}}
            {{-- Comment Facebook --}}
            <div class="dt-fb">
                <div class="fb-comments" data-href="{{{route('ui.article.detail-normal', $article[0]->slug)}}}" data-width="100%" data-numposts="5" data-off="true"></div>
            </div>
            {{-- End Comment Facebook --}}
        </div>
    </div>
    {{-- SIDEBAR --}}
    <div class="col-md-3">
        <div class="sidebar">
            @if(isset($sames) && $sames->count() > 0)
                <div class="bl-sc bl-sa">
                    <div class="bl-t">Bài viết liên quan</div>
                    <div class="bl-ct">
                        <div class="bl-l">
                            @foreach($sames as $a)
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
                                        <div class="bl-hh"><a href="{{ route('ui.article.detail-normal', $a->slug) }}">{{$a->title}}</a></div>
                                        <div class="bl-ext">{{str_limit($a->content, 60, '...')}}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @include('layouts.sidebar-tag')
            @include('layouts.sidebar-ad')
        </div>
    </div>
    {{-- END SIDEBAR --}}
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

        $('.cmt-edit').on('click', function(e){
            e.preventDefault();
            var id = $(this).data('c');
            $('textarea[name="comment"]').focus().val($('#cmt_'+id).children('.cmt-ct').text().replace(/^\s+|\s+$/, ''));
            if ($('.form-comment').find('.btn-edit').length === 0) {
                $('.form-comment').addClass('form-edit').append('<span class="btn-edit error">Hủy bỏ chỉnh sửa</span>');
                $('input[name="comment_edit"]').val(id);
            }
        });

        $(document).on('click', '.btn-edit', function(){
            $(this).remove();
            $('.form-comment').removeClass('form-edit');
            $('textarea[name="comment"]').val('');
            $('input[name="comment_edit"]').val('');
        });
        $(document).on('click', '.clickRemoveThis', function(e){
            var id = $(this).attr('id').substr(13, 10);
            $(this).ownConfirm({
                title: 'Xác nhận xóa',
                content: 'Bạn chắc chắn muốn xóa bài viết này?',
                action: {
                    ok:{
                        label: 'Có'
                    },
                    cancel: {
                        label: 'Không'
                    }
                },
                ok_action: function(){
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('ui.article.handle-req') }}',
                        data: {'q': window.btoa('d-l-a'), 'id': window.btoa(id)},
                        success: function(data){
                            if (typeof data !== 'undefined') {
                                if (data.status === 1) {
                                    $(this).ownModal({
                                        content: 'Xóa bài viết thành công',
                                        ok_action: function(){
                                            window.location = data.redirect;
                                        }
                                    });
                                    $('.own-modal').on('DOMNodeRemoved', function(){
                                            window.location = data.redirect;
                                    });
                                }else{
                                    $(this).ownModal({
                                        content: '<strong class="label label-danger">Lỗi!</strong>Xóa không thành công bài viết'
                                    });
                                }
                            }
                        },
                        error: function(error){

                        }
                    });
                }
            });
            e.preventDefault();

        });
    });
</script>
@stop
