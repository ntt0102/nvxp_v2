<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Utils;
use App\Models\Reports;

class StatisticController extends Controller
{
    protected $pedigrees = 1;

    protected $members = 0;
    // protected $livingMembers = 0;
    //
    protected $sons = 0;
    // protected $livingSons = 0;
    //
    protected $daughters = 0;
    // protected $livingDaughters = 0;
    //
    //
    protected $daughterInLaws = 0;
    // protected $livingDaughterInLaws = 0;

    /**
     * Show the statistic.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $id = $request->input('id');
        $members = Member::where('upperFlag', 0)->where('id', $id)->get();
        if (count($members) > 0) {
            $member = $members->first();
            $basePedigree = $member->pedigree;
            //
            $report['id'] = $member->id;
            $report['name'] = $member->name;
            $report['pedigree'] = $member->pedigree;
            if ($id > 2) {
                $this->getMembers($members);
                $report['pedigrees'] = $this->pedigrees - $basePedigree + 1;
                $report['members'] = $this->members;
                $report['sons'] = $this->sons - 1;
                $report['daughters'] = $this->daughters;
                $report['daughterInLaws'] = $this->daughterInLaws;
            } else {
                $exclusion = [];
                if ($id == 2) array_push($exclusion, '1');
                $rpt = new Reports($exclusion);
                $report['pedigrees'] = $rpt->getPedigrees() - count($exclusion);
                $report['members'] = $rpt->getMembers();
                $report['sons'] = $rpt->getSons();
                $report['daughters'] = $rpt->getDaughters();
                $report['daughterInLaws'] = $rpt->getDaughterInLaws();
            }
        } else $report = null;
        //
        return view('general.statistic', compact('report'));
    }

    /**
     * Generate html.
     *
     * @return string html
     */
    private function getMembers($members)
    {
        foreach ($members as $key => $member) {
            $childs = Utils::getChildMembers($member->id);
            $hasChilds = count($childs);
            //
            $this->members++;
            //
            if ($member->pedigree == 1 || $member->parent_id) {
                if ($member->gender == 1) {
                    $this->sons++;
                } else {
                    $this->daughters++;
                }
            }
            if ($member->pedigree == 1 || $member->parent_id) {
                if ($member->gender == 2) {
                    $this->daughterInLaws++;
                }
            }
            //
            if ($member->pedigree > $this->pedigrees) $this->pedigrees = $member->pedigree;
            //
            // childrens
            if ($hasChilds) {
                $this->getMembers($childs);
            }
        }
    }
}
