<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Log;
use App\Models\User;
use App\Models\Member;
use Carbon\Carbon;
use App\Models\Classify;
use App\Models\Constant;
use App\Models\Propose;
use Illuminate\Support\Facades\File;

final class Utils
{
    /**
     * @param array|string $routes
     * @return bool
     */
    public static function checkRoute($routes)
    {
        if (is_string($routes)) {
            return Route::currentRouteName() == $routes;
        } elseif (is_array($routes)) {
            return in_array(Route::currentRouteName(), $routes);
        }

        return false;
    }
    /**
     * Get the color.
     *
     * @return color
     */
    public static function getColor()
    {
        $theme =  config('adminlte.theme');
        $skin = config('adminlte.skin');
        // 
        $color = new \stdClass();
        $color->theme = $theme;
        $color->skin = $skin;
        return $color;
    }
    /**
     * Get the get constant value.
     *
     * @param $id
     * @return string
     */
    public static function getConstantValue($id)
    {
        $constant = Constant::where('id', $id)->get()->first();
        return $constant ? $constant->value : '';
    }

    /**
     * Get the get constant value.
     *
     * @param $id
     * @return string
     */
    public static function getConstantDescription($id)
    {
        $constant = Constant::where('id', $id)->get()->first();
        return $constant ? $constant->description : '';
    }

    /**
     * Get the get classify.
     *
     * @param $group
     * @param $field
     * @param $value
     * @param $operation
     * @return string
     */
    public static function getClassifies($group, $field = null, $value = null, $operation = null)
    {
        $classify = Classify::where('constant_id', $group);
        if ($field && $value) {
            if (!$operation) $operation = '=';
            $classify = $classify->where($field, $operation, $value);
        }
        return $classify->orderBy('display_no', 'asc')->get();
    }

    /**
     * @param $type
     * @param $table
     * @param $is_error
     * @param null $action
     * @param null $note
     */
    public static function writeLog($type, $member)
    {
        if ($type == 3) {
            if ($member && $member->parent_id) $relation = ', ID của cha: ' . $member->parent_id;
            else if ($member && $member->couple_id) {
                if ($member && $member->gender == 1) $relation = ', ID của vợ: ' . $member->couple_id;
                else $relation = ', ID của chồng: ' . $member->couple_id;
            } else $relation = '';
        } else {
            $member = Member::leftjoin('members as parent', 'parent.id', 'members.parent_id')->leftjoin('members as couple', 'couple.id', 'members.couple_id')->select(
                'members.*',
                'parent.name AS parent_name',
                'couple.name AS couple_name'
            )->where('members.id', $member->id)->get()->first();
            if ($member && $member->parent_name) $relation = ', Cha: ' . $member->parent_name;
            else if ($member->couple_name) {
                if ($member->gender == 1) $relation = ', Vợ: ' . $member->couple_name;
                else $relation = ', Chồng: ' . $member->couple_name;
            } else $relation = '';
        }
        //
        $values['type'] = $type;
        $values['member_id'] = $member->id;
        $values['note'] = $member ? ($member->name . ', Hệ: ' . $member->pedigree . $relation) : '';
        $values['created_at'] = Carbon::now();
        $values['modified_by'] = Auth::user()->id;
        //
        $log = Log::create($values);
        return $log ? true : false;
    }

    /**
     *
     * @param $linkMemberId
     * @return $members
     */
    public static function getChildMembers($linkMemberId)
    {
        if (!empty($linkMemberId)) {
            $members = Member::where(function ($query) use ($linkMemberId) {
                $query->orWhere('couple_id', $linkMemberId);
                $query->orWhere('parent_id', $linkMemberId);
            })
                ->orderByRaw('COALESCE(ordinal_brother, 0) ASC')
                ->orderByRaw('COALESCE(marriage_step, 100) ASC')
                ->orderBy('id', 'ASC')
                ->get();
            return $members;
        } else return NULL;
    }

    /**
     *
     * @param $parents
     * @param $pedigree
     * @return $members
     */
    public static function getMemberOfBranch($parents, $pedigree)
    {
        $branches = [];
        if (count($parents) > 0) {
            foreach ($parents as $key => $parent) {
                if ($parent->pedigree == $pedigree) {
                    array_push($branches, $parent->id);
                } else {
                    $sons = Member::where('parent_id', $parent->id)->where('gender', 1)->get();
                    $branches = array_merge($branches, Utils::getMemberOfBranch($sons, $pedigree));
                }
            }
        }
        return $branches;
    }

    /**
     *
     * @return $propose count
     */
    public static function getProposes()
    {
        $count = Propose::where('edited_by', 0)->count();
        return $count;
    }
}
