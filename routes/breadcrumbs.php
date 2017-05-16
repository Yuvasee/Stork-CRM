<?php

// Главная
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push(trans('adminlte_lang::message.home'), route('home'));
});


/*
* События
**/

// Главная > События
Breadcrumbs::register('actions.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('adminlte_lang::message.actions'), route('actions.index'));
});

// Главная > События > Редактирование
Breadcrumbs::register('actions.edit', function($breadcrumbs, $action)
{
    $breadcrumbs->parent('actions.index');
    $breadcrumbs->push(mb_substr($action->client->name, 0, 40) . ', ' . $action->action_date->format('d.m.Y'), route('actions.edit', $action));
});


/*
* Клиенты
**/

// Главная > Клиенты
Breadcrumbs::register('clients.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('adminlte_lang::message.clients'), route('clients.index'));
});

// Главная > Клиенты > Редактирование
Breadcrumbs::register('clients.edit', function($breadcrumbs, $client)
{
    $breadcrumbs->parent('clients.index');
    $breadcrumbs->push(mb_substr($client->name, 0, 50), route('clients.edit', $client));
});

// Главная > Клиенты > Просмотр
Breadcrumbs::register('clients.show', function($breadcrumbs, $client)
{
    $breadcrumbs->parent('clients.index');
    $breadcrumbs->push(mb_substr($client->name, 0, 50), route('clients.show', $client));
});


/*
* Источники клиентов
**/

// Главная > Источники клиентов
Breadcrumbs::register('client-sources.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('adminlte_lang::message.clientsources'), route('client-sources.index'));
});

// Главная > Источники клиентов > Редактирование
Breadcrumbs::register('client-sources.edit', function($breadcrumbs, $clientsource)
{
    $breadcrumbs->parent('client-sources.index');
    $breadcrumbs->push(mb_substr($clientsource->name, 0, 50), route('client-sources.index'));
});

// Главная > Источники клиентов > Создание
Breadcrumbs::register('client-sources.create', function($breadcrumbs)
{
    $breadcrumbs->parent('client-sources.index');
    $breadcrumbs->push(trans('adminlte_lang::message.creation'), route('client-sources.index'));
});