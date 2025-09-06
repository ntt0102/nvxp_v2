<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'pedigree', 'parent_id', 'couple_id', 'ordinal_brother', 'marriage_step', 'name', 'gender', 'note', 'upperFlag', 'created_at', 'updated_at', 'modified_by'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
