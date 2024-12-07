@extends('front.layout.app')
@section('main')
<section class="section-5 bg-2">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Chủ</a></li>
            <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Quản Lí Công Việc</a></li>
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
            <div class="d-flex justify-content-between">
              <div>
                <h3 class="fs-4 mb-1">Danh Sách Hồ Sơ Đã Nộp</h3>
              </div>
              <div style="margin-top: -10px;">

              </div>

            </div>
            <div class="table-responsive">
              <table class="table ">
                <thead class="bg-light">
                  <tr>
                    <th scope="col">Tên Công Việc</th>
                    <th scope="col">Người Dùng</th>
                    <th scope="col">Nhà Tuyển Dụng</th>
                    <th scope="col">Ngày Ứng Tuyển</th>
                    <th scope="col">Hành động</th>
                  </tr>
                </thead>
                <tbody class="border-0">
                  @if ($application->isNotEmpty())
                  @foreach ($application as $applications )
                  <tr class="active">
                    <td>
                      <p class="job-name fw-500">{{$applications->job->title}}</p>
                    </td>
                    <td>{{$applications->user->name}}</td>
                    <td>{{$applications->employer->name}}</td>
                    <td>{{\Carbon\Carbon::parse($applications->applied_date)->format('d M, Y')}}</td>
                    <td>
                      <div class="action-dots float-end">
                        <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="javascript:void(0);"
                              onclick="deleteApplication('{{$applications->id}}')"><i class="fa fa-trash"
                                aria-hidden="true"></i>
                              Xóa</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
            <div>{{$application->links()}}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
function deleteApplication(id) {
  if (confirm('Bạn có chắc muốn xóa hồ sơ này không ?')) {
    $.ajax({
      url: '{{route("admin.jobApplication.destroy")}}',
      type: 'delete',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(response) {
        window.location.href = "{{route('admin.jobApplication')}}";
      }
    });
  }
}
</script>
@endsection