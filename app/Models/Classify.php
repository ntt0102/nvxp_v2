<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classify extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'classifies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'constant_id', 'sub_id', 'value', 'name', 'display_no', 'created_at', 'updated_at', 'modified_by'
    ];

    /**
     * Get the modified user.
     */
    // public function modified_user()
    // {
    //     return $this->belongsTo('App\Models\User', 'modified_by');
    // }
}
