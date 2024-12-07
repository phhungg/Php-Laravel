<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Notification Email</title>
</head>

<body>
  <h3>Xin chào, {{$mailData['employer']->name}}</h3>
  <p>Tên Công Việc: {{$mailData['job']->title}}</p>

  <p>Chi tiết người ứng tuyển</p>
  <p>Tên: {{$mailData['user']->name}}</p>
  <p>Email: {{$mailData['user']->email}}</p>
  <p>Số Điện Thoại: {{$mailData['user']->mobile}}</p>
</body>

</html>