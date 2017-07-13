<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('ui.home') }}" title="Ghé thăm website" target="_blank">
            {!!Html::image('/public/images/ui/logo.png')!!}
            <span>Phụng sự</span>
        </a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
            <ul class="dropdown-menu message-dropdown">
                <li class="message-preview">
                    <a href="#">
                        <div class="media">
                            <span class="pull-left">
                                <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                            <div class="media-body">
                                <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                <p>Lorem ipsum dolor sit amet, consectetur...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="message-preview">
                    <a href="#">
                        <div class="media">
                            <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                            <div class="media-body">
                                <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                <p>Lorem ipsum dolor sit amet, consectetur...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="message-preview">
                    <a href="#">
                        <div class="media">
                            <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                            <div class="media-body">
                                <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                <p>Lorem ipsum dolor sit amet, consectetur...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="message-footer">
                    <a href="#">Read All New Messages</a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
            <ul class="dropdown-menu alert-dropdown">
                <li>
                    <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">View All</a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{auth()->user()->name}} <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('ad.u.profile') }}"><i class="fa fa-fw fa-user"></i> Thông tin cá nhân</a>
                </li>
                <li>
                    <a href="{{ route('ad.u.change-password') }}"><i class="fa fa-fw fa-lock"></i> Thay đổi mật khẩu</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-envelope"></i> Hộp thư</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ route('ui.logout') }}"><i class="fa fa-fw fa-power-off"></i> Đăng xuất</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="{{ route('ad.home') }}"><i class="fa fa-fw fa-dashboard"></i> Trang chủ</a>
            </li>
            <li>
                @php
                    if (count(request()->segments()) >= 2)
                        $curSeg = request()->segment(2);
                    else
                        $curSeg = '';
                    
                @endphp
                <a href="javascript:;" data-toggle="collapse" data-target="#demo" @if($curSeg==="article") aria-expanded="true" @endif><i class="fa fa-pencil"></i> Bài viết <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse @if($curSeg==="article") in @endif" @if($curSeg==="article") aria-expanded="true" @endif>
                    <li>
                        <a href="{{ route('ui.create') }}" target="_blank">Thêm bài viết mới</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.a.index') }}">Tất cả bài viết</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.a.pending') }}">Duyệt bài viết</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.a.locked') }}">Bài viết đã khóa</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo2" @if($curSeg==="category") aria-expanded="true" @endif><i class="fa fa-list"></i> Chủ đề <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo2" class="collapse @if($curSeg==="category") in @endif" @if($curSeg==="category") aria-expanded="true" @endif>
                    <li>
                        <a href="{{ route('ad.cate.create') }}">Thêm chủ đề mới</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.cate.index') }}">Tất cả chủ đề</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.cate.pending') }}">Duyệt chủ đề</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.cate.locked') }}">Chủ đề đã khóa</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo3" @if($curSeg==="tag") aria-expanded="true" @endif><i class="fa fa-tags"></i> Các thẻ bài viết<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo3" class="collapse @if($curSeg==="tag") in @endif" @if($curSeg==="tag") aria-expanded="true" @endif>
                    <li>
                        <a href="{{ route('ad.tag.create') }}">Thêm thẻ mới</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.tag.index') }}">Tất cả thẻ có sẵn</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.tag.pending') }}">Duyệt thẻ bài viết</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.tag.locked') }}">Các thẻ đã ẩn</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo4" @if($curSeg==="user") aria-expanded="true" @endif><i class="fa fa-user-md"></i> Quản lý thành viên<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo4" class="collapse @if($curSeg==="user") in @endif" @if($curSeg==="user") aria-expanded="true" @endif>
                    <li>
                        <a href="{{ route('ad.u.pending') }}">Thành viên phòng chờ</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.u.index') }}">Tất cả thành viên</a>
                    </li>
                    <li>
                        <a href="{{ route('ad.u.deactive') }}">Thành viên đã khóa</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-cog"></i> Cài đặt</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo5"><i class="fa fa-user-md"></i> Phân quyền thành viên<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo5" class="collapse">
                    <li>
                        <a href="#">Thành viên phòng chờ</a>
                    </li>
                    <li>
                        <a href="#">Tất cả thành viên</a>
                    </li>
                    <li>
                        <a href="#">Thành viên đã xóa</a>
                    </li>
                    <li>
                        <a href="#">Thành viên khóa tạm thời</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-feed"></i> Phản hồi trang web</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo6"><i class="fa fa-folder"></i> Dữ liệu website<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo6" class="collapse">
                    <li>
                        <a href="#">Xuất danh sách các bài viết</a>
                    </li>
                    <li>
                        <a href="#">In danh sách thành viên</a>
                    </li>
                    <li>
                        <a href="#">In danh sách chủ đề</a>
                    </li>
                    <li>
                        <a href="#">In thống kê</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>
