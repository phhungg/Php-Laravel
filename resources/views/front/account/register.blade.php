@extends('front.layout.app')
@section('main')
<section class="section-5">
  <div class="container my-5">
    <div class="py-lg-2">&nbsp;</div>
    <div class="row d-flex justify-content-center">
      <div class="col-md-5">
        <div class="card shadow border-0 p-5">
          <h1 class="h3">Đăng Kí Tài Khoản</h1>
          <form action="" name="registerForm" id="registerForm">
            <div class=" mb-3">
              <label for="" class="mb-2">Họ và tên*</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
              <p></p>
            </div>
            <div class="mb-3">
              <label for="" class="mb-2">Email*</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
              <p></p>
            </div>
            <div class="mb-3">
              <label for="" class="mb-2">Mật Khẩu*</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
              <p></p>
            </div>
            <div class="mb-3">
              <label for="" class="mb-2">Xác Nhận Mật Khẩu*</label>
              <input type="password" name="confirmPassword" id="confirmPassword" class="form-control"
                placeholder="Enter Confirm Password">
              <p></p>
            </div>
            <button class="btn btn-primary mt-2">Đăng Kí</button>
          </form>
        </div>
        <div class="mt-4 text-center">
          <p>Bạn đã có tài khoản? <a href="{{route("account.login")}}">Đăng Nhập</a></p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('customJs');
<script>
$("#registerForm").submit(function(e) {
  e.preventDefault();
  $.ajax({
    url: '{{route("account.processRegister")}}',
    type: 'post',
    data: $("#registerForm").serializeArray(),
    dataType: 'json',
    success: function(response) {
      if (response.status == false) {
        var errors = response.errors;
        if (errors.name) {
          $("#name").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.name);
        } else {
          $("#name").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        }
        if (errors.email) {
          $("#email").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.email);
        } else {
          $("#email").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        }
        if (errors.password) {
          $("#password").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors
            .password);
        } else {
          $("#password").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        }
        if (errors.confirmPassword) {
          $("#confirmPassword").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors
            .confirmPassword);
        } else {
          $("#confirmPassword").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback')
            .html();
        }
      } else {
        $("#name").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        $("#email").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        $("#password").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        $("#confirmPassword").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        window.location.href = '{{route("account.login")}}';
      };
    }
  });
});
</script>
@endsection