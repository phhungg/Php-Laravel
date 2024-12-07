<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassowrd;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class AccountController extends Controller
{
    public function register(){
        return view('front.account.register');
    }
    public function login(){
        return view('front.account.login');
    }
    
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|same:confirmPassword',
            'confirmPassword' => 'required',
        ]);
        if($validator->passes()){ 
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            session()->flash('success','Bạn Đã Đăng Kí Thành Công !');
            return response()->json([
                'status' => true,
               'errors' => []
            ]);
          }
          else{
            return response()->json([
                'status' => false,
                'errors' =>$validator->errors()
            ]);
        };
    }
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' =>'required|email',
            'password' => 'required',
        ]);
        if($validator->passes()){
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                return redirect()->route('account.profile');
            }else{
                return redirect()->route('account.login')->with('error','Email hoặc Mật Khẩu Đăng Nhập Sai');
            }
        }
        else{
          return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
        }
    }
    public function profile(){
        $id = Auth::user()->id;
        $user = User::where('id',$id)->first(); //
       return view('front.account.profile',[
        'user' => $user,
       ]);
    }
    public function updateProfile(Request $request){
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$id.',id'
        ]);
        if($validator->passes()){
            $user= User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobiles = $request->mobile;
            $user->save();
            session()->flash('success','Bạn Đã Cập Nhật Thông Tin Thành Công!');
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
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }
    public function updateProfilePicture(Request $request){
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'image'=>'required|image',
        ]);
        if($validator->passes()){
            $image = $request->image;
            $ext=$image->getClientOriginalExtension();
            $imageName = $id.'-'.time().'.'.$ext; 
            $image->move(public_path('/image_Picture/'),$imageName);
            $sourcePath = public_path('/image_Picture/'.$imageName);
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);
            // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            $image->cover(150, 150);
            $image->toPng()->save(public_path('/image_Picture/thumb/'.$imageName));

            File::delete(public_path('/image_Picture/thumb/'.Auth::user()->image));
            File::delete(public_path('/image_Picture/'.Auth::user()->image));
            User::where('id',$id)->update(['image'=>$imageName]);
            session()->flash('success','Bạn Đã Cập Nhật Hình Ảnh Thành Công!');
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
    }
    public function createJob(){
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        $jobType = JobType::orderBy('name','ASC')->where('status',1)->get();
        return view('front.account.job.createJob',[
            'categories'=>$categories,
            'jobType'=>$jobType
        ]);
    }
    public function saveJob(Request $request){
        $rules = [
            'title'=>'required|min:5|max:200',
            'category'=>'required',
            'jobType'=>'required',
            'vacancy'=>'required|integer',
            'location'=>'required|max:50',
            'description'=>'required',
            'company_name'=>'required|min:3|max:75',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->passes()){
            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
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
            $job->save();
            session()->flash('success','Bạn Đã Tạo Tin Tuyển Dụng Thành Công!');
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
    public function myJob(){
        $jobs = Job::where('user_id',Auth::user()->id)->with('jobType')->orderBy('created_at','DESC')->paginate(10);
       return view('front.account.job.myjob',[
        'jobs'=>$jobs,
       ]);
    }
    public function editJob(Request $request,$id){
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        $jobType = JobType::orderBy('name','ASC')->where('status',1)->get();
        $job = Job::where([
            'user_id'=>Auth::user()->id,
            'id'=>$id
        ])->first(); 
        if($job==null){
            abort(404);
        }
        return view('front.account.job.edit',[
            'categories'=>$categories,
            'jobType'=>$jobType,
            'job'=>$job

        ]);
    } 
    public function updateJob(Request $request,$id){
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
            $job->user_id = Auth::user()->id;
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
    public function deleteJob(Request $request){
        $job = Job::where([
            'user_id'=>Auth::user()->id,
            'id'=>$request->jobId
        ])->first();
        if($job==null){
            session()->flash('error','Không tìm thấy công việc này');
            return response()->json([
                'status'=>true
            ]);
        }
        Job::where('id',$request->jobId)->delete();
        session()->flash('success','Bạn Đã Xóa Công Việc Thành Công!');
        return response()->json([
            'status'=>true
        ]);
    }
    public function myJobApplication(){
        $jobApplication = JobApplication::where('user_id',Auth::user()->id)->with(['job','job.jobType','job.application'])->orderBy('created_at','DESC')->paginate(10);
        return view('front.account.job.myjobapplication',[
            'jobApplication'=>$jobApplication
        ]);
    }
    public function removeJob(Request $request){
        $jobApplication=JobApplication::where(['id'=>$request->id,'user_id'=>Auth::user()->id])->first();
        if($jobApplication==null){
            session()->flash('error','Không tìm thấy ứng tuyển này');
            return response()->json([
               'status'=>false
            ]);
        }
        JobApplication::find($request->id)->delete();
        session()->flash('success','Bạn Đã Xóa Ứng Tuyển Thành Công!');
        return response()->json([
            'status'=>true
        ]);
    }
    public function accountSaveJob(){
       
        $savedJob = SavedJob::where([
            'user_id'=>Auth::user()->id
        ])->with(['job','job.jobType','job.application'])->paginate(10);
        return view('front.account.job.accountsavejob',[
            'savedJob'=>$savedJob
        ]);
    }
    public function removeSavedJob(Request $request){
        $savedJob=SavedJob::where(['id'=>$request->id,'user_id'=>Auth::user()->id])->first();
        if($savedJob==null){
            session()->flash('error','Không tìm thấy ứng tuyển này');
            return response()->json([
               'status'=>false
            ]);
        }
        SavedJob::find($request->id)->delete();
        session()->flash('success','Bạn Đã Xóa Công Việc Thành Công!');
        return response()->json([
            'status'=>true
        ]);
    }
    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(),[
            "old_password"=>'required',
            "new_password"=>'required|min:5',
            "confirm_password"=>'required|same:new_password',
        ]);
        if($validator->fails()){
            return response()->json([
               'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
        if(Hash::check($request->old_password,Auth::user()->password)==false){
            session()->flash('error','Mật khẩu cũ của bạn không chính xác');
            return response()->json([
               'status'=>true,
            ]);
        }   
        $user=User::find(Auth::user()->id);
        $user->password=Hash::make($request->new_password);
        $user->save();
        session()->flash('success','Bạn đã thay đổi mật khẩu thành công');
        return response()->json([
           'status'=>true,
        ]);
    }
    public function forgetPassword(){
        return view('front.account.forget_password');
    }
    public function processForgotPassword(Request $request){
        $validator = Validator::make($request->all(),[
            "email"=>'required|email|exists:users,email',
        ]);
        if($validator->fails()){
            return redirect()->route('forgetPassword')->withInput()->withErrors($validator);
        }
        $token = Str::random(10);
        DB::table('password_reset_tokens')->where('email',$request->email)->delete();
        DB::table('password_reset_tokens')->insert([   
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=> now(),
        ]);
        $user = User::where('email',$request->email)->first();
        $mailData = [
            'token'=>$token,
            'user'=>$user,
            'subject'=>'Bạn đã yêu cầu thay đổi mật khẩu'
        ];
        Mail::to($request->email)->send(new ResetPassowrd($mailData)); 
        return redirect()->route('forgetPassword')->with('success','Mật Khẩu của bạn đã được cập nhật lại và kiểm tra ở mail của bạn');
    }
    public function resetPassword($tokenString){
        $token = DB::table('password_reset_tokens')->where('token',$tokenString)->first();
        if($token==null){
            return redirect()->route('forgetPassword')->with('error','Không có Token');
        }
        return view('front.account.resetpassword',[
            'tokenString'=>$tokenString
        ]);
    }
    public function processResetPassword(Request $request){
        $token = DB::table('password_reset_tokens')->where('token',$request->token)->first();
        if($token==null){
            return redirect()->route('forgetPassword')->with('error','Không có Token');
        }
        $validator = Validator::make($request->all(),[
            "new_password"=>'required|min:5',
            "confirm_password"=>'required|same:new_password',
        ]);
        if($validator->fails()){
            return redirect()->route('resetPassword',$request->token)->withInput()->withErrors($validator);
        }
        User::where('email',$token->email)->update([
            'password'=>Hash::make($request->new_password)
        ]);
        return redirect()->route('account.login')->with('success','Bạn đã thay đổi mật khẩu thành công');
       
    }
    //
}