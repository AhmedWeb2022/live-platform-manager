<?php

namespace ahmedWeb\LivePlatformManager\Http\Controllers\Dashboard;

use ahmedWeb\LivePlatformManager\DataTables\SessionDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    protected $view = 'liveplatform::dashboard.session.';


    public function index(SessionDataTable $dataTable)
    {
        return $dataTable->render($this->view . 'index');
    }
}
