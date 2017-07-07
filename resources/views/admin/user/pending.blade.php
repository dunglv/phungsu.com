@extends('admin.index')

@section('title', 'Thành viên chờ xử lý')

@section('content')
<div class="container-fluid">
	<div class="row">
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
							<td>{{$u->name}}</td>
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
								<a href="" class="btn btn-success">Kích hoạt</a>
								<a href="" class="btn btn-primary">Chỉnh sửa</a>
								<a href="" class="btn btn-danger">Xóa</a>
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