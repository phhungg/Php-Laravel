<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(){
      $application =  JobApplication::orderBy('created_at','DESC')->with('job','user','employer')->paginate(10);
      return view('admin.job-application.listapplication',[
        'application' => $application
      ]);
    }
    public function destroy(Request $request){
        $id = $request->id;
        $application = JobApplication::find($id);
        if($application==null){
            session()->flash('error','Không tìm thấy hồ sơ để xóa');
            return response()->json([
                'status' => false,
            ]);
        }
        $application->delete();
        session()->flash('success','Xóa hồ sơ thành công');
        return response()->json([
            'status' => true,
        ]);
    }
    //
}