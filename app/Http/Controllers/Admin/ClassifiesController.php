<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Controllers\ResourceController;
use App\Models\Constant;

class ClassifiesController extends Controller
{
    use ResourceController;

    /**
     * @var string
     */
    protected $resourceAlias = 'admin.classifies';

    /**
     * @var string
     */
    protected $resourceRoutesAlias = 'admin::classifies';

    /**
     * Fully qualified class name
     *
     * @var string
     */
    protected $resourceModel = Classify::class;

    /**
     * @var string
     */
    protected $resourceTitle = 'Danh mục';

    /**
     * @return string
     */
    private function setResourceTitle()
    {
        if (Auth::user()->role == 1) $this->resourceTitle = 'Chi phái';
    }

    /**
     * Used to validate store.
     *
     * @return array
     */
    private function resourceStoreValidationData(Request $request = null)
    {
        $myRole1 = Auth::user()->role == 1;
        return [
            'rules' => [
                'constant' => ($myRole1 ? '' : 'required') . '|numeric',
                'value' => 'string|max:191',
                'name' => 'required|string|max:191',
                'display_no' => 'nullable|numeric|min:1',
            ],
            'messages' => [],
            'attributes' => [],
        ];
    }

    /**
     * Used to validate update.
     *
     * @param $record
     * @return array
     */
    private function resourceUpdateValidationData($record, Request $request = null)
    {
        $myRole1 = Auth::user()->role == 1;
        return [
            'rules' => [
                'constant' => ($myRole1 ? '' : 'required') . '|numeric',
                'value' => 'string|max:191',
                'name' => 'required|string|max:191',
                'display_no' => 'nullable|numeric|min:1',
            ],
            'messages' => [],
            'attributes' => [],
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param null $record
     * @return array
     */
    private function getValuesToSave(Request $request, $record = null)
    {
        $myUser = Auth::user();
        $creating = is_null($record);
        $values = [];
        $values['constant_id'] = $myUser->role == 1 ? 4 : $request->constant;
        $values['value'] = $request->value;
        $values['name'] = $request->name;
        $values['display_no'] = $request->display_no;
        $values['modified_by'] = $myUser->id;

        return $values;
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
        $myUser = Auth::user();
        $records = $this->getResourceModel()::leftjoin('users', 'users.id', 'classifies.modified_by')
            ->leftjoin('members AS modified', 'modified.id', 'users.member_id')
            ->leftjoin('constants', 'constants.id', 'classifies.constant_id')
            ->select('classifies.*', 'constants.name as constant_name', 'modified.name as modified_name');
        //
        if ($myUser->role == 1) {
            $records = $records->where('classifies.modified_by', $myUser->id);
        }
        // Filter by Search
        if (!empty($search)) {
            $records = $records->where(function ($query) use ($search) {
                $query->orWhere('classifies.id', 'LIKE', '%' . $search . '%');
                $query->orWhere('classifies.name', 'LIKE', '%' . $search . '%');
                $query->orWhere('classifies.value', 'LIKE', '%' . $search . '%');
            });
        }
        // Filter by constant Select
        $constant_id = $request->constant;
        if (!empty($constant_id)) {
            $records = $records->where('classifies.constant_id', $constant_id);
        }
        //
        return $records = $records->orderBy('constants.name', 'asc')
            ->orderBy('classifies.display_no', 'asc')
            ->paginate($show);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param array $classifies
     * @return array
     */
    private function getFilterClassifies(Request $request = null)
    {
        $classifies['constants'] = Constant::where('array', 1)->orderBy('name', 'asc')->get();
        //
        if (!empty($request)) {
            $classifies['constant'] = $request->input('constant');
        }
        return $classifies;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param array $classifies
     * @return array
     */
    private function getFormClassifies(Request $request = null)
    {
        $classifies['constants'] = Constant::where('array', 1)->orderBy('name', 'asc')->get();
        //
        if (!empty($request)) {
            $classifies['constant'] = $request->input('constant');
        }
        return $classifies;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function addBranch(Request $request)
    {
        $myId = Auth::user()->id;
        $existsChk = $this->getResourceModel()::where('constant_id', 4)
            ->where('modified_by', $myId)->where('value', $request->id)->count();
        if ($existsChk) {
            return response()->json(array('status' => 'success'));
        }
        $values['constant_id'] = 4;
        $values['value'] = $request->id;
        $values['name'] = $request->name . ' (Hệ ' . $request->pedigree . ')';
        $values['modified_by'] = $myId;
        //
        $displayNoMax = $this->getResourceModel()::where('constant_id', 4)->max('display_no');
        $values['display_no'] = (int) $displayNoMax + 1;

        if ($this->getResourceModel()::create($values)) {
            return response()->json(array('status' => 'success', 'id' => $request->id));
        }
        return response()->json(array('status' => 'error'));
    }
}
