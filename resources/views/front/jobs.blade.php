@extends('front.layout.app')
@section('main')
<section class="section-3 py-5 bg-2 ">
  <div class="container">
    <div class="row">
      <div class="col-6 col-md-10 ">
        <h2>Tìn Kiếm Công Việc</h2>
      </div>
      <div class="col-6 col-md-2">
        <div class="align-end">
          <select name="sort" id="sort" class="form-control">
            <option value="1" {{(Request::get('sort')=='1')?'selected':''}}>Mới Nhất</option>
            <option value="0" {{(Request::get('sort')=='0')?'selected':''}}>Cũ Nhất</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row pt-5">
      <div class="col-md-4 col-lg-3 sidebar mb-4">
        <form action="" name="searchForm" id="searchForm">
          <div class="card border-0 shadow p-4">
            <div class="mb-4">
              <h2>Từ Khóa</h2>
              <input value="{{Request::get('keyword')}}" type="text" name="keyword" id="keyword" placeholder="Keywords"
                class="form-control">
            </div>

            <div class="mb-4">
              <h2>Địa ĐIểm</h2>
              <input value="{{Request::get('location')}}" type="text" name="location" id="location"
                placeholder="Location" class="form-control">
            </div>

            <div class="mb-4">
              <h2>Danh Mục Công Việc</h2>
              <select name="category" id="category" class="form-control">
                <option value="">Lựa chọn</option>
                @if ($categories)
                @foreach ($categories as $category )
                <option {{(Request::get('category')==$category->id)?'selected':''}} value="{{$category->id}}">
                  {{$category->name}}
                </option>
                @endforeach
                @endif
              </select>
            </div>

            <div class="mb-4">
              <h2>Thể Loại Thời Gian</h2>
              @if ($jobType->isNotEmpty())
              @foreach ($jobType as $jobTypes )
              <div class="form-check mb-2">
                <input {{(in_array($jobTypes->id,$jobTypeArray))?'checked':''}} class="form-check-input "
                  name="job_types" type="checkbox" value="{{$jobTypes->id}}" id="job-type-{{$jobTypes->id}}">
                <label class="form-check-label " for="job-type-{{$jobTypes->id}}">{{$jobTypes->name}}</label>
              </div>
              @endforeach
              @endif
            </div>

            <div class="mb-4">
              <h2>Kinh Nghiệm</h2>
              <select name="experience" id="experience" class="form-control">
                <option value="">Lựa chọn kinh nghiệm
                </option>
                <option value="1" {{(Request::get('experience')==1)?'selected':''}}>Không Có Kinh Nghiệm (Intern)
                </option>
                <option value="2" {{(Request::get('experience')==2)?'selected':''}}>Dưới 1 Năm (Fresher)</option>
                <option value="3" {{(Request::get('experience')==3)?'selected':''}}>Từ 1 - 2 Năm (Junior)</option>
                <option value="4" {{(Request::get('experience')==4)?'selected':''}}>Từ 2 - 5 Năm (Middle)</option>
                <option value="5" {{(Request::get('experience')==5)?'selected':''}}>Trên 5 Năm (Senior)</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
            <a href="{{route("jobs")}}" class="btn btn-secondary mt-3">Làm Mới</a>
          </div>
        </form>
      </div>
      <div class="col-md-8 col-lg-9 ">
        <div class="job_listing_area">
          <div class="job_lists">
            <div class="row">
              @if ($job->isNotEmpty())
              @foreach ( $job as $jobs )
              <div class="col-md-4">
                <div class="card border-0 p-3 shadow mb-4">
                  <div class="card-body">
                    <h3 class="border-0 fs-5 pb-2 mb-0">{{$jobs->title}}</h3>
                    <p>{{Str::words(strip_tags($jobs->description),$words=10,'...')}}</p>
                    <div class="bg-light p-3 border">
                      <p class="mb-0">
                        <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                        <span class="ps-1">Địa chỉ: {{$jobs->location}}</span>
                      </p>
                      <p class="mb-0">
                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                        <span class="ps-1">Thời gian: {{$jobs->jobType->name}}</span>
                      </p>
                      <p class="mb-0">
                        <span class="fw-bolder"><i class="fa fa-key"></i></span>
                        <span class="ps-1">Từ khóa: {{$jobs->keywords}}</span>
                      </p>
                      <p class="mb-0">
                        <span class="fw-bolder"><i class="fa fa-briefcase"></i></span>
                        <span class="ps-1">Danh mục: {{$jobs->category->name}}</span>
                      </p>

                      @if (!is_null($jobs->salary))
                      <p class="mb-0">
                        <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                        <span class="ps-1">{{$jobs->salary}}</span>
                      </p>
                      @endif
                    </div>
                    <div class="d-grid mt-3">
                      <a href="{{route('detailJob',$jobs->id)}}" class="btn btn-primary btn-lg">Chi tiết</a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              <div class="col-md-12">
                {{$job->withQueryString()->links()}}
              </div>
              @else
              <h4>Công việc không tìm thấy</h4>
              @endif
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
@section('customJs')
<script>
$("#searchForm").submit(function(e) {
  e.preventDefault();
  var url = '{{route("jobs")}}?';
  var keyword = $("#keyword").val();
  var location = $("#location").val();
  var category = $("#category").val();
  var experience = $("#experience").val();
  var sort = $("#sort").val();
  var checkJobType = $("input[name='job_types']:checked").map(function() {
    return $(this).val();
  }).get();
  console.log(checkJobType);
  if (keyword != "") {
    url += '&keyword=' + keyword;
  }
  if (location != "") {
    url += '&location=' + location;
  }
  if (category != "") {
    url += '&category=' + category;
  }
  if (experience != "") {
    url += '&experience=' + experience;
  }
  if (checkJobType.length > 0) {
    url += '&jobType=' + checkJobType;
  }
  url += '&sort=' + sort;
  window.location.href = url;
});
$("#sort").change(function() {
  $("#searchForm").submit();
})
</script>
@endsection