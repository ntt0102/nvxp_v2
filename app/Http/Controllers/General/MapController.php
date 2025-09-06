<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Utils;

class MapController extends Controller
{
    protected $base = '';
    protected $view = '';
    protected $viewPathMemberIds = [];
    protected $html = '';

    /**
     * Show the welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $treeMode = 'left';
        //
        $this->base = $request->input('base', '');
        $this->view = $request->input('view', '');
        $members = Member::where('upperFlag', 0)->orderBy('ordinal_brother');
        if ($this->base) {
            $members = $members->where('id', $this->base);
        } else {
            $members = $members->where('pedigree', 1)->where('gender', 1);
        }
        //
        $members = $members->get();
        $this->getviewPathMemberIds($this->view);
        $this->generateHtml($members);
        $html = $this->html;
        $relations = Utils::getClassifies(2, 'value', '4', '<=');
        return view('general.map', compact('html', 'treeMode', 'relations'));
    }

    /**
     * Show the welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMemberAjax(Request $request)
    {
        $memberId = $request->input('memberId', '');
        $members = Utils::getChildMembers($memberId);
        if ($members) {
            $this->generateHtml($members);
            return response()->json(array('status' => 'success', 'memberId' => $memberId, 'html' => $this->html));
        }
        return response()->json(array('status' => 'error'));
    }

    /**
     * getviewPathMemberIds.
     *
     * @return string html
     */
    private function getviewPathMemberIds($viewMemberId)
    {
        $viewMember = Member::find($viewMemberId);
        if ($viewMember) {
            array_push($this->viewPathMemberIds, $viewMemberId);
            // Get Link Member
            $linkMemberId = '';
            if ($viewMember->parent_id) $linkMemberId = $viewMember->parent_id;
            if ($viewMember->couple_id) $linkMemberId = $viewMember->couple_id;
            //
            if ($linkMemberId) {
                $this->getviewPathMemberIds($linkMemberId);
            }
        }
    }

    /**
     * Generate html.
     *
     * @return string html
     */
    private function generateHtml($members)
    {
        foreach ($members as $key => $member) {
            $childs = Utils::getChildMembers($member->id);
            $hasChilds = count($childs);
            $isBasePoint = $member->id == $this->base || $member->pedigree == 1;
            //
            // <li> main
            $this->html .= '<li class="';
            $this->html .= 'li' . $member->id . ' ';
            if ($hasChilds) {
                $this->html .= 'branch ';
            }
            if ($member->couple_id) {
                $this->html .= 'couple ';
            }
            if ($member->id == $this->view) {
                $this->html .= 'focus ';
            }
            $this->html .= '">';
            //
            // <span> info
            $this->html .= '<div class="info"';
            $this->html .= ' memberId="' . $member->id . '"';
            $this->html .= ' pedigree="' . $member->pedigree . '"';
            //
            if ($member->gender == 1) {
                $relation = $member->pedigree == 1 ? 'Ông tổ' : 'Con trai';
            } else {
                $relation = $member->couple_id ? 'Con dâu' : 'Con gái';
                if ($member->pedigree == 1) $relation = 'Bà tổ';
            }
            $this->html .= ' relation="' . $relation . '"';
            //
            $this->html .= ' parentFlag="' . ($member->parent_id ? 1 : 0) . '"';
            //
            $this->html .= ' note="' . $member->note . '"';
            //
            $this->html .= ' basePoint="' . ($isBasePoint ? 1 : 0) . '"';
            $this->html .= ' viewMark="' . ($member->id == $this->view ? 1 : 0) . '"';
            //
            $this->html .= ' parentPoint="' . ($member->gender == 1 ? 1 : 0) . '"';
            //
            $this->html .= ' hasChilds="' . ($hasChilds ? 1 : 0) . '"';
            $this->html .= '>';
            //
            // Relation
            if ($member->couple_id) {
                $this->html .= '<div class="mark badge ';
                $this->html .= 'badge-danger">';
                $this->html .= 'V';
                if ($member->marriage_step) {
                    $this->html .= '' . $member->marriage_step;
                }
                $this->html .= '</div>&nbsp;';
            } else if ($member->parent_id && $member->id != $this->base) {
                $this->html .= '<div class="mark badge ';
                $this->html .= 'badge-' . ($member->gender == 1 ? 'success' : 'info') . '">';
                if ($member->gender == 1) {
                    $this->html .= 'T';
                } else {
                    $this->html .= 'G';
                }
                $this->html .= $member->ordinal_brother;
                if ($member->marriage_step) {
                    $this->html .= ' (' . $member->marriage_step . ')';
                }
                $this->html .= '</div>&nbsp;';
            }
            //
            // Display Name
            $this->html .= '<div class="name">' . str_replace(' ', '[_]', mb_strtoupper($member->name)) . '</div>';
            //
            // </div> info
            $this->html .= '</div>';
            //
            // <div/> help
            $this->html .= '&nbsp;<div class="text-dark help"><i class="fas fa-info-circle"></i></div>';
            //
            // childrens
            if ($hasChilds) {
                $this->html .= '<ul class="ul' . $member->id . '">';
                if (in_array($member->id, $this->viewPathMemberIds) || $isBasePoint) {
                    $this->generateHtml($childs);
                }
                $this->html .= '</ul>';
            }
            //
            // </li> main
            $this->html .= '</li>';
        }
    }
}
