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
        <div class="card border-0 shadow mb-4">
          @include('front.layout.message')

          <form action="" method="post" name="createJobForm" id="createJobForm">
            <div class="card border-0 shadow mb-4 ">
              <div class="card-body card-form p-4">
                <h3 class="fs-4 mb-1">Chi tiết công việc</h3>
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="" class="mb-2">Tên công việc<span class="req">*</span></label>
                    <input type="text" placeholder="Job Title" id="title" name="title" class="form-control">
                    <p></p>
                  </div>
                  <div class="col-md-6  mb-4">
                    <label for="" class="mb-2">Danh mục<span class="req">*</span></label>
                    <select name="category" id="category" class="form-control">
                      <option value="">Lựa chọn danh mục</option>
                      @if ($categories->isNotEmpty())
                      @foreach ($categories as $category )
                      <option value="{{$category->id}}">{{$category->name}}</option>
                      @endforeach
                      @endif
                    </select>
                    <p></p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="" class="mb-2">Tính chất<span class="req">*</span></label>
                    <select class="form-select" name="jobType" id="jobType">
                      <option value="">Lựa chọn tính chất công việc</option>
                      @if ($jobType->isNotEmpty())
                      @foreach ($jobType as $jobType )
                      <option value="{{$jobType->id}}">{{$jobType->name}}</option>
                      @endforeach
                      @endif
                    </select>
                    <p></p>
                  </div>
                  <div class="col-md-6  mb-4">
                    <label for="" class="mb-2">Số lượng tuyển dụng<span class="req">*</span></label>
                    <input type="number" min="1" placeholder="Số lượng" id="vacancy" name="vacancy"
                      class="form-control">
                    <p></p>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-4 col-md-6">
                    <label for="" class="mb-2">Lương</label>
                    <input type="text" placeholder="Lương" id="salary" name="salary" class="form-control">
                    <p></p>
                  </div>

                  <div class="mb-4 col-md-6">
                    <label for="" class="mb-2">Địa Điểm<span class="req">*</span></label>
                    <input type="text" placeholder="Địa Điểm" id="location" name="location" class="form-control">
                    <p></p>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="" class="mb-2">Mô Tả Công Việc<span class="req">*</span></label>
                  <textarea class="textarea" name="description" id="description" cols="5" rows="5"
                    placeholder="Mô tả"></textarea>
                  <p></p>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Quyền Lợi Công Việc</label>
                  <textarea class="textarea" name="benefits" id="benefits" cols="5" rows="5"
                    placeholder="Quyền Lợi"></textarea>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Trách Nhiệm Ứng Viên</label>
                  <textarea class="textarea" name="responsibility" id="responsibility" cols="5" rows="5"
                    placeholder="Trách Nhiệm"></textarea>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Bằng Cấp / Chứng chỉ (Nếu có)</label>
                  <textarea class="textarea" name="qualification" id="qualification" cols="5" rows="5"
                    placeholder="Bằng Cấp / Chứng chỉ"></textarea>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Kinh Nghiệm Làm Việc</label>
                  <select name="experience" id="experience" class="form-control">
                    <option value="1">Không Có Kinh Nghiệm (Intern)</option>
                    <option value="2">Dưới 1 Năm (Fresher)</option>
                    <option value="3">Từ 1 - 2 Năm (Junior)</option>
                    <option value="4">Từ 2 - 5 Năm (Middle)</option>
                    <option value="5">Trên 5 Năm (Senior)</option>

                  </select>
                </div>
                <div class="mb-4">
                  <label for="" class="mb-2">Từ Khóa Công Việc</label>
                  <input type="text" placeholder="Từ khóa" id="keywords" name="keywords" class="form-control">
                </div>

                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Chi tiết công ty</h3>

                <div class="row">
                  <div class="mb-4 col-md-6">
                    <label for="" class="mb-2">Tên Công Ty<span class="req">*</span></label>
                    <input type="text" placeholder="Company Name" id="company_name" name="company_name"
                      class="form-control">
                    <p></p>
                  </div>

                  <div class="mb-4 col-md-6">
                    <label for="" class="mb-2">Địa Chỉ Công Ty</label>
                    <input type="text" placeholder="Location" id="company_location" name="company_location"
                      class="form-control">
                  </div>
                </div>

                <div class="mb-4">
                  <label for="" class="mb-2">Website Công Ty</label>
                  <input type="text" placeholder="Website" id="company_website" name="company_website"
                    class="form-control">
                </div>
              </div>
              <div class="card-footer  p-4">
                <button type="submit" class="btn btn-primary">Lưu CÔng Việc</button>
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
$("#createJobForm").submit(function(e) {
  e.preventDefault();
  $("button[type='submit']").prop('disabled', true);
  $.ajax({
    url: '{{route("account.saveJob")}}',
    type: 'post',
    dataType: 'json',
    data: $("#createJobForm").serializeArray(),
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