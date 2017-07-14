@extends('admin.index') @section('title', 'Cài đặt') @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
            Quản lý <small>Cài đặt</small>
        </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Trang chủ
                </li>
                <li>
                    Cài đặt
                </li>
            </ol>
            {{-- Show message --}} @if(session()->has('status'))
            <div class="alert alert-{{session()->get('alert')}}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>{{session()->get('label')}}!</strong> {{session()->get('message')}}
            </div>
            @endif {{-- end show message --}}
        </div>
        <div class="col-lg-12">
            <form action="" method="POST" role="form">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">CÀI ĐẶT TỔNG QUAN</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Ngôn ngữ</label>
                                    <select name="language" id="input" class="form-control" required="required">
                                        <option value="vi">Tiếng Việt</option>
                                        <option value="en">Tiếng Anh</option>
                                        <option value="fr">Tiếng Pháp</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Giao diện</label>
                                    <select name="language" id="input" class="form-control" required="required">
                                        <option value="0">Xanh lá cây</option>
                                        <option value="1">Xanh da trời</option>
                                        <option value="2">Tối</option>
                                        <option value="3">Pha lê</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">CÀI ĐẶT TỔNG QUAN</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">
                                            Số lượng bài viết tối đa trên một trang
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">
                                            Bài viết qua không cần kiểm duyệt
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">
                                            Hiển thị bài viết dưới footer
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">
                                            Tắt bình luận tất cả bài viết trên hệ thống
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">
                                            Lọc bài viết chưa nội dung vi phạm
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">
                                            Hiển thị các tag SEO
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">
                                            Menu tương ứng
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">
                                            Cho phép bài viết được chỉnh sửa
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
