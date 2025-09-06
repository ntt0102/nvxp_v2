<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reports;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index', ['report' => new Reports([])]);
    }
}
