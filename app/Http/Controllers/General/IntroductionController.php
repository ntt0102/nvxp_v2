<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Utils;

class IntroductionController extends Controller
{
    /**
     * Show the introduction page.
     *
     * @return \Illuminate\Http\Response
     */
    public function introduction()
    {
        $content = Utils::getConstantDescription(8);
        return view('general.introduction', compact('content'));
    }

    /**
     * Show the teaching page.
     *
     * @return \Illuminate\Http\Response
     */
    public function teaching()
    {
        $content = Utils::getConstantDescription(3);
        return view('general.teaching', compact('content'));
    }
}
