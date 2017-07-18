@extends('admin.index') @section('title', $user->name) 
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Quản lý <small>Thông tin thành viên</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Trang chủ
                </li>
                <li class="active">
                    {{$user->name}}
                </li>
            </ol>
        </div>
        <div class="col-md-12">
            @if(session()->has('status'))
                <div class="alert alert-{{session()->get('alert')}}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>{{session()->get('label')}}!</strong> {{session()->get('message')}}
                </div>
            @endif
            <div class="row">
                <div class="col-md-3">
                    <div class="" style="width: 150px;height: 150px;">
                        @if(is_null($user->avatar) || empty($user->avatar))
                            <img src="{{ url('/') }}/public/images/upload/user/user-male.png" alt="{{$user->name}}" class="thumbnail img-circle">
                        @else
                            <img src="{{$user->avatar}}" alt="{{$user->name}}" class="thumbnail img-circle">
                        @endif
                    </div>
                </div>
                <div class="col-md-9">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr>
                                <td><span class="label label-success col-md-2" style="margin-right: 5px;display: inline-block;">Tên:</span> {{$user->name}}</td>
                            </tr>
                            <tr>
                                <td><span class="label label-success col-md-2" style="margin-right: 5px;display: inline-block;">Email:</span> {{$user->email}}</td>
                            </tr>
                            <tr>
                                <td><span class="label label-success col-md-2" style="margin-right: 5px;display: inline-block;">Tên đầy đủ:</span>{{$user->fullname}}</td>
                            </tr>
                            <tr>
                                <td><span class="label label-success col-md-2" style="margin-right: 5px;display: inline-block;">SĐT:</span> {{$user->phone}}</td>
                            </tr>
                            <tr>
                                <td><span class="label label-success col-md-2" style="margin-right: 5px;display: inline-block;">Địa chỉ:</span> {{$user->address}}</td>
                            </tr>
                            <tr>
                                <td><span class="label label-success col-md-2" style="margin-right: 5px;display: inline-block;">Quyền:</span> {{$user->auth}}</td>
                            </tr>
                            <tr>
                                <td><span class="label label-success col-md-2" style="margin-right: 5px;display: inline-block;">Trạng thái:</span> {{$user->active}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-warning">
                <!-- Default panel contents -->
                <div class="panel-heading">Thống kê</div>
                <div class="panel-body">
                    <p><strong>{{$user->name}}</strong> đã tham gia vào <strong>{{Helper::datetime_recent($user->created_at->format('Y-m-d H:i:s'))}} trước</strong></p>
                </div>
            
                <!-- Table -->
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                @if(is_null($user->latestArticle()))
                                    Chưa viết bài nào kể từ ngày tham gia
                                @else
                                Đã viết bài: <strong>{{$user->articles->count()}}</strong> lần, bài viết gần nhất <a href="{{ route('ui.article.detail-normal', $user->latestArticle->slug) }}">{{$user->latestArticle->title}}</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @if(is_null($user->latestComment()))
                                    Chưa tham gia bình luận kể từ ngày tham gia
                                @else
                                Đã tham gia bình luận: <strong>{{$user->comments->count()}} lần</strong>, bình luận gần nhất trong <a href="{{ route('ui.article.detail-normal', $user->latestComment()->article[0]->slug) }}">{{$user->latestComment()->article[0]->title}}</a>
                                @endif
                            
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
