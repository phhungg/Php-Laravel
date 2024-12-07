@extends('front.layout.app')
@section('main')
<section class="section-4 bg-2">
  <div class="container pt-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class=" rounded-3 p-3">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                &nbsp;Trở về trang chủ</a></li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="container job_details_area">
    <div class="row pb-5">
      <div class="col-md-8">
        @include('front.layout.message')
        <div class="card shadow border-0">
          <div class="job_details_header">
            <div class="single_jobs white-bg d-flex justify-content-between">
              <div class="jobs_left d-flex align-items-center">

                <div class="jobs_conetent">
                  <a href="#">
                    <h4>{{$job->title}}</h4>
                  </a>
                  <div class="links_locat d-flex align-items-center">
                    <div class="location">
                      <p> <i class="fa fa-map-marker"></i>{{$job->location}}</p>
                    </div>
                    <div class="location">
                      <p> <i class="fa fa-clock-o"></i>{{$job->jobType->name}}</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="jobs_right">
                <div class="apply_now {{($count==1)?'save-job':''}}">
                  <a class="heart_mark" href="javascript:void(0);" onclick="saveJob('{{json_encode($job->id)}}')"> <i
                      class="fa fa-heart-o" aria-hidden="true"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="descript_wrap white-bg">
            <div class="single_wrap">
              <h4>Mô Tả Công Việc</h4>
              <p>{!!nl2br($job->description)!!}</p>
            </div>
            @if (!empty($job->responsibility))
            <div class="single_wrap">
              <h4>Yêu cầu ứng viên</h4>
              <p>{!!nl2br($job->responsibility)!!}</p>
            </div>
            @endif
            @if (!empty($job->qualification))
            <div class="single_wrap">
              <h4>Bằng Cấp Ứng Viên</h4>
              <p>{!!nl2br($job->qualification)!!}</p>
            </div>
            @endif
            @if (!empty($job->benefits))
            <div class="single_wrap">
              <h4>Quyền lợi được hưởng</h4>
              <p>{!!nl2br($job->benefits)!!}</p>
            </div>
            @endif
            <div class="border-bottom"></div>
            <div class="pt-3 text-end">
              @if (Auth::check())
              <a href="#" onclick="saveJob('{{json_encode($job->id)}}')" class="btn btn-secondary">Lưu</a>
              @else
              <a href="javascript:void(0);" class="btn btn-primary" disabled>Vui lòng đăng nhập để lưu công việc</a>
              @endif
              @if (Auth::check())
              <a href="#" onclick="applyJob('{{json_encode($job->id)}}')" class="btn btn-primary">Nộp CV</a>
              @else
              <a href="javascript:void(0);" class="btn btn-primary" disabled>Vui lòng đăng nhập để ứng tuyển vào vị trí
                này</a>
              @endif
            </div>
          </div>
        </div>
        @if (Auth::user())
        @if (Auth::user()->id == $job->user_id)


        <div class="card shadow border-0 mt-4">
          <div class="job_details_header">
            <div class="single_jobs white-bg d-flex justify-content-between">
              <div class="jobs_left d-flex align-items-center">
                <div class="jobs_conetent">
                  <h4>Hồ Sơ</h4>
                </div>
              </div>
              <div class="jobs_right">
              </div>
            </div>
          </div>
          <div class="descript_wrap white-bg">
            <table class="table table-striped">
              <tr>
                <th>Tên: </th>
                <th>Email:</th>
                <th>SDT:</th>
                <th>Ngày nộp đơn:</th>
              </tr>
              @if ($application->isNotEmpty())
              @foreach ($application as $applications )
              <tr>
                <td>{{$applications->user->name}}</td>
                <td>{{$applications->user->email}}</td>
                <td>{{$applications->user->mobile}}</td>
                <td>{{\Carbon\Carbon::parse($applications->applied_date)->format('d M, Y')}}</td>
              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="5">Không có hồ sơ nào </td>
              </tr>
              @endif
            </table>
          </div>
        </div>
        @endif
        @endif
      </div>
      <div class="col-md-4">
        <div class="card shadow border-0">
          <div class="job_sumary">
            <div class="summery_header pb-1 pt-4">
              <h3>Tóm tắt công việc</h3>
            </div>
            <div class="job_content pt-3">
              <ul>
                <li>Được đăng vào <span>{{\Carbon\Carbon::parse($job->created_at)->format('d M Y')}}</span></li>
                <li>Vị trí tuyển dụng: <span>{{$job->vacancy}}</span></li>
                @if (!empty($job->salary))
                <li>Mức lương: <span>{{$job->salary}}</span></li>
                @endif
                <li>Địa điểm: <span>{{$job->location}}</span></li>
                <li>Tính chất công việc: <span>{{$job->jobtype->name}}</span></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card shadow border-0 my-4">
          <div class="job_sumary">
            <div class="summery_header pb-1 pt-4">
              <h3>Chi tiết về công ty</h3>
            </div>
            <div class="job_content pt-3">
              <ul>
                <li>Tên <span>{{$job->company_name}}</span></li>
                @if (!empty($job->company_location))
                <li>Địa điểm: <span>{{$job->company_location}}</span></li>
                @endif
                @if (!empty($job->company_website))
                <li>Webite: <span><a href="{{$job->company_website}}">{{$job->company_website}}</a></span></li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
function applyJob(id) {
  if (confirm('Bạn có chắc muốn nộp đơn ứng tuyển vào vị trí công việc này không?')) {
    $.ajax({
      url: '{{route("applyJob")}}',
      type: 'post',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(response) {
        window.location.href = '{{url()->current()}}';
      }
    })
  }
}

function saveJob(id) {
  $.ajax({
    url: '{{route("savedJob")}}',
    type: 'post',
    data: {
      id: id
    },
    dataType: 'json',
    success: function(response) {
      window.location.href = '{{url()->current()}}';
    }
  })
}
</script>
@endsection