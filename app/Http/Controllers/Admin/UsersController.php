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
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use ResourceController;

    /**
     * @var string
     */
    protected $resourceAlias = 'admin.users';

    /**
     * @var string
     */
    protected $resourceRoutesAlias = 'admin::users';

    /**
     * Fully qualified class name
     *
     * @var string
     */
    protected $resourceModel = User::class;

    /**
     * @var string
     */
    protected $resourceTitle = 'Quản trị viên';

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
        $rules['member_id'] = 'required';
        $rules['role'] = 'required';
        $rules['username'] = 'required|string|max:191|unique:users,username';
        $rules['email'] = ($request->email ? 'email|string|max:191|unique:users,email' : 'nullable');
        $rules['password'] = 'required|string|confirmed';
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
        $rules['role'] = 'required';
        $rules['username'] = 'required|string|max:191|unique:users,username,' . $record->id;
        $rules['email'] = ($request->email ? 'email|string|max:191|unique:users,email,' . $record->id : 'nullable');
        $rules['password'] = ($request->password ? 'string|confirmed' : 'nullable');
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
        $creating = is_null($record);
        $values = [];
        //
        if ($creating) {
            $values['member_id'] = $request->member_id;
        }
        $values['role'] = $request->role;
        $values['username'] = $request->username;
        $values['email'] = $request->email;
        $password = $request->password;
        if ($creating || !empty($password)) {
            $values['password'] = $password;
        }
        //
        return $values;
    }

    private function alterValuesToSave(Request $request, $values)
    {
        if (array_key_exists('password', $values)) {
            if (!empty($values['password'])) {
                $values['password'] = Hash::make($values['password']);
            } else {
                unset($values['password']);
            }
        }
        return $values;
    }

    // /**
    //  * @param \Illuminate\Http\Request $request
    //  * @param $record
    //  */
    // private function doStoreSuccess($record = null, Request $request = null)
    // {
    //     return Utils::writeLog(1, $record);
    // }

    // /**
    //  * @param $record
    //  * @param $old
    //  */
    // private function doUpdateSuccess($record = null, $old = null)
    // {
    //     return Utils::writeLog(2, $record);
    // }

    // /**
    //  * @param $record
    //  */
    // private function doDestroySuccess($record = null, $old = null)
    // {
    //     return Utils::writeLog(3, $old);
    // }

    /**
     * @param $record
     * @return bool
     */
    private function checkDestroy($record)
    {
        $myUser = Auth::user();
        if (!$this->checkRole()) return false;
        if ($myUser->id == $record->id) {
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
        $records = $this->getResourceModel()::leftjoin('members', 'members.id', 'users.member_id');
        $records->leftjoin('classifies as roles', function ($join) {
            $join->on('roles.constant_id', DB::raw('6'));
            $join->on('roles.display_no', 'users.role');
        });
        $records->select(
            'users.*',
            'members.name',
            'members.pedigree',
            'roles.name as role_name'
        );
        // Filter by Id
        $id = $request->id;
        if (!empty($id)) {
            $records = $records->where('users.id', $id);
        }
        // Filter by Search
        if (!empty($search)) {
            $records = $records->where(function ($query) use ($search) {
                $query->orWhere('members.name', 'LIKE', '%' . $search . '%');
            });
        }
        //
        $records->orderBy('users.role', 'desc');
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
        $classifies['roles'] = Utils::getClassifies(6);
        $classifies['member'] = $request->input('id', '');
        //
        return $classifies;
    }

    public function showChangePasswordForm()
    {
        return view('admin.users.change-password', [
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
        ]);
    }

    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('oldpassword'), Auth::user()->password))) {
            return redirect()->back()->withInput()->withErrors([
                'oldpassword' => 'không đúng.'
            ]);
        }

        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|string|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        if ($user->save()) {
            flash()->success("Đổi mật khẩu thành công.");
        } else {
            flash()->error('Đổi mật khẩu thất bại.');
        }
        return redirect(route('admin::users.change-password'));
    }
}
