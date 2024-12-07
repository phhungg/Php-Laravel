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
                <h3 class="fs-4 mb-1">Danh sách công việc</h3>
              </div>
              <div style="margin-top: -10px;">

              </div>

            </div>
            <div class="table-responsive">
              <table class="table ">
                <thead class="bg-light">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên công việc</th>
                    <th scope="col">Được tạo bởi</th>
                    <th scope="col">Trạng Thái</th>
                    <th scope="col">Ngày hiện tại</th>
                    <th scope="col">Hành động</th>
                  </tr>
                </thead>
                <tbody class="border-0">
                  @if ($job->isNotEmpty())
                  @foreach ($job as $jobs )
                  <tr class="active">
                    <td>{{$jobs->id}}</td>
                    <td>
                      <p class="job-name fw-500">{{$jobs->title}}</p>
                      <p>Hồ Sơ: {{$jobs->application->count()}}</p>
                    </td>
                    <td>{{$jobs->user->name}}</td>
                    <td>
                      @if ($jobs->status==1)
                      <p class="text-success">Mở</p>
                      @else
                      <p class="text-danger">Đóng</p>
                      @endif
                    </td>
                    <td>{{\Carbon\Carbon::parse($jobs->created_at)->format('d M, Y')}}</td>
                    <td>
                      <div class="action-dots float-end">
                        <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="{{route('admin.job.edit',$jobs->id)}}"><i
                                class="fa fa-edit" aria-hidden="true"></i>
                              Chỉnh
                              Sửa</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:void(0);"
                              onclick="deleteJob('{{$jobs->id}}')"><i class="fa fa-trash" aria-hidden="true"></i>
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
            <div>{{$job->links()}}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
function deleteJob(id) {
  if (confirm('Bạn có chắc muốn xóa người dùng này không?')) {
    $.ajax({
      url: '{{route("admin.job.destroy")}}',
      type: 'delete',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(response) {
        window.location.href = "{{route('admin.dashboard')}}"
      }
    });
  }
}
</script>
@endsection