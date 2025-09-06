<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propose extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proposes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'member_id', 'description', 'image', 'edited_by', 'created_at', 'updated_at'
    ];
}
