@extends('admin.index')

@section('title', 'Tất cả bài viết trên website')

@section('content')
<div class="container-fluid">
	<div class="row">
		{{-- Show message  --}}
	    @if(session()->has('status')) 
	        <div class="col-md-12">
	            <div class="alert alert-{{session()->get('label')}}">
	                <strong style="text-transform: capitalize;">{{session()->get('label')}}!</strong> {{session()->get('message')}} {{session()->get('label')}} 
	            </div>
	            
	        </div>
	    @endif
	    {{-- end show message --}}
		<div class="col-md-12">
			@if(isset($articles))
				@if($articles->total() > 0)
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="1%">#NO</th>
							<th width="19%">Tiêu đề</th>
							<th width="10%">Trong</th>
							<th width="10%">Tác giả</th>
							<th width="10%">Ngày phát hành</th>
							<th width="10%">Thống kê</th>
							<th width="5%">Trạng thái</th>
							<th width="5%">Bình luận mới nhất</th>
							<th width="30%">Thao tác</th>
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
							<td>{{$a->active}}</td>
							<td>
								<a href="{{ route('ad.a.active', $a->id) }}" class="btn btn-default"><i class="fa fa-eye-slash"></i> Ẩn</a>
								<a href="{{ route('ad.a.edit-normal', $a->id) }}" class="btn btn-primary">Chỉnh sửa</a>
								<a href="{{ route('ad.a.delete', $a->id) }}" class="btn btn-danger">Xóa</a>
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