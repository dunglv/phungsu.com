@extends('admin.index')

@section('title', 'Tất cả chủ đề')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <h1 class="page-header">
                Quản lý <small>Chủ đề</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Trang chủ
                </li>
                <li>
                    Chủ đề
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
			@if(isset($categories))
				@if($categories->total() > 0)
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="1%">#NO</th>
							<th width="9%">Tiêu đề</th>
							<th width="10%">Ngày phát hành</th>
							<th width="5%">Trạng thái</th>
							<th width="20%">Thao tác</th>
						</tr>
					</thead>
					<tbody>
						@foreach($categories as $c)
						<tr>
							<td>{{$c->id}}</td>
							<td>{{$c->title}}</td>
							{{-- <td>{{$c->created_at->format('d-m-Y H:i')}}</td> --}}
							<td>
								
							</td>
							<td>{{$c->active}}</td>
							<td>
								<a href="{{ route('ad.cate.active', $c->id) }}" class="btn btn-success">Kích hoạt</a>
								<a href="{{ route('ad.cate.edit', $c->id) }}" class="btn btn-primary">Chỉnh sửa</a>
								<a href="" class="btn btn-danger">Xóa</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@if($categories->lastPage() > 1)
					{{$categories->links()}}
				@endif
				@else
					<p>No data in current time</p>
				@endif
			@endif
		</div>
	</div>
</div>
@stop