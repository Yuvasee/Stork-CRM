<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\ActionType;
use App\User;
use App\ClientStatus;


class ActionsComposer
{

    private $actionTypes, $users, $actionStatuses, $clientStatuses;

    public function __construct()
    {
        $this->actionTypes = ActionType::orderBy('sorting_num', 'asc')->pluck('name', 'id');
        $this->actionTypes->prepend("");

        $this->users = User::active()->orderBy('name', 'asc')->pluck('name', 'id');

        $this->actionStatuses = [
            0 => 'Планируемое',
            1 => 'Прошедшее'
        ];

        $this->clientStatuses = ClientStatus::orderBy('sorting_num', 'asc')->pluck('name', 'id');
        $this->clientStatuses->prepend("");
    }

    public function compose(View $view)
    {
        $view->with([
            'users' => $this->users,
            'actionTypes' => $this->actionTypes,
            'actionStatuses' => $this->actionStatuses,
            'clientStatuses' => $this->clientStatuses
        ]);
    }
}