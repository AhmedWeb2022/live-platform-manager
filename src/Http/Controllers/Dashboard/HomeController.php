<?php

namespace ahmedWeb\LivePlatformManager\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // dd('test');
        return view('liveplatform::dashboard.layout.master');
    }
}
