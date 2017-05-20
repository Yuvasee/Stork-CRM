<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Action extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'actions';

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
    protected $fillable = ['client_id', 'status', 'action_date', 'action_type_id', 'manager_user_id', 'description', 'tags'];

    protected $dates = [
        'created_at',
        'updated_at',
        'action_date'
    ];
        
    /**
    * 
    * Connections
    *
    */
    public function type()
    {
        return $this->belongsTo('App\ActionType', 'action_type_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function manager()
    {
        return $this->belongsTo('App\User', 'manager_user_id');
    }

    /**
    * 
    * Scopes
    *
    */
    // Completed
    public function scopePast($query) // To be named 'scopeCompleted'
    {
        return $query->where('status', '=', 1);
    }

    // Planned
    public function scopeFuture($query)  // To be named 'scopePlanned'
    {
        return $query->where('status', '=', 0);
    }

    // Actual (deadline is coming)
    public function scopeActual($query)
    {
        return $query->where('status', '=', 0)
            ->Where('action_date', '<', Carbon::now()->addWeekdays(2)->toDateString());
    }

    // Deadline is today
    public function scopeToday($query)
    {
        return $query
            ->where('action_date', '=', Carbon::now()->toDateString());
    }

    // Overdue (deadline passed, still not completed)
    public function scopeOverdue($query)
    {
        return $query->where('status', '=', 0)
            ->Where('action_date', '<', Carbon::now()->toDateString());
    }

    // Date from
    public function scopeFrom($query, $dt)
    {
        return $query
            ->where('action_date', '>=', Carbon::parse($dt)->toDateString());
    }

    // Date till
    public function scopeTill($query, $dt)
    {
        return $query
            ->where('action_date', '<=', Carbon::parse($dt)->toDateString());
    }

    /**
    * 
    * Custom methods
    *
    */
    // Attention flag used in index tables (actions and clients)
    public function flag()
    {
        if(is_null($this->status) || is_null($this->action_date))
            return null;

        // Action completed, "check" flag
        if($this->status == 1)
        {
            return "check";
        }        

        // Deadline is today flag
        elseif($this->status != 1 && $this->action_date->isToday())
        {
            return "today";
        }

        // Overdue flag
        elseif($this->status != 1 && $this->action_date->isPast())
        {
            return "overdue";
        }

        // Planned in future action flag
        else
        {
            return "future";
        }
    }

}
