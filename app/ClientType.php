<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'client_types';

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
