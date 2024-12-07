<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\dashboardController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\userController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\JobControllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/jobs',[JobControllers::class,'index'])->name('jobs');
Route::get('/jobs/detail/{id}',[JobControllers::class,'detailJob'])->name('detailJob');
Route::post('/applyjob',[JobControllers::class,'applyJob'])->name('applyJob');
Route::post('/savedjob', [JobControllers::class, 'savedJob'])->name('savedJob');
Route::get('/forgetpassword', [AccountController::class, 'forgetPassword'])->name('forgetPassword');
Route::get('/resetpassword/{token}', [AccountController::class, 'resetPassword'])->name('resetPassword');
Route::post('/processforgotpassword', [AccountController::class, 'processForgotPassword'])->name('processForgotPassword');
Route::post('/resetpassword', [AccountController::class, 'processResetPassword'])->name('processResetPassword');
Route::group(['prefix'=>'admin','middleware'=>'checkRole'],function(){
  Route::get('/dashboard',[dashboardController::class,'index'])->name('admin.dashboard');
  Route::get('/users',[userController::class,'index'])->name('admin.users');
  Route::get('/users/{id}',[userController::class,'edit'])->name('admin.users.edit');
  Route::put('/users/update/{id}',[userController::class,'update'])->name('admin.user.update');
  Route::delete('/users',[userController::class,'destroy'])->name('admin.destroy');
  Route::get('/jobs',[JobController::class,'index'])->name('admin.dashboard');
  Route::get('/jobs/edit/{id}',[JobController::class,'edit'])->name('admin.job.edit');
  Route::put('/jobs/{id}',[JobController::class,'update'])->name('admin.job.update');
  Route::delete('/jobs',[JobController::class,'destroy'])->name('admin.job.destroy');
  Route::get('/jobapplication',[JobApplicationController::class,'index'])->name('admin.jobApplication');
  Route::delete('/jobapplication',[JobApplicationController::class,'destroy'])->name('admin.jobApplication.destroy');
});
Route::group(['account'],function(){
  Route::group(['middleware'=>'guest'], function(){
    Route::get('/register',[AccountController::class,'register'])->name('account.register');
    Route::get('/login',[AccountController::class,'login'])->name('account.login');
    Route::post('/processRegister',[AccountController::class,'processRegister'])->name('account.processRegister');
    Route::post('/authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');
  });
  Route::group(['middleware'=>'auth'], function(){
  Route::get('/profile',[AccountController::class,'profile'])->name('account.profile');
  Route::get('/logout',[AccountController::class,'logout'])->name('account.logout');
  Route::put('/updateProfile',[AccountController::class,'updateProfile'])->name('account.updateProfile');
  Route::post('/updateProfilePicutre',[AccountController::class,'updateProfilePicture'])->name('account.updateProfilePicture');
  Route::get('/createjob',[AccountController::class,'createJob'])->name('account.createJob');
  Route::post('/savejob',[AccountController::class,'saveJob'])->name('account.saveJob');
  Route::post('/updatejob/{jobid}',[AccountController::class,'updateJob'])->name('account.updateJob');
  Route::post('/deletejob',[AccountController::class,'deleteJob'])->name('account.deleteJob');
  Route::post('/removejobapplication',[AccountController::class,'removeJob'])->name('account.removeJob');
  Route::get('/myjob',[AccountController::class,'myJob'])->name('account.myJob');
  Route::get('/myjob/edit/{jobid}',[AccountController::class,'editJob'])->name('account.editJob');
  Route::get('/myjobapplication',[AccountController::class,'myJobApplication'])->name('account.myJobApplication');
  Route::get('/savejobs',[AccountController::class,'accountSaveJob'])->name('account.accountSaveJob');
  Route::post('/removesavejobs',[AccountController::class,'removeSavedJob'])->name('account.removeSavedJob');
  Route::post('/changpassword',[AccountController::class,'updatePassword'])->name('account.updatePassword');
  });
});