<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobControllers extends Controller
{
    
    public function index(Request $request){
        $categories = Category::where('status',1)->get();
        $jobType = JobType::where('status',1)->get();
        $job = Job::where('status',1);
        if(!empty($request->keyword)){
            $job = $job->where(function($query) use ($request){
                $query->orWhere('title','like','%'.$request->keyword.'%');
                $query->orWhere('keywords','like','%'.$request->keyword.'%');
            });
        };
        if(!empty($request->location)){
            $job = $job->where('location',$request->location);
        } 
        if(!empty($request->category)){
            $job = $job->where('category_id',$request->category);
        } 
        $jobTypeArray = [];
        if(!empty($request->jobType)){
            $jobTypeArray = explode(',',$request->jobType);
            $job = $job->whereIn('job_type_id',$jobTypeArray);
        }
        if(!empty($request->experience)){
            $job = $job->where('experience',$request->experience);
        }
        $job=$job->with(['jobType','category']);
        if($request->sort=='0'){
            $job=$job->orderBy('created_at','ASC');
        }else{
            $job = $job->orderBy('created_at','DESC');
        };
        $job=$job->paginate(9);
        return view('front.jobs',[
            'categories' => $categories,
            'jobType' => $jobType,
            'job' => $job,
            'jobTypeArray' => $jobTypeArray,
        ]);
    }
    public function detailJob($id){
        $job = Job::where([
            'id'=>$id,
            'status'=>1
        ])->with(['jobType','category'])->first();
        if($job==null){
            abort(404);
        }
        $count = 0;
        if(Auth::user()){
            $count = SavedJob::where([ 
                'user_id'=>Auth::user()->id,
                'job_id'=>$id
            ])->count(); 
            
        }
        $application = JobApplication::where('job_id',$id)->with('user')->get();
        return view('front.jobdetail',[
            'job' => $job,
            'count'=>$count,
            'application'=> $application
        ]);
    }
    public function applyJob(Request $request){
        $id = $request->id;
        $job=Job::where('id',$id)->first();
        if($job==null){
           session()->flash('error', 'Công việc này không tồn tại');
           return response()->json([
            'status'=>false,
            'message'=>'Công việc này không tồn tại'
           ]);
        }
        $employer_id=$job->user_id;
        if($employer_id==Auth::user()->id){  
            session()->flash('error', 'Bạn không thể nộp đon ứng tuyển vào công việc của bạn đã đăng!');
            return response()->json([
             'status'=>false,
             'message'=>'Bạn không thể nộp đon ứng tuyển vào công việc của bạn đã đăng!'
            ]);
        }
        $jobApplication = JobApplication::where([
            'user_id'=>Auth::user()->id,
            'job_id'=>$id
        ])->count();
        if($jobApplication>0){
            $message = 'Bạn sẵn sàng nộp đơn ứng tuyển công việc này rồi';
            session()->flash('error', $message);
            return response()->json([
             'status'=>false,
             'message'=>$message
            ]);
        } 
        $application = new JobApplication();
        $application->job_id=$id;
        $application->user_id=Auth::user()->id;
        $application->employer_id=$employer_id;
        $application->applied_date=now();
        $application->save();
        
        //Lệnh dùng để gửi email về người dùng
        $employer = User::where('id',$employer_id)->first();
        $mailData = [
            'employer'=>$employer,
            'user'=>Auth::user(),
            'job'=>$job,
        ];
        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));
        $message = 'Bạn đã nộp đơn ứng tuyển thành công vào công việc';
        session()->flash('success', $message);
        return response()->json([
         'status'=>true,
         'message'=>$message
        ]);
    }
   public function savedJob(Request $request){
    $id =$request->id;
    $job = Job::find($id);
    if($job==null){
        session()->flash('error', 'Công việc này không tồn tại');
        return response()->json([
            'status'=>false,
        ]);
    }
   $count = SavedJob::where([ 
        'user_id'=>Auth::user()->id,
        'job_id'=>$id
    ])->count(); //
    if($count>0){
        session()->flash('error', 'Bạn đã lưu công việc này rồi');
        return response()->json([
            'status'=>false,
        ]);
    }
    $savedJob = new SavedJob();
    $savedJob->job_id=$id;
    $savedJob->user_id=Auth::user()->id;
    $savedJob->save();
    session()->flash('success', 'Bạn đã lưu công việc này thành công');
    return response()->json([
        'status'=>true, 
    ]);
   }
    //
}