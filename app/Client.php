<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

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
    protected $fillable = ['name', 'client_type_id', 'client_status_id', 'client_source_id', 'manager_user_id', 'phone_number', 'email', 'address', 'post_address', 'city', 'region', 'region_code', 'tags', 'additional_info', 'website', 'created_by_user_id'];

    public function type()
    {
        return $this->belongsTo('App\ClientType', 'client_type_id');
    }

    public function status()
    {
        return $this->belongsTo('App\ClientStatus', 'client_status_id');
    }

    public function source()
    {
        return $this->belongsTo('App\ClientSource', 'client_source_id');
    }

    public function manager()
    {
        return $this->belongsTo('App\User', 'manager_user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by_user_id');
    }

    public function productGroups()
    {
        return $this->belongsToMany('App\ProductGroup', 'client_product_group', 'client_id', 'product_group_id');
    }

    public function contactPersons()
    {
        return $this->hasMany('App\ContactPerson');
    }

    public function actions()
    {
        return $this->hasMany('App\Action');
    }

    public function actionsPast()
    {
        return $this->actions()->past()->orderBy('action_date', 'desc');
    }

    public function actionsFuture()
    {
        return $this->actions()->future()->orderBy('action_date', 'desc');
    }

    public function actionLast()
    {
        $actionLast = $this->actionsPast()->first();

        if(!empty($actionLast))
            return $actionLast;

        else
            return null;
    }

    public function actionNext()
    {
        $actionNext = $this->actions()->future()->orderBy('action_date', 'asc')->first();

        if(!empty($actionNext))
            return $actionNext;

        else
            return null;
    }

    public function scopeStatus1($query)
    {
        return $query
            ->where('client_status_id', '=', 1);
    }
}
