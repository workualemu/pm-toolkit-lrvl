<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $project_id;

    public function __construct()
    {
        $this->site_settings = Setting::all();
        View::share('site_settings', $this->site_settings);
    }
}
