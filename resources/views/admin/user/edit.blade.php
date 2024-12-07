@extends('front.layout.app')
@section('main')
<section class="section-5 bg-2">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{route('admin.users')}}">Người Dùng</a></li>
            <li class="breadcrumb-item active">Chỉnh Sửa</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3">
        @include('admin.sidebarDashboard')
      </div>

      <div class="col-lg-9">
        @include('front.layout.message')
        <div class="card border-0 shadow mb-4">
          <div class="card-body card-form">
            <form action="" method="post" id="userForm" name="userForm">
              <div class="card-body  p-4">
                <h3 class="fs-4 mb-1">Chỉnh Sửa Người Dùng</h3>
                <div class="mb-4">
                  <label for="" class="mb-2">Tên*</label>
                  <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control"
                    value="{{$user->name}}">
                  <p></p>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Email*</label>
                  <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control"
                    value="{{$user->email}}">
                  <p></p>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Vị trí*</label>
                  <input type="text" name="designation" id="designation" placeholder="Designation" class="form-control"
                    value="{{$user->designation}}">
                  <p></p>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Số điện thoại*</label>
                  <input type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control"
                    value="{{$user->mobiles}}">
                  <p></p>
                </div>
              </div>
              <div class="card-footer  p-4">
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
@section('customJs')
<script>
$("#userForm").submit(function(e) {
  e.preventDefault();
  $.ajax({
    url: '{{route("admin.user.update",$user->id)}}',
    type: 'put',
    dataType: 'json',
    data: $('#userForm').serializeArray(),
    success: function(response) {
      if (response.status == true) {
        $("#name").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        $("#email").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        window.location.href = "{{route('admin.users')}}";
      } else {
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
      }
    }
  })
})
</script>
@endsection