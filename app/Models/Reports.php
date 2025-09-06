<?php

namespace App\Models;

use App\Models\Member;

class Reports
{
    protected $exclusion = [];

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct($exclusion)
    {
        $this->exclusion = $exclusion;
    }

    /**
     * @return integer
     */
    public function getPedigrees()
    {
        return Member::where('upperFlag', 0)->max('pedigree');
    }

    /**
     * @return integer
     */
    public function getMembers()
    {
        return Member::where('upperFlag', 0)->whereNotIn('id', $this->exclusion)->whereNotIn('id', $this->exclusion)->count();
    }

    /**
     * @return integer
     */
    public function getLivingMembers()
    {
        return Member::where('upperFlag', 0)->whereNotIn('id', $this->exclusion)->whereNotIn('id', $this->exclusion)->count();
    }

    /**
     * @return integer
     */
    public function getSons()
    {
        return Member::where('upperFlag', 0)->whereNotIn('id', $this->exclusion)->where(function ($query) {
            $query->orWhereNotNull('parent_id');
            $query->orWhere('pedigree', 1);
        })->where('gender', 1)->count() - 1;
    }

    /**
     * @return integer
     */
    public function getDaughters()
    {
        return Member::where('upperFlag', 0)->whereNotIn('id', $this->exclusion)->where(function ($query) {
            $query->orWhereNotNull('parent_id');
            $query->orWhere('pedigree', 1);
        })->where('gender', 2)->count();
    }

    /**
     * @return integer
     */
    public function getSonInLaws()
    {
        return Member::where('upperFlag', 0)->whereNotIn('id', $this->exclusion)->whereNotNull('couple_id')->where('gender', 1)->count();
    }

    /**
     * @return integer
     */
    public function getDaughterInLaws()
    {
        return Member::where('upperFlag', 0)->whereNotIn('id', $this->exclusion)->whereNotNull('couple_id')->where('gender', 2)->count();
    }
}
