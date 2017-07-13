<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<style>
    @import url("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css");
    .jumbotron{
        margin: 20px 0;
    }
</style>
    <div class="container">
        <div class="col-md-12">
            <div class="jumbotron">
                <div class="container">
                    <h1>Xin chào, bạn!</h1>
                    <p>Chúc mừng bạn đã đăng ký thành công trên webiste <a href="Phungsu.com">Phungsu.com</a>. Bạn hãy lick vào nut xác nhận để hoàn thành việc đăng ký và chính thức trở thành thành viên của website hoặc ghé thăm trang web qua nút "Ghé thăm webiste"</p>
                    <p>
                        <a href="{{ route('ui.user.confirm_email') }}?email={{$email}}&key={{$str}}" class="btn btn-success">Xác nhận</a>
                        <a class="btn btn-warning">Ghé thăm website</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
