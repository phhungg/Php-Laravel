<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
  <div class="card-body p-0">
    <ul class="list-group list-group-flush ">
      <li class="list-group-item d-flex justify-content-between p-3">
        <a href="{{route('admin.users')}}">Người Dùng</a>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center p-3">
        <a href="{{route('admin.dashboard')}}">Công Việc </a>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center p-3">
        <a href="{{route('admin.jobApplication')}}">Hồ Sơ Đã Nộp</a>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center p-3">
        <a href="{{route('account.logout')}}">Đăng Xuất</a>
      </li>
    </ul>
  </div>
</div>