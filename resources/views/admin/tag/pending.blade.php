@extends('admin.index')

@section('title', 'Tất cả cá thẻ hiện tại')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <h1 class="page-header">
                Quản lý <small>Thẻ bài viết chờ duyệt</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Trang chủ
                </li>
                <li >
                    Thẻ bài viết
                </li>
                <li >
                   	Chờ duyệt
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
								<a href="" class="btn btn-success"><i class="fa fa-eye"></i> Kích hoạt</a>
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