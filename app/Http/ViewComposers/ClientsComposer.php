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
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $clientTypes = ClientType::orderBy('sorting_num', 'asc')->pluck('name', 'id');
        $clientTypes->prepend("");

        $clientStatuses = ClientStatus::orderBy('sorting_num', 'asc')->pluck('name', 'id');
        $clientStatuses->prepend("");

        $clientSources = ClientSource::orderBy('sorting_num', 'asc')->pluck('name', 'id');
        $clientSources->prepend("");

        $users = User::active()->orderBy('name', 'asc')->pluck('name', 'id');

        $productGroups = [];
        $pGroups = ProductGroup::orderBy('sorting_num', 'asc')->get();
        foreach ($pGroups as $key => $value) {
            $productGroups[$key] = [
                'id' => $value->id,
                'name' => $value->name
            ];
        }

        $view->with(compact(
            'clientTypes',
            'clientStatuses',
            'clientSources',
            'users',
            'productGroups'
        ));
    }
}