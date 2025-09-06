<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artisan;
use App\Utils;

class CommandController extends Controller
{
    /**
     * @return bool
     */
    private function checkAccess()
    {
        if(Auth::user()->role == 1){
            return false;
        }
        return true;
    }

    /**
     * Show the index.
     *
     * @return Response
     */
    public function index()
    {
    	if(!$this->checkAccess()) return view('errors.404');

        $commands = Utils::getClassifies(11);
        return view('admin.command.index', compact('commands'));
    }

    /**
     * Execute the command.
     *
     * @return Response
     */
    public function execute(Request $request)
    {
        if(!$this->checkAccess()) return view('errors.404');
        //
        $request->validate([
            'command' => 'required',
        ]);

        try {
            Artisan::call($request->command);
            flash()->success('Thực thi thành công.');
        }
        catch (\Exception $e) {
            flash()->error('Lỗi:<br>'.$e->getMessage());
        }

        return back();
    }

}
