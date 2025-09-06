<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\User;
use App\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Controllers\ResourceController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MembersController extends Controller
{
    use ResourceController;

    /**
     * @var string
     */
    protected $resourceAlias = 'admin.members';

    /**
     * @var string
     */
    protected $resourceRoutesAlias = 'admin::members';

    /**
     * Fully qualified class name
     *
     * @var string
     */
    protected $resourceModel = Member::class;

    /**
     * @var string
     */
    protected $resourceTitle = 'Thành viên';

    /**
     * @var string
     */
    protected $listButtonIcon = '<i class="fas fa-list-alt"></i>';

    /**
     * @var string
     */
    protected $createButtonIcon = '<i class="fas fa-user-plus"></i>';

    /**
     * Used to validate store.
     *
     * @return array
     */
    private function resourceStoreValidationData(Request $request = null)
    {
        $relation = $request->relation;
        $rules = [
            'pedigree' => 'required|numeric',
            'name' => 'required|string|max:191',
            'gender' => 'nullable|numeric',
            'marriage_step' => 'nullable|numeric',
        ];
        if ($relation <= 2) {
            $rules['parent'] = 'required|numeric';
            $rules['ordinal_brother'] = 'required|numeric';
            if ($request->parent && $request->ordinal_brother) {
                $rules = array_merge($rules, [
                    'ordinal_brother' => Rule::unique('members')->where(function ($query) use ($request) {
                        $query->where('parent_id', $request->parent);
                    }),
                ]);
            }
        } else if ($relation != 5) {
            $rules['couple'] = 'required|numeric';
            if ($request->couple && $request->marriage_step) {
                $rules = array_merge($rules, [
                    'marriage_step' => Rule::unique('members')->where(function ($query) use ($request) {
                        $query->where('couple_id', $request->couple);
                    }),
                ]);
            }
        }
        //
        return [
            'rules' => $rules,
            'messages' => [
                'unique' => 'đã tồn tại',
            ],
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
        $relation = $request->relation;
        $rules = [
            'pedigree' => 'required|numeric',
            'name' => 'required|string|max:191',
            'gender' => 'nullable|numeric',
            'marriage_step' => 'nullable|numeric',
        ];
        if ($relation <= 2) {
            $rules['parent'] = 'required|numeric';
            $rules['ordinal_brother'] = 'required|numeric';
            if ($request->parent && $request->ordinal_brother) {
                $rules = array_merge($rules, [
                    'ordinal_brother' => Rule::unique('members')->ignore($record->id)->where(function ($query) use ($record) {
                        return $query->where('parent_id', $record->parent_id);
                    }),
                ]);
            }
        } else if ($relation != 5) {
            $rules['couple'] = 'required|numeric';
            if ($request->couple && $request->marriage_step) {
                $rules = array_merge($rules, [
                    'marriage_step' => Rule::unique('members')->ignore($record->id)->where(function ($query) use ($record) {
                        return $query->where('couple_id', $record->couple_id);
                    }),
                ]);
            }
        }
        //
        return [
            'rules' => $rules,
            'messages' => [
                'unique' => 'đã tồn tại',
            ],
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
        //
        $values['pedigree'] = $request->pedigree;
        $values['name'] = $request->name;
        $values['gender'] = $request->gender;
        $values['marriage_step'] = $request->marriage_step;
        //
        $relation = $request->relation;
        if ($relation <= 2) {
            $values['parent_id'] = $request->parent;
            $values['ordinal_brother'] = $request->ordinal_brother;
            $values['couple_id'] = null;
        } else if ($relation != 5) {
            $values['couple_id'] = $request->couple;
            $values['parent_id'] = null;
            $values['ordinal_brother'] = null;
        }
        //
        $note = $request->note;
        $values['note'] = $note ? $note : null;
        //
        $values['upperFlag'] = $myUser->role == 2 ? ($request->upperFlag ? 1 : 0) : 0;
        //
        return $values;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $record
     */
    private function doStoreSuccess($record = null, Request $request = null)
    {
        return Utils::writeLog(1, $record);
    }

    /**
     * @param $record
     * @param $old
     */
    private function doUpdateSuccess($record = null, $old = null)
    {
        return Utils::writeLog(2, $record);
    }

    /**
     * @param $record
     */
    private function doDestroySuccess($record = null, $old = null)
    {
        return Utils::writeLog(3, $old);
    }

    /**
     * @param $record
     * @return bool
     */
    private function checkDestroy($record)
    {
        $myUser = Auth::user();
        if (!$this->checkRole()) return false;
        if ($myUser->id == User::find($record->id)->id) {
            flash()->error('Không được xóa chính mình.');
            return false;
        }
        return true;
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
        //
        $records = $this->getResourceModel()::leftjoin('members as parent', 'parent.id', 'members.parent_id')->leftjoin('members as couple', 'couple.id', 'members.couple_id');
        if ($myUser->role == 1) {
            $records = $records->where('members.upperFlag', 0);
        }
        $records->select(
            'members.*',
            'parent.name AS parent_name',
            'couple.name AS couple_name'
        );
        // Filter by Id
        $id = $request->id;
        if (!empty($id)) {
            $records = $records->where('members.id', $id);
        }
        // Filter by Name
        $name = $request->name;
        if (!empty($name)) {
            $records = $records->where('members.name', 'LIKE', '%' . $name . '%');
        }
        // Filter by Pedigree
        $pedigree = $request->pedigree;
        if (!empty($pedigree)) {
            $records = $records->where('members.pedigree', $pedigree);
        }
        // Filter by Relation
        $relation = $request->relation;
        if (!empty($relation)) {
            if ($relation <= 2) {
                $records = $records->where('members.parent_id', "<>", "");
                $records = $records->where('members.gender', $relation % 2);
            } else {
                $records = $records->where('members.couple_id', "<>", "");
            }
        }
        // Filter by Parent Name
        $parent = $request->parent;
        if (!empty($parent)) {
            $records = $records->where('parent.name', 'LIKE', '%' . $parent . '%');
        }
        // Filter by Parent Name
        $couple = $request->couple;
        if (!empty($couple)) {
            $records = $records->where('couple.name', 'LIKE', '%' . $couple . '%');
        }
        // Filter by Note
        $note = $request->note;
        if (!empty($note)) {
            $records = $records->where('members.note', 'LIKE', '%' . $note . '%');
        }
        // Filter by Search
        if (!empty($search)) {
            $records = $records->where(function ($query) use ($search) {
                // $query->orWhere('members.id', $search);
                $query->orWhere('members.name', 'LIKE', '%' . $search . '%');
                $query->orWhere('members.note', 'LIKE', '%' . $search . '%');
            });
        }
        //
        $records->orderBy('members.pedigree', 'asc');
        //
        return $records->paginate($show);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param array $classifies
     * @return array
     */
    private function getFormClassifies(Request $request = null, $record = null)
    {
        $myUser = Auth::user();
        $classifies['formFiles'] = true;
        $classifies['page'] = $request->input('page', '');
        //
        $upperFlag = $request->input('upper', $record ? $record->upperFlag : 0);
        //
        if (!$upperFlag) {
            if (!$record) {
                $branchIdList = Member::select('members.id', 'members.name', 'members.pedigree')->join('classifies as branch', function ($join) use ($myUser) {
                    $join->on('branch.constant_id', DB::raw('4'));
                    $join->on('branch.value', 'members.id');
                    $join->on('branch.modified_by', DB::raw($myUser->id));
                })->whereNull('couple_id')->where('gender', 1)->get();
                $classifies['branches'] = $branchIdList;
            }
            $branch = $request->input('branch', '');
        }
        //
        $classifies['genders'] = Utils::getClassifies(1);
        //
        $branchMember = Member::find($branch);
        $classifies['pedigrees'][0] = $branchMember ? $branchMember->pedigree : 1;
        $classifies['pedigrees'][1] = Member::max('pedigree') + 1;
        $classifies['pedigree'] = $request->pedigree ? $request->pedigree : ($record ? $record->pedigree : '');
        //
        if ($classifies['pedigree'] == 1) {
            $classifies['relations'] = Utils::getClassifies(2);
        } else {
            $classifies['relations'] = Utils::getClassifies(2, 'value', '4', '<=');
        }

        if ($myUser->role == 2) {
            $classifies['roles'] = Utils::getClassifies(6);
            $classifies['role'] = $record && $record->role ? $record->role : 1;
        }
        //
        if ($classifies['pedigree']) {
            if ($record) {
                if ($record->gender == 1) {
                    $relation = $record->couple_id ? 3 : 1;
                    if ($record->pedigree == 1) $relation = 5;
                } else $relation = $record->couple_id ? 4 : 2;
            }
            $relation = $request->input('relation', '') ? $request->input('relation', '') : ($record ? $relation : '');
            //
            if ($relation) {
                $classifies['relation'] = $relation;
                $classifies['gender'] = $classifies['relation'] % 2 ? 1 : 2;
                //
                if (!$upperFlag) {
                    $branch = $request->input('branch', '');
                    if ($branch) {
                        $branchMember = Member::where('id', $branch)->get();
                    }
                }
                //
                if ($relation <= 2) {
                    $parent = $request->input('parent', '');
                    if ($parent) {
                        $classifies['parent'] = $parent;
                        $classifies['parents'] = Member::where('id', $parent)->get();
                    } else {
                        if ($upperFlag) {
                            // $classifies['parents'] = Member::leftjoin('members AS parent', 'parent.id', 'members.parent_id')->select('members.id', 'members.name', DB::raw('SUBSTRING_INDEX(parent.name, " ", -2) AS parent_name'))->where('members.pedigree', $classifies['pedigree']-1)->where('members.upperFlag', 1)->get();
                            $classifies['parents'] = Member::leftjoin('members AS parent', 'parent.id', 'members.parent_id')->select('members.id', 'members.name', DB::raw('parent.name AS parent_name'))->where('members.pedigree', $classifies['pedigree'] - 1)->where('members.upperFlag', 1)->get();
                        } else {
                            $branchMembers = $branch ? Utils::getMemberOfBranch($branchMember, $classifies['pedigree'] - 1) : [$record ? $record->parent_id : null];
                            $classifies['parents'] = Member::leftjoin('members AS parent', 'parent.id', 'members.parent_id')->select('members.id', 'members.name', DB::raw('parent.name AS parent_name'))->whereIn('members.id', $branchMembers)->where('members.upperFlag', 0)->get();
                        }
                    }
                } else {
                    $couple = $request->input('couple', '');
                    if ($couple) {
                        $classifies['couple'] = $couple;
                        $classifies['couples'] = Member::where('id', $couple)->get();
                    } else {
                        if ($upperFlag) {
                            $classifies['couples'] = Member::leftjoin('members AS parent', 'parent.id', 'members.parent_id')->select('members.id', 'members.name', DB::raw('parent.name AS parent_name'))->where('members.pedigree', $classifies['pedigree'])->where('members.upperFlag', 1)->get();
                        } else {
                            $branchMembers = $branch ? Utils::getMemberOfBranch($branchMember, $classifies['pedigree']) : [$record ? $record->couple_id : null];
                            $classifies['couples'] = Member::leftjoin('members AS parent', 'parent.id', 'members.parent_id')->select('members.id', 'members.name', DB::raw('parent.name AS parent_name'))->whereIn('members.id', $branchMembers)->where('members.upperFlag', 0)->get();
                        }
                    }
                }
            }
        }
        $classifies['branch'] = $branch;
        $classifies['upperFlag'] = $upperFlag;
        //
        return $classifies;
    }
}
