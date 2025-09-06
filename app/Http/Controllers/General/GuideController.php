<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuideController extends Controller
{
    /**
     * Show the guide page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mode = $request->input("mode", "");
        return view('general.guide', compact('mode'));
    }
}
