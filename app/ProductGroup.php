<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_groups';

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

    public function clients()
    {
        return $this->belongsToMany('App\ProductGroup', 'client_product_group', 'product_group_id', 'client_id');
    }

    public static function getIds()
    {
        return self::pluck('id')->toArray();
    }
    
}
