@extends('front.layout.app')
@section('main')
<section class="section-5 bg-2">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
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
        <div class="card border-0 shadow mb-4">
          @include('front.layout.message')

          <form action="" method="post" name="editJobForm" id="editJobForm">
            <div class="card border-0 shadow mb-4 ">
              <div class="card-body card-form p-4">
                <h3 class="fs-4 mb-1">Chỉnh Sửa Chi Tiết Công Việc</h3>
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="" class="mb-2">Tên Công Việc<span class="req">*</span></label>
                    <input value="{{$job->title}}" type="text" placeholder="Job Title" id="title" name="title"
                      class="form-control">
                    <p></p>
                  </div>
                  <div class="col-md-6  mb-4">
                    <label for="" class="mb-2">Danh mục<span class="req">*</span></label>
                    <select name="category" id="category" class="form-control">
                      <option value="">Lựa chọn</option>
                      @if ($categories->isNotEmpty())
                      @foreach ($categories as $category )
                      <option {{($job->category_id==$category->id)?'selected':''}} value="{{$category->id}}">
                        {{$category->name}}
                      </option>
                      @endforeach
                      @endif
                    </select>
                    <p></p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="" class="mb-2">Tính Chất<span class="req">*</span></label>
                    <select class="form-select" name="jobType" id="jobType">
                      <option value="">Lựa chọn</option>
                      @if ($jobType->isNotEmpty())
                      @foreach ($jobType as $jobType )
                      <option {{($job->job_type_id==$jobType->id)?'selected':''}} value="{{$jobType->id}}">
                        {{$jobType->name}}</option>
                      @endforeach
                      @endif
                    </select>
                    <p></p>
                  </div>
                  <div class="col-md-6  mb-4">
                    <label for="" class="mb-2">Số Lượng</label><span class="req">*</span></label>
                    <input value="{{$job->vacancy}}" type="number" min="1" placeholder="Vacancy" id="vacancy"
                      name="vacancy" class="form-control">
                    <p></p>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-4 col-md-6">
                    <label for="" class="mb-2">Lương</label>
                    <input value="{{$job->salary}}" type="text" placeholder="Salary" id="salary" name="salary"
                      class="form-control">
                    <p></p>
                  </div>

                  <div class="mb-4 col-md-6">
                    <label for="" class="mb-2">Địa điểm<span class="req">*</span></label>
                    <input value="{{ $job -> location }}" type="text" placeholder="location" id="location"
                      name="location" class="form-control">
                    <p></p>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="" class="mb-2">Mô tả<span class="req">*</span></label>
                  <textarea class="textarea" name="description" id="description" cols="5" rows="5"
                    placeholder="Description">{{$job->description}}</textarea>
                  <p></p>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Quyền lợi</label>
                  <textarea class="textarea" name="benefits" id="benefits" cols="5" rows="5"
                    placeholder="Benefits">{{$job->benefits}}</textarea>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Trách nhiệm</label>
                  <textarea class="textarea" name="responsibility" id="responsibility" cols="5" rows="5"
                    placeholder="Responsibility">{{$job->responsibility}}</textarea>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Bằng cấp / Chứng chỉ</label>
                  <textarea class="textarea" name="qualification" id="qualification" cols="5" rows="5"
                    placeholder="Responsibility">{{$job->qualification}}</textarea>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Kinh Nghiệm Làm Việc</label>
                  <select name="experience" id="experience" class="form-control">
                    <option value="1" {{($job->experience==1)?'selected':'null'}}>Không Có Kinh Nghiệm (Intern)</option>
                    <option value="2" {{($job->experience==2)?'selected':'null'}}>Dưới 1 Năm (Fresher)</option>
                    <option value="3" {{($job->experience==3)?'selected':'null'}}>Từ 1 - 2 Năm (Junior)</option>
                    <option value="4" {{($job->experience==4)?'selected':'null'}}>Từ 2 - 5 Năm (Middle)</option>
                    <option value="5" {{($job->experience==5)?'selected':'null'}}>Trên 5 Năm (Senior)</option>

                  </select>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Từ khóa</label>
                  <input value="{{$job->keywords}}" type="text" placeholder="keywords" id="keywords" name="keywords"
                    class="form-control">
                </div>

                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Chi tiết công ty</h3>

                <div class="row">
                  <div class="mb-4 col-md-6">
                    <label for="" class="mb-2">Tên Công ty<span class="req">*</span></label>
                    <input value="{{$job->company_name}}" type="text" placeholder="Company Name" id="company_name"
                      name="company_name" class="form-control">
                    <p></p>
                  </div>

                  <div class="mb-4 col-md-6">
                    <label for="" class="mb-2">Địa chỉ Công ty</label>
                    <input value="{{$job->company_location}}" type="text" placeholder="Location" id="company_location"
                      name="company_location" class="form-control">
                  </div>
                </div>

                <div class="mb-4">
                  <label for="" class="mb-2">Website Công ty</label>
                  <input value="{{$job->company_website}}" type="text" placeholder="Website" id="company_website"
                    name="company_website" class="form-control">
                </div>
              </div>
              <div class="card-footer  p-4">
                <button type="submit" class="btn btn-primary">Cập Nhật Công Việc</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
$("#editJobForm").submit(function(e) {
  e.preventDefault();
  $("button[type='submit']").prop('disabled', true);
  $.ajax({
    url: '{{route("account.updateJob",$job->id)}}',
    type: 'post',
    dataType: 'json',
    data: $("#editJobForm").serializeArray(),
    success: function(response) {
      $("button[type='submit']").prop('disabled', false);
      if (response.status == true) {
        $("#title").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        $("#category").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        $("#jobType").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        $("#vacancy").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        $("#location").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        $("#description").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        $("#company_name").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        window.location.href = "{{route('account.myJob')}}";
      } else {
        var errors = response.errors;
        if (errors.title) {
          $("#title").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.title);
        } else {
          $("#title").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        }
        if (errors.category) {
          $("#category").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors
            .category);
        } else {
          $("#category").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        }
        if (errors.jobType) {
          $("#jobType").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors
            .jobType);
        } else {
          $("#jobType").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        }
        if (errors.vacancy) {
          $("#vacancy").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors
            .vacancy);
        } else {
          $("#vacancy").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        }
        if (errors.location) {
          $("#location").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors
            .location);
        } else {
          $("#location").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        }
        if (errors.description) {
          $("#description").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors
            .description);
        } else {
          $("#description").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        }
        if (errors.company_name) {
          $("#company_name").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors
            .company_name);
        } else {
          $("#company_name").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
        }
      }
    }
  })
})
</script>
@endsection