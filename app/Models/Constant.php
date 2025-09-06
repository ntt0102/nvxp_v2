<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constant extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'constants';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'value', 'array', 'description', 'created_at', 'updated_at'
    ];   
}