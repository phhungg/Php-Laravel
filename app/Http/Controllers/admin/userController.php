<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function index(){
        $users = User::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.user.list',[ 
            'users' => $users,
        ]);
    }
    public function edit($id){
        $user = User::findOrFail($id);
        return view('admin.user.edit',[
            'user' => $user,
        ]);
    }
    public function update($id,Request $request){
        $validator = Validator::make($request->all(),[
            'name' =>'required|min:5|max:255',
            'email' =>'required|email|unique:users,email,'.$id.',id'
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
    public function destroy(Request $request){
        $id = $request->id;
        $user = User::find($id);
        if($user==null){
            session()->flash('error','Không tìm thấy người dùng');
            return response()->json([
               'status' => false,
            ]);
        }
        $user->delete();
        session()->flash('success','Bạn Đã Xóa Người Dùng Thành Công!');
        return response()->json([
            'status' => true,
        ]);
    }
    //
}