@extends('admin.index') @section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                            Quản lý <small>Thống kê tổng quan</small>
                        </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-info-circle"></i> <strong>Update latest thêm Admin?</strong> Try out <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">SB Admin 2</a> for additional features!
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$comments->count()}}</div>
                            <div>Bình luận</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$articles->count()}}</div>
                            <div>Đóng góp</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$users->count()}}</div>
                            <div>Thành viên</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-globe fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">130</div>
                            <div>Lượt ghé thăm</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart</h3>
                </div>
                <div class="panel-body">
                    <div id="morris-area-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil fa-fw"></i> Đóng góp gần đây</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                    @if(isset($latest_a) && $latest_a->count() > 0)
                        @foreach($latest_a as $a)
                            @if($a->format == 0)
                            <a href="{{ route('ui.article.detail-normal', $a->slug) }}" class="list-group-item">
                            <?php $icon = 'pencil'; $label="warning";?>
                            @elseif($a->format==1)
                            <a href="{{ route('ui.article.detail-audio', $a->slug) }}" class="list-group-item">
                            <?php $icon = 'music';$label="success";?>
                            @endif
                                <span class="badge" title="{{$a->created_at->format('Y-m-d H:i:s')}}">{{ \Helper::datetime_recent($a->created_at->format('Y-m-d H:i:s')) }} trước</span>
                                <span class="label label-{{$label}}"><i class="fa fa-fw fa-{{$icon}}"></i></span> {{$a->title}}
                            </a>
                        @endforeach
                    @else
                    <p>Chưa có đóng góp nào</p>
                    @endif
                    </div>
                    <div class="text-right">
                        <a href="{{ route('ad.a.index') }}">Xem thêm đóng góp <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-comment-o fa-fw"></i> Bình luận gần đây</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                     @if(isset($latest_c) && $latest_c->count() > 0)
                        @foreach($latest_c as $c)
                        {{-- {{dd($c->article[0]->title)}} --}}
                        @if($c->article->count() > 0)
                        <a href="{{ route('ui.article.detail-normal', $c->article[0]->slug) }}#cmt_{{$c->id}}" class="list-group-item" target="_blank">
                            <span class="badge" title="{{$c->created_at->format('Y-m-d H:i:s')}}">{{ \Helper::datetime_recent($c->created_at->format('Y-m-d H:i:s')) }} trước</span>
                            <i class="fa fa-fw fa-comment-o"></i> {{$c->comment}}
                        </a>
                        @else
                            <a href="#cmt_{{$c->id}}" class="list-group-item">
                                <span class="badge" title="{{$c->created_at->format('Y-m-d H:i:s')}}">{{ \Helper::datetime_recent($c->created_at->format('Y-m-d H:i:s')) }} trước</span>
                                <i class="fa fa-fw fa-comment-o"></i> {{$c->comment}}
                            </a>
                        @endif
                        @endforeach
                    @else
                    <p>Chưa có bình luận nào</p>
                    @endif
                    </div>
                    <div class="text-right">
                        <a href="">Xem thêm bình luận <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-user fa-fw"></i> Thành viên</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                     @if(isset($latest_u) && $latest_u->count() > 0)
                        @foreach($latest_u as $u)
                        <a href="#" class="list-group-item">
                            <span class="badge" title="{{$u->created_at->format('Y-m-d H:i:s')}}">{{ \Helper::datetime_recent($u->created_at->format('Y-m-d H:i:s')) }} trước</span>
                            <i class="fa fa-fw fa-user"></i> {{$u->name}}
                        </a>
                        @endforeach
                    @else
                    <p>Chưa có thành viên nào</p>
                    @endif
                    </div>
                    <div class="text-right">
                        <a href="">Xem thêm thành viên <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Transactions Panel</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Order Date</th>
                                        <th>Order Time</th>
                                        <th>Amount (USD)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>3326</td>
                                        <td>10/21/2013</td>
                                        <td>3:29 PM</td>
                                        <td>$321.33</td>
                                    </tr>
                                    <tr>
                                        <td>3325</td>
                                        <td>10/21/2013</td>
                                        <td>3:20 PM</td>
                                        <td>$234.34</td>
                                    </tr>
                                    <tr>
                                        <td>3324</td>
                                        <td>10/21/2013</td>
                                        <td>3:03 PM</td>
                                        <td>$724.17</td>
                                    </tr>
                                    <tr>
                                        <td>3323</td>
                                        <td>10/21/2013</td>
                                        <td>3:00 PM</td>
                                        <td>$23.71</td>
                                    </tr>
                                    <tr>
                                        <td>3322</td>
                                        <td>10/21/2013</td>
                                        <td>2:49 PM</td>
                                        <td>$8345.23</td>
                                    </tr>
                                    <tr>
                                        <td>3321</td>
                                        <td>10/21/2013</td>
                                        <td>2:23 PM</td>
                                        <td>$245.12</td>
                                    </tr>
                                    <tr>
                                        <td>3320</td>
                                        <td>10/21/2013</td>
                                        <td>2:15 PM</td>
                                        <td>$5663.54</td>
                                    </tr>
                                    <tr>
                                        <td>3319</td>
                                        <td>10/21/2013</td>
                                        <td>2:13 PM</td>
                                        <td>$943.45</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Donut Chart</h3>
                    </div>
                    <div class="panel-body">
                        <div id="morris-donut-chart"></div>
                        <div class="text-right">
                            <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /.row -->
</div>
@stop
