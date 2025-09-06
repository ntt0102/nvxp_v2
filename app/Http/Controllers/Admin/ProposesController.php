<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Propose;
use Illuminate\Support\Facades\DB;

class ProposesController extends Controller
{

    /**
     * Show the proposes.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $paginatorData = [];
        $show = (int) $request->input('show', '');
        $show = (is_numeric($show) && $show > 0 && $show <= 100) ? $show : 10;
        if ($show != 10) {
            $paginatorData['show'] = $show;
        }
        $search = trim($request->input('search', ''));
        if (!empty($search)) {
            $paginatorData['search'] = $search;
        }
        $records = $this->getSearchRecords($request, $show, $search);
        $records->appends($paginatorData);
        //
        $classifies['show'] = $show;
        //
        return view('admin.proposes.index', [
            'records' => $records,
            'search' => $search,
            'classifies' => $classifies,
        ]);
    }

    /**
     * Retrieve the list of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $show
     * @param string|null $search
     * @return \Illuminate\Support\Collection
     */
    private function getSearchRecords(Request $request, $show = 15, $search = null)
    {
        $records = Propose::leftjoin('members', 'members.id', 'proposes.member_id')
            ->leftjoin('users', 'users.id', 'proposes.edited_by')
            ->leftjoin('members AS editor', 'editor.id', 'users.member_id');
        $records->select(
            'proposes.*',
            'members.name as member_name',
            'editor.name as editor_name'
        );
        // Filter by Search
        if (!empty($search)) {
            $records = $records->where(function ($query) use ($search) {
                $query->orWhere('proposes.description', 'LIKE', '%' . $search . '%');
                $query->orWhere('members.name', 'LIKE', '%' . $search . '%');
            });
        }
        //
        $records->orderBy('proposes.created_at', 'desc');
        return $records->paginate($show);
    }

    /**
     * Mark As Process a proposes.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return Response
     */
    public function markAsProcess(Request $request, $id)
    {
        $record = Propose::find($id);
        $valuesToSave['edited_by'] = Auth::user()->id;
        DB::beginTransaction();
        if ($record->update($valuesToSave)) {
            flash()->success('Đánh dấu thành công.');
            DB::commit();
        } else {
            flash()->error('Đánh dấu thất bại.');
            DB::rollBack();
        }
        return redirect(route('admin::proposes'));
    }

    /**
     * Mark As Process a proposes.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $record = Propose::find($id);
        DB::beginTransaction();
        if ($record->delete()) {
            flash()->success('Xóa thành công.');
            DB::commit();
        } else {
            flash()->error('Xóa thất bại.');
            DB::rollBack();
        }
        return redirect(route('admin::proposes'));
    }
}
