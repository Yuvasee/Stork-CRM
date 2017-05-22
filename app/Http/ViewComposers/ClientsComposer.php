<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\ClientType;
use App\ClientStatus;
use App\ClientSource;
use App\ProductGroup;
use App\User;

class ClientsComposer
{

    private $clientTypes, $clientStatuses, $clientSources, $users, $usersAll, $productGroups;

    public function __construct()
    {
        $this->clientTypes = ClientType::orderBy('sorting_num', 'asc')->pluck('name', 'id');
        $this->clientTypes->prepend("");

        $this->clientStatuses = ClientStatus::orderBy('sorting_num', 'asc')->pluck('name', 'id');
        $this->clientStatuses->prepend("");

        $this->clientSources = ClientSource::orderBy('sorting_num', 'asc')->pluck('name', 'id');
        $this->clientSources->prepend("");

        $this->users = User::active()->orderBy('name', 'asc')->pluck('name', 'id');
        $this->usersAll = User::orderBy('name', 'asc')->pluck('name', 'id');

        $this->productGroups = [];
        $pGroups = ProductGroup::orderBy('sorting_num', 'asc')->get();
        foreach ($pGroups as $key => $value) {
            $this->productGroups[$key] = [
                'id' => $value->id,
                'name' => $value->name
            ];
        }
    }

    public function compose(View $view)
    {
        $view->with([
            'clientTypes' => $this->clientTypes,
            'clientStatuses' => $this->clientStatuses,
            'clientSources' => $this->clientSources,
            'users' => $this->users,
            'usersAll' => $this->usersAll,
            'productGroups' => $this->productGroups
        ]);
    }
}