@extends('admin.index')

@section('title', 'Tất cả bài viết đã ẩn')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			@if(isset($articles))
				@if($articles->total() > 0)
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="1%">#NO</th>
							<th width="9%">Tiêu đề</th>
							<th width="10%">Trong</th>
							<th width="10%">tác giả</th>
							<th width="10%">Ngày phát hành</th>
							<th width="15%">Thống kê</th>
							<th width="5%">Trạng thái</th>
							<th width="20%">Bình luận mới nhất</th>
							<th width="20%">Thao tác</th>
						</tr>
					</thead>
					<tbody>
						@foreach($articles as $a)
						<tr>
							<td>{{$a->id}}</td>
							<td>{{$a->title}}</td>
							<td>{{$a->category[0]->title}}</td>
							<td>{{$a->user->name}}</td>
							<td>{{$a->created_at->format('d-m-Y H:i')}}</td>
							<td>
								<p><i class="fa fa-eye"></i> {{$a->stat->view}}</p>
								<p><i class="fa fa-hand-o-up"></i> {{$a->stat->like}}</p>
								<p><i class="fa fa-comment"></i>{{$a->comments->count()}}</p>
							</td>
							<td>{{$a->active}}</td>
							<td>
								<a href="" class="btn btn-success">Kích hoạt</a>
								<a href="" class="btn btn-primary">Chỉnh sửa</a>
								<a href="" class="btn btn-danger">Xóa</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@if($articles->lastPage() > 1)
					{{$articles->links()}}
				@endif
				@else
					<p>No data in current time</p>
				@endif
			@endif
		</div>
	</div>
</div>
@stop