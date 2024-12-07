<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index(){
        $job = Job::orderBy('created_at','DESC')->with('user','application')->paginate(10);
        return view('admin.jobs.listjob',[
            'job' => $job
        ]);
    }
    public function edit($id){
       $job = Job::findOrFail($id);
       $category = Category::orderBy('name','ASC')->get();
       $jobType = JobType::orderBy('name','ASC')->get();
       return view('admin.jobs.editjob',[
           'job' => $job,
           'categories' => $category,
           'jobType' => $jobType
       ]);
    }
    public function update(Request $request,$id){
        $rules = [
            'title'=>'required|min:5|max:200',
            'category'=>'required',
            'jobType'=>'required',
            'vacancy'=>'required|integer',
            'location'=>'required|max:255',
            'description'=>'required',
            'company_name'=>'required|min:3|max:75',
        ];
        $validator = Validator::make($request->all(),rules: $rules);
        if($validator->passes()){
            $job = Job::find($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility= $request->responsibility;
            $job->qualification = $request->qualification;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->status = $request->status;
            $job->isFeatured = (!empty($request->isFeatured))?$request->isFeatured:0;
            $job->save();
            session()->flash('success','Bạn Đã Cập Nhật Tin Công Việc Thành Công!');
            return response()->json([
               'status' => true,
                'errors' => []
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        //
    }
    public function destroy(Request $request){
        $id = $request->id;
        $job = Job::find($id);
        if($job==null){
            session()->flash('error','Không tìm thấy công việc cần xóa');
            return response()->json([
                'status' => false,
            ]);
        }
        $job->delete();
        session()->flash('success','Bạn đã Xóa Tin Công Việc Thành Công!');
        return response()->json([
           'status' => true,
        ]);
    }
    //
}