<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Classify;
use App\Models\Constant;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Utils;

class LogsController extends Controller
{
    /**
     * @return bool
     */
    private function checkAccess()
    {
        if (Auth::user()->role == 1) {
            return false;
        }
        return true;
    }

    /**
     * Show the logs.
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
        $classifies = $this->getClassifies($request);
        $classifies['show'] = $show;

        return view('admin.logs.index', [
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
        $records = Log::leftjoin('members', 'members.id', 'logs.member_id')->leftjoin('users', 'users.id', 'logs.modified_by')
            ->leftjoin('members as modified', 'modified.id', 'users.member_id');
        $records->leftjoin('classifies as type', function ($join) {
            $join->on('type.constant_id', DB::raw('9'));
            $join->on('type.display_no', 'logs.type');
        });
        $records->select(
            'logs.*',
            'members.name as member_name',
            'type.name as type_name',
            'modified.name as modified_name'
        );
        // Filter by Type of Log Select
        $type = $request->type;
        if (!empty($type)) {
            $records = $records->where('logs.type', $type);
        }
        // Filter by Search
        if (!empty($search)) {
            $records = $records->where(function ($query) use ($search) {
                $query->orWhere('members.name', 'LIKE', '%' . $search . '%');
                $query->orWhere('type.name', 'LIKE', '%' . $search . '%');
                $query->orWhere('logs.note', 'LIKE', '%' . $search . '%');
                $query->orWhere('modified.name', 'LIKE', '%' . $search . '%');
            });
        }
        //
        $records->orderBy('logs.created_at', 'desc');
        return $records->paginate($show);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param array $classifies
     * @return array
     */
    private function getClassifies(Request $request = null)
    {
        $classifies['types'] = Utils::getClassifies(9);
        if (!empty($request)) {
            $classifies['type'] = $request->type;
        }
        return $classifies;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        if ($this->checkAccess()) {
            DB::beginTransaction();
            //
            if ($request->id) {
                $status = true;
                $ids = explode(',', $request->id);
                foreach ($ids as $index => $id) {
                    $record = Log::find($id);
                    //
                    $deleteSts = $record->delete();
                    $status &= $deleteSts;
                }
            } else {
                $status = DB::delete('DELETE FROM logs');
            }
            if ($status) {
                flash()->success('Xóa lịch sử thành công.');
                DB::commit();
            } else {
                flash()->error('Xóa lịch sử thất bại.');
                DB::rollBack();
            }
        }
        return redirect(route('admin::logs'));
    }
}
