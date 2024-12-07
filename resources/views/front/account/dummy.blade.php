@extends('front.layout.app')
@section('main')
<section class="section-5 bg-2">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Cài Đặt Tài Khoản</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3">
        @include('front.account.sidebar')
      </div>

      <div class="col-lg-9">
        @include('front.layout.message')
        <div class="card border-0 shadow mb-4">

        </div>

        <div class="card border-0 shadow mb-4">
          <div class="card-body p-4">
            <h3 class="fs-4 mb-1">Thay đổi mật khẩu</h3>
            <div class="mb-4">
              <label for="" class="mb-2">Mật khẩu cũ*</label>
              <input type="password" placeholder="Old Password" class="form-control">
            </div>
            <div class="mb-4">
              <label for="" class="mb-2">Mật khẩu mới*</label>
              <input type="password" placeholder="New Password" class="form-control">
            </div>
            <div class="mb-4">
              <label for="" class="mb-2">Xác nhận mật khẩu*</label>
              <input type="password" placeholder="Confirm Password" class="form-control">
            </div>
          </div>
          <div class="card-footer  p-4">
            <button type="" class="btn btn-primary">Cập nhật</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('customJs')

@endsection