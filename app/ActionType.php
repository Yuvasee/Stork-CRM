<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'action_types';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'sorting_num', 'color', 'description'];

    
}
