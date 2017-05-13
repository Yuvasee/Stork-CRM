@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.import') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.import') }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-body">
                @if (config('app.locale') == 'ru')
                    @if ($message)
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-check"></i> Готово</h4>
                            Импортировано {{ $message['num'] }} записей типа {{ $message['type'] }}{{ isset($message['time']) ? ' за ' . $message['time'] . ' секунд' : '' }}.
                        </div>
                    @endif
                    <div class="alert alert-danger alert-dismissible">
                        <h4><i class="icon fa fa-ban"></i> Внимание!</h4>
                        Действия на этой странице могут привести к потере данных! Покиньте эту страницу, если вы не уверены.
                    </div>
                    <p><a href="/import/?action=action-types">Импортировать типы событий</a></p>
                    <p><a href="/import/?action=client-types">Импортировать типы клиентов</a></p>
                    <p><a href="/import/?action=client-statuses">Импортировать статусы клиентов</a></p>
                    <p><a href="/import/?action=client-sources">Импортировать источники клиентов</a></p>
                    <p><a href="/import/?action=product-groups">Импортировать товарные группы</a></p>
                    <p><a href="/import/?action=users">Импортировать пользователей</a></p>
                    <p><a href="/import/?action=clients">Импортировать клиентов</a></p>
                    <p><a href="/import/?action=client-product-group">Импортировать связи клиентов и продуктовых групп</a></p>
                    <p><a href="/import/?action=contact-persons">Импортировать контактные лица</a></p>
                    <p><a href="/import/?action=actions">Импортировать события</a></p>
                @else
                    @if ($message)
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-check"></i> It's done</h4>
                            Imported {{ $message['num'] }} rows of {{ $message['type'] }} type{{ isset($message['time']) ? ' in ' . $message['time'] . ' seconds' : '' }}.
                        </div>
                    @endif
                    <div class="alert alert-danger alert-dismissible">
                        <h4><i class="icon fa fa-ban"></i> Attention!</h4>
                        Actions on this page can lead to loss of data! Leave this page if you're not sure.
                    </div>
                    <p><a href="/import/?action=action-types">Import action types</a></p>
                    <p><a href="/import/?action=client-types">Import client types</a></p>
                    <p><a href="/import/?action=client-statuses">Import client statuses</a></p>
                    <p><a href="/import/?action=client-sources">Import client sources</a></p>
                    <p><a href="/import/?action=product-groups">Import product groups</a></p>
                    <p><a href="/import/?action=users">Import users</a></p>
                    <p><a href="/import/?action=clients">Import clients</a></p>
                    <p><a href="/import/?action=client-product-group">Import relationships between clients and product groups</a></p>
                    <p><a href="/import/?action=contact-persons">Import contacts</a></p>
                    <p><a href="/import/?action=actions">Import actions</a></p>
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection
