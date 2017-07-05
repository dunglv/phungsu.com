@extends('index')
@section('title', 'Xóa tài khoản của bạn')
@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Lưu ý về tài khoản của bạn</strong></h3>
				</div>
				<div class="panel-body">
					<p><strong>Khi tài khoản của bạn bị xóa:</strong></p>
					<div>
						<ul>
							<li>Hãy xem xét lại các bài viết của bạn bởi vì nó có thể được đánh giá cao bới người khác.</li>
							<li>Tất cả những bài viết và comment của bạn vẫn còn. Tuy nhiên bạn không còn quyền chỉnh sửa chúng.</li>
							<li>Bạn sẽ phải đăng lý một tài khoản mới để thực hiện các thao tác như đăng bài viết, comment...</li>
							<li>Tất cả những thông tin của bạn sẽ không còn trên website. Điều này đồng nghĩa với việc bạn sẽ bắt đầu lại từ đầu khi đăng ký tài khoản mới.</li>
							<li>Xóa cache khi bạn có nhu cầu tạo tài khoản mới</li>
						</ul>
					</div>
					<p>Ý kiến của bạn sẽ giúp chúng tôi cải thiện tốt hơn website của mình.</p>
					<form action="" method="POST" role="form">
						<div class="form-group">
							<textarea name="idea" class="form-control" rows="3" placeholder="Nhập ý kiến của bạn tại đây..."></textarea>
						</div>
					
						<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Gửi ý kiến và xóa tài khoản của tôi</button>
						<a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-xing"></i> Tôi vẫn dùng tài khoản này</a>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop