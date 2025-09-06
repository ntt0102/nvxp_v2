<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Propose;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProposeMail;
use App\Models\User;

use Illuminate\Support\Facades\Config;
use App\Mail\BackupMail;

class ProposeController extends Controller
{
    /**
     * Show the propose.
     *
     * @return Response
     */
    public function index($id)
    {
        $memberId = $id;
        return view('general.propose', compact('memberId'));
    }

    /**
     * Save the propose.
     *
     * @param  Request  $request
     * @return Response
     */
    public function send(Request $request)
    {
        DB::beginTransaction();
        $this->validate($request, [
            'description' => 'required|string|max:1000',
        ]);
        //
        $image = $request->input('image');
        if ($image) {
            list(, $image) = explode(';', $image);
            list(, $image) = explode(',', $image);
            $image = base64_decode($image);
            //
            $imageName = time() . '.png';
            $save = File::put(public_path('images/proposes/' . $imageName), $image);
        } else {
            $imageName = NULL;
            $save = true;
        }
        //
        $memberId = $request->input('memberId', '');
        $saveValues = [
            'member_id' => $memberId,
            'description' => $request->input('description', ''),
            'image' => $imageName
        ];
        $propose = Propose::create($saveValues);
        //
        if ($save && $propose) {
            flash()->success('Gửi thành công.');
            DB::commit();
            $urlParameter = $request->input('param', '');
            if ($memberId) {
                return redirect(route('map') . '?' . $urlParameter);
            }
            $tos = User::leftjoin('members', 'members.id', 'users.member_id')
                ->select(
                    'users.email',
                    'members.name'
                )->get();
            foreach ($tos as $to) {
                Mail::to($to->email)->send(new ProposeMail($to->name));
            }
        } else {
            flash()->error('Gửi thất bại.');
            DB::rollBack();
        }
        return redirect(route('propose', $memberId));
    }
}
