<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push(trans('adminlte_lang::message.home'), route('home'));
});


/*
* Actions
**/

// Home > Actions
Breadcrumbs::register('actions.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('adminlte_lang::message.actions'), route('actions.index'));
});

// Home > Actions > Edit
Breadcrumbs::register('actions.edit', function($breadcrumbs, $action)
{
    $breadcrumbs->parent('actions.index');
    $breadcrumbs->push(mb_substr($action->client->name, 0, 40) . ', ' . $action->action_date->format('d.m.Y'), route('actions.edit', $action));
});


/*
* Clients
**/

// Home > Clients
Breadcrumbs::register('clients.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('adminlte_lang::message.clients'), route('clients.index'));
});

// Home > Clients > Edit
Breadcrumbs::register('clients.edit', function($breadcrumbs, $client)
{
    $breadcrumbs->parent('clients.index');
    $breadcrumbs->push(mb_substr($client->name, 0, 50), route('clients.edit', $client));
});

// Home > Clients > View
Breadcrumbs::register('clients.show', function($breadcrumbs, $client)
{
    $breadcrumbs->parent('clients.index');
    $breadcrumbs->push(mb_substr($client->name, 0, 50), route('clients.show', $client));
});


/*
* Client Sources
**/

// Home > Client Sources
Breadcrumbs::register('client-sources.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('adminlte_lang::message.clientsources'), route('client-sources.index'));
});

// Home > Client Sources > Edit
Breadcrumbs::register('client-sources.edit', function($breadcrumbs, $clientsource)
{
    $breadcrumbs->parent('client-sources.index');
    $breadcrumbs->push(mb_substr($clientsource->name, 0, 50), route('client-sources.edit', $clientsource->id));
});

// Home > Client Sources > Create
Breadcrumbs::register('client-sources.create', function($breadcrumbs)
{
    $breadcrumbs->parent('client-sources.index');
    $breadcrumbs->push(trans('adminlte_lang::message.creation'), route('client-sources.create'));
});


/*
* Action types
**/

// Home > Action types
Breadcrumbs::register('action-types.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('adminlte_lang::message.actiontypes'), route('action-types.index'));
});

// Home > Action types > Edit
Breadcrumbs::register('action-types.edit', function($breadcrumbs, $actiontype)
{
    $breadcrumbs->parent('action-types.index');
    $breadcrumbs->push(mb_substr($actiontype->name, 0, 50), route('action-types.edit', $actiontype->id));
});

// Home > Action types > Create
Breadcrumbs::register('action-types.create', function($breadcrumbs)
{
    $breadcrumbs->parent('action-types.index');
    $breadcrumbs->push(trans('adminlte_lang::message.creation'), route('action-types.create'));
});


/*
* Client types
**/

// Home > Client types
Breadcrumbs::register('client-types.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('adminlte_lang::message.clienttypes'), route('client-types.index'));
});

// Home > Client types > Edit
Breadcrumbs::register('client-types.edit', function($breadcrumbs, $clienttype)
{
    $breadcrumbs->parent('client-types.index');
    $breadcrumbs->push(mb_substr($clienttype->name, 0, 50), route('client-types.edit', $clienttype->id));
});

// Home > Client types > Create
Breadcrumbs::register('client-types.create', function($breadcrumbs)
{
    $breadcrumbs->parent('client-types.index');
    $breadcrumbs->push(trans('adminlte_lang::message.creation'), route('client-types.create'));
});


/*
* Client statuses
**/

// Home > Client statuses
Breadcrumbs::register('client-statuses.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('adminlte_lang::message.clientstatuses'), route('client-statuses.index'));
});

// Home > Client statuses > Edit
Breadcrumbs::register('client-statuses.edit', function($breadcrumbs, $clientstatus)
{
    $breadcrumbs->parent('client-statuses.index');
    $breadcrumbs->push(mb_substr($clientstatus->name, 0, 50), route('client-statuses.edit', $clientstatus->id));
});

// Home > Client statuses > Create
Breadcrumbs::register('client-statuses.create', function($breadcrumbs)
{
    $breadcrumbs->parent('client-statuses.index');
    $breadcrumbs->push(trans('adminlte_lang::message.creation'), route('client-statuses.create'));
});