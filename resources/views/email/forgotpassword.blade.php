<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quên Mật Khẩu Email</title>
</head>

<body>
  <h3>Xin chào, {{$mailData['user']->name}}</h3>
  <p>Nhấn vào đây để thay đổi mật khẩu của bạn</p>
  <a href="{{route("resetPassword",$mailData['token'])}}">Ở Đây</a>
  <p>Cảm Ơn</p>
</body>

</html>