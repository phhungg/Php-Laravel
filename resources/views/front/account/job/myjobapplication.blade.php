@extends('front.layout.app')
@section('main')
<section class="section-5 bg-2">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="">Trang Chủ</a></li>
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
        <div class="card border-0 shadow mb-4 p-3">
          <div class="card-body card-form">
            <div class="d-flex justify-content-between">
              <div>
                <h3 class="fs-4 mb-1">Công việc của tôi</h3>
              </div>
              <div style="margin-top: -10px;">
                <a href="{{route('account.createJob')}}" class="btn btn-primary">Post a Job</a>
              </div>

            </div>
            <div class="table-responsive">
              <table class="table ">
                <thead class="bg-light">
                  <tr>
                    <th scope="col">Tên công việc</th>
                    <th scope="col">Ngày nộp đơn</th>
                    <th scope="col">Hồ sơ</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hoạt động</th>
                  </tr>
                </thead>
                <tbody class="border-0">
                  @if ($jobApplication->isNotEmpty())
                  @foreach ($jobApplication as $jobApplications )
                  <tr class="active">
                    <td>
                      <div class="job-name fw-500">{{$jobApplications->job->title}}</div>
                      <div class="info1">{{$jobApplications->job->jobType->name}} - {{$jobApplications->job->location}}
                      </div>
                    </td>
                    <td>{{\Carbon\Carbon::parse($jobApplications->created_at)->format('d,M,Y')}}</td>
                    <td>{{$jobApplications->job->application->count()}} Hồ sơ</td>
                    <td>
                      @if ($jobApplications->job->status==1)
                      <div class="job-status text-capitalize">mở</div>
                      @else
                      <div class="job-status text-capitalize">đóng</div>
                      @endif
                    </td>
                    <td>
                      <div class="action-dots float-end">
                        <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="{{route("detailJob",$jobApplications->job_id)}}"> <i
                                class="fa fa-eye" aria-hidden="true"></i> Xem</a></li>
                          <li><a class="dropdown-item" onclick="removeJob('{{$jobApplications->id}}')"><i
                                class="fa fa-trash" aria-hidden="true"></i>
                              Xóa</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan="5">
                      <h5>Bạn chưa nộp đơn vào công việc nào cả</h5>
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
            <div>{{$jobApplication->links()}}</div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
function removeJob(id) {
  if (confirm('Bạn có chắc muốn bỏ công việc này ?')) {
    $.ajax({
      url: '{{route("account.removeJob")}}',
      type: 'post',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(response) {
        window.location.href = '{{route("account.myJobApplication")}}';
      }
    });
  } else {}
}
</script>
@endsection