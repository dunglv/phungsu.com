@extends('admin.index')

@section('title', 'Tất cả bài viết trên website')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <h1 class="page-header">
                Quản lý <small>Thành viên</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Trang chủ
                </li>
                <li >
                    Thành viên
                </li>
            </ol>
            {{-- Show message  --}}
           @if(session()->has('status'))
                <div class="alert alert-{{session()->get('alert')}}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>{{session()->get('label')}}!</strong> {{session()->get('message')}}
                </div>
            @endif
            {{-- end show message --}}
        </div>
		<div class="col-md-12">
			@if(isset($users))
				@if($users->total() > 0)
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="1%">#NO</th>
							<th width="5%">Tên</th>
							<th width="5%">Email</th>
							<th width="5%">Đăng ký qua</th>
							<th width="10%">Họ và tên</th>
							<th width="5%">Số điện thoại</th>
							<th width="5%">Giới tính</th>
							<th width="15%">Địa chỉ</th>
							<th width="5%">Tôn giáo</th>
							<th width="10%">Tham gia ngày</th>
							<th width="9%">Trạng thái</th>
							<th width="5%">Quyền</th>
							<th width="20%">Thao tác</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $u)
						<tr>
							<td>{{$u->id}}</td>
							<td><a href="{{ route('ad.u.detail', $u->id) }}">{{$u->name}}</a></td>
							<td>{{$u->email}}</td>
							<td>{{$u->provider}}</td>
							<td>{{$u->fullname}}</td>
							<td>{{$u->phone}}</td>
							<td>{{$u->gender}}</td>
							<td>{{$u->address}}</td>
							<td>{{$u->religion}}</td>
							<td>{{$u->created_at->format('d-m-Y')}}</td>
							<td>{{$u->active}}</td>
							<td>{{$u->auth}}</td>
							<td>
								<a href="{{ route('ad.u.lock', $u->id) }}" class="btn btn-success"><i class="fa fa-lock"></i> Khóa</a>
								<a href="{{ route('ad.u.auth', $u->id) }}" class="btn btn-primary">Thay đổi quyền</a>
								<a href="{{ route('ad.u.delete', $u->id) }}" class="btn btn-danger"><i class="fa fa-remove"></i> Xóa khỏi hệ thống</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@if($users->lastPage() > 1)
					{{$users->links()}}
				@endif
				@else
					<p>No data in current time</p>
				@endif
			@endif
		</div>
	</div>
</div>
@stop