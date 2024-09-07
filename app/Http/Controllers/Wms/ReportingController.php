<?php

namespace App\Http\Controllers\Wms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportingController extends Controller
{
    public function allReporting()
    {
        return view('wms.reporting.all_reporting');
    }
}
