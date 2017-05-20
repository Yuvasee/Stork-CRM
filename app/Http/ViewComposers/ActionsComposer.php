<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\ActionType;
use App\User;
use App\ClientStatus;


class ActionsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $actionTypes = ActionType::orderBy('sorting_num', 'asc')->pluck('name', 'id');
        $actionTypes->prepend("");

        $users = User::active()->orderBy('name', 'asc')->pluck('name', 'id');

        $actionStatuses = [
            0 => 'Планируемое',
            1 => 'Прошедшее'
        ];

        $clientStatuses = ClientStatus::orderBy('sorting_num', 'asc')->pluck('name', 'id');
        $clientStatuses->prepend("");

        $view->with(compact(
            'users',
            'actionTypes',
            'actionStatuses',
            'clientStatuses'
        ));
    }
}