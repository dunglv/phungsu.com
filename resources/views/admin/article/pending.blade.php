@extends('admin.index')

@section('title', 'Bài viết đang chờ xét duyệt trên website')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <h1 class="page-header">
                Quản lý <small>Bài viết chờ duyệt</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Trang chủ
                </li>
                <li class="active">
                    Bài viết chờ duyệt
                </li>
            </ol>
        </div>
		<div class="col-md-12">
			{{-- Show message  --}}
		   @if(session()->has('status'))
	            <div class="alert alert-{{session()->get('alert')}}">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                <strong>{{session()->get('label')}}!</strong> {{session()->get('message')}}
	            </div>
	        @endif
		    {{-- end show message --}}
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
								<a href="{{ route('ad.a.active', $a->id) }}" class="btn btn-success"><i class="fa fa-eye"></i> Kích hoạt</a>
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