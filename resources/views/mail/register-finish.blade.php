@extends('index') @section('title', 'Hoàn thành đăng ký') @section('content')
<div class="container">
    <div class="row">
    	<div class="col-md-12">
    		<div class="jumbotron">
    			<div class="container">
    				<h2>Đăng ký thành công!</h2>
    				<p>Cảm ơn bạn đa đăng ký tham gia Phungsu.com. Chúng tôi xin cảm ơn sự nhiệt thành và tầm chân tình khi có nhã ý muốn đóng góp với chúng tôi. Chúng tôi đánh giá cao sự đóng hóp và giúp chúng tôi xây dựng trang web ngày càng phát triển hơn. Xin cảm ơn!</p>
    				<div class="alert alert-warning">
    					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    					<strong>Chỉ còn một bước nữa!!</strong> Chúng tôi vừa gửi đến email bạn vừa đăng ký một hộp thư với mong muốn bạn hãy xác nhận với chúng tôi răng bạn không phải giả mạo để tham gia vào website. Sau khi xác nhận, bạn chính thức được phép tham gia vào các hoạt động trên website như đóng góp bài viết, bình luận,...
    				</div>
    				<p>
    					<a class="btn btn-danger">Tôi chưa nhận được email</a>
    					<a class="btn btn-warning">Xác nhận sau</a>
    				</p>
    			</div>
    		</div>
    	</div>
    </div>
</div>
@stop
