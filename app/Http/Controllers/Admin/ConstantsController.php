<?php

namespace App\Http\Controllers\Admin;

use App\Models\Constant;
use App\Models\Classify;
use App\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Controllers\ResourceController;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ConstantsController extends Controller
{
    use ResourceController;

    /**
     * @var string
     */
    protected $resourceAlias = 'admin.constants';

    /**
     * @var string
     */
    protected $resourceRoutesAlias = 'admin::constants';

    /**
     * Fully qualified class name
     *
     * @var string
     */
    protected $resourceModel = Constant::class;

    /**
     * @var string
     */
    protected $resourceTitle = 'Định danh';

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
     * Used to validate store.
     *
     * @return array
     */
    private function resourceStoreValidationData(Request $request = null)
    {
        return [
            'rules' => [
                'name' => 'required|string|max:191',
                'value' => 'required|string|max:191',
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
        return [
            'rules' => [
                'name' => 'required|string|max:191',
                'value' => 'required|string|max:191',
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
        $creating = is_null($record);
        $values = [];
        $values['name'] = $request->name;
        $values['value'] = $request->value;
        $values['array'] = $request->array ? 1 : 0;
        $values['description'] = $request->expand ? $request->description : null;
        
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
        $records = $this->getResourceModel()::where('constants.id', '>', 0);
        // Filter by Search
        if (! empty($search)) {
            $records = $records->where(function($query) use ($search){
                $query->orWhere('constants.id', 'LIKE', '%'.$search.'%');
                $query->orWhere('constants.name', 'LIKE', '%'.$search.'%');
                $query->orWhere('constants.value', 'LIKE', '%'.$search.'%');
             });
        }
        //
        return $records->select('constants.*')->orderBy('constants.name', 'asc')->paginate($show);
    }

    /**
     * @return $record
     * @return bool
     */
    private function checkDeleted($record)
    {
        if(Classify::where('constant_id', $record->id)->count() > 0){
            flash()->error('Định danh này có danh mục đang dùng.');
            return false;
        }
        return true;
    }
    
}
