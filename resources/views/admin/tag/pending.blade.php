@extends('admin.index')

@section('title', 'Tất cả cá thẻ hiện tại')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			@if(isset($tags))
				@if($tags->total() > 0)
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="1%">#NO</th>
							<th width="9%">Tiêu đề</th>
							<th width="10%">Ngày phát hành</th>
							<th width="10%">Bài viết chứa thẻ</th>
							<th width="5%">Trạng thái</th>
							<th width="20%">Thao tác</th>
						</tr>
					</thead>
					<tbody>
						@foreach($tags as $t)
						<tr>
							<td>{{$t->id}}</td>
							<td><a href="#">{{$t->title}}</a></td>
							<td>
								
							</td>
							<td><a href="#">{{$t->articles->count()}}</a></td>
							<td>{{$t->active}}</td>
							<td>
								<a href="" class="btn btn-success">Kích hoạt</a>
								<a href="" class="btn btn-primary">Chỉnh sửa</a>
								<a href="" class="btn btn-danger">Xóa</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@if($tags->lastPage() > 1)
					{{$tags->links()}}
				@endif
				@else
					<p>No data in current time</p>
				@endif
			@endif
		</div>
	</div>
</div>
@stop