<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Utils;

class UpperMapController extends Controller
{
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
        $members = Member::where('pedigree', 1)->where('upperFlag', 1)->orderBy('ordinal_brother')->get();
        $this->generateHtml($members);
        $html = $this->html;
        return view('general.uppermap', compact('html', 'treeMode'));
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
            $this->html .= '">';
            //
            // <span> info
            $this->html .= '<div class="info"';
            $this->html .= ' memberId="' . $member->id . '"';
            $this->html .= ' pedigree="' . $member->pedigree . '"';
            //
            if ($member->gender == 1) {
                $relation = $member->couple_id ? 'Con rể' : 'Con trai';
                if ($member->pedigree == 1) $relation = 'Ông tổ';
            } else {
                $relation = $member->couple_id ? 'Con dâu' : 'Con gái';
                if ($member->pedigree == 1) $relation = 'Bà tổ';
            }
            $this->html .= ' relation="' . $relation . '"';
            //
            $this->html .= ' parentFlag="' . ($member->parent_id ? 1 : 0) . '"';
            //
            $this->html .= ' note="' . $member->note . '">';
            //
            // Relation
            $this->html .= '<div class="mark badge ';
            if ($member->parent_id || $member->pedigree == 1) {
                $this->html .= 'badge-info">';
                if ($member->pedigree > 1) {
                    if ($member->gender == 1) {
                        $this->html .= 'T';
                    } else {
                        $this->html .= 'G';
                    }
                    $this->html .= $member->ordinal_brother;
                } else $this->html .= 'OT';
            }

            if ($member->couple_id) {
                $this->html .= 'badge-danger">';
                if ($member->pedigree > 1) {
                    $this->html .= 'V';
                    //
                    if ($member->marriage_step) {
                        $this->html .= '' . $member->marriage_step;
                    }
                } else $this->html .= 'BT';
            }

            $this->html .= '</div>&nbsp;';
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
                $this->generateHtml($childs);
                $this->html .= '</ul>';
            }
            //
            // </li> main
            $this->html .= '</li>';
        }
    }
}
