<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Utils;

class FilterController extends Controller
{
    /**
     * Show the filter page.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $show = (int) $request->input('show', '');
        $show = (is_numeric($show) && $show > 0 && $show <= 100) ? $show : 10;
        $classifies['show'] = $show;
        $classifies['isExecuted'] = "0";
        //
        if (Auth::user()) {
            $classifies['filterModes'] = Utils::getClassifies(5);
        } else {
            $classifies['filterModes'] = Utils::getClassifies(5, 'display_no', 3, '<=');
        }
        //
        $classifies['filterMode'] = trim($request->input('filterMode', ''));
        $classifies['view'] = trim($request->input('view', ''));
        $classifies['base'] = trim($request->input('base', ''));
        $classifies['name'] = trim($request->input('name', ''));
        $classifies['id'] = trim($request->input('id', ''));
        //
        $classifies['pedigrees'] = Member::max('pedigree');
        $classifies['pedigree'] = $request->input('pedigree', '');
        //
        $classifies['relations'] = Utils::getClassifies(2);
        $classifies['relation'] = $request->input('relation', '');
        //
        $classifies['parent'] = trim($request->input('parent', ''));
        //
        $classifies['couple'] = trim($request->input('couple', ''));
        //
        $classifies['note'] = trim($request->input('note', ''));
        //
        // query
        $records = Member::leftjoin('members as parent', 'parent.id', 'members.parent_id');
        $records = $records->leftjoin('members as couple', 'couple.id', 'members.couple_id');
        $records = $records->select(
            'members.*',
            'parent.name AS parent_name',
            'couple.name AS couple_name',
            DB::raw('SUBSTRING_INDEX(members.name, " ", -1) AS lastname')
        );
        $records = $records->where('members.upperFlag', 0)->orderBy('pedigree')->orderBy('lastname');
        if (in_array($classifies['filterMode'], ["1", "3", "5"])) {
            dd(1);
            $records = $records->where('members.gender', 1);
        }
        if ($classifies['id'] || $classifies['name'] || $classifies['pedigree'] || $classifies['relation'] || $classifies['parent'] || $classifies['couple'] || $classifies['note']) {
            $classifies['isExecuted'] = "1";
            if ($classifies['id']) {
                $records = $records->where('members.id', $classifies['id']);
            }
            if ($classifies['name']) {
                $records = $records->where('members.name', 'LIKE', '%' . $classifies['name'] . '%');
            }
            if ($classifies['pedigree']) {
                $records = $records->where('members.pedigree', $classifies['pedigree']);
            }
            if ($classifies['relation']) {
                if ($classifies['relation'] <= 2) {
                    $records = $records->whereNotNull('members.parent_id');
                    $records = $records->whereNull('members.couple_id');
                } else if ($classifies['relation'] <= 4) {
                    $records = $records->whereNotNull('members.couple_id');
                    $records = $records->whereNull('members.parent_id');
                } else {
                    $records = $records->where('members.pedigree', 1);
                }
                $records = $records->where('members.gender', $classifies['relation'] % 2 ? 1 : 2);
            }
            if ($classifies['parent']) {
                $records = $records->where('parent.name', 'LIKE', '%' . $classifies['parent'] . '%');
            }
            if ($classifies['couple']) {
                $records = $records->where('couple.name', 'LIKE', '%' . $classifies['couple'] . '%');
            }
            if ($classifies['note']) {
                $records = $records->where('members.note', 'LIKE', '%' . $classifies['note'] . '%');
            }
        } else $records = $records->where('members.id', 0);
        //


        $records = $records->paginate($show);

        //

        return view('general.filter', compact('records', 'classifies'));
    }
}
