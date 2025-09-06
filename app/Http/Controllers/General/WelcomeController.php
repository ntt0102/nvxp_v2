<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils;

class WelcomeController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $content = Utils::getConstantDescription(7);
        return view('general.welcome', compact('content'));
    }
}
