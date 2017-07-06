@extends('index')
@section('title', 'Góp ý cho trang web')
@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Góp ý cho trang web</strong></h3>
				</div>
				<div class="panel-body">
					<div style="text-align: justify;">
						<p>Trước tiên xin cảm ơn bạn đã ghé thăm và ủng hộ trang web. Hiện nay, trang web đang trong thời gian thử nghiệm vì thế không tránh khỏi những sai sót. Những ý kiến góp ý của bạn sẽ giúp trang web hoàn thiện hơn cả về mặt hình thức và chức năng.</p> 
						<p>Chúng tôi luôn cố gắng hoàn thiện tốt trang web để có thể đáp ứng được những sự kỳ vọng từ bạn. Sự ủng hộ của bạn là động lực khích lê chúng tôi thực hiện tiêu chí ấy.</p>
						<p>
						Chúc bạn vui vẻ và tiếp tục ghé thăm website khi nó hoàn thiện hơn. Xin cảm ơn!</p>
					</div>
					<p>Ý kiến của bạn sẽ giúp chúng tôi cải thiện tốt hơn website của mình.</p>
					<form action="" method="POST" role="form">
						<div class="form-group">
							<textarea name="idea" class="form-control" rows="3" placeholder="Nhập ý kiến của bạn tại đây..."></textarea>
						</div>
					
						<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Gửi ý kiến của tôi</button>
						<a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-xing"></i> Tiếp tục ghé thăm</a>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop