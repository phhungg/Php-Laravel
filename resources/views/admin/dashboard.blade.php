@extends('front.layout.app')
@section('main')
<section class="section-5 bg-2">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
            <li class="breadcrumb-item active">Trang Quản Li Admin</li>
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
          <div class="card-body dashboard text-center">
            <p class="h3">Chào mừng đến với Trang Quản Lí Admin</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('customJs')

@endsection