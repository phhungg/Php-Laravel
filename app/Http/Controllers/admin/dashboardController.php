<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index(){
        return view('admin.dashboard');  // Assuming the view file is located in resources/views/admin/dashboard.blade.php
    }
    //
}