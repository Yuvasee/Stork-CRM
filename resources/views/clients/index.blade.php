@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.clients') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.clients') }}
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('clients.index') !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">

            {{-- FILTER --}}
            <div class="box box-default">
                <div class="box-body">
                    {!! Form::open(['method' => 'GET', 'url' => '/clients', 'role' => 'search'])  !!}
                    <div class="row">
                        {{-- Manager --}}
                        <div class="col-lg-3 col-sm-6 form-group">
                            <label for="filterManager">{{ trans('adminlte_lang::message.manager') }}</label>
                            {!! Form::select('filterManager',
                                ['0' => '_все'] + $users->toArray(),
                                $filter['manager'],
                                [
                                    'class' => 'form-control',
                                    'id' => 'filterManager',
                                    'style' => 'margin-right: 1.5em'
                                ]) !!}
                        </div>

                        {{-- Type --}}
                        <div class="col-lg-3 col-sm-6 form-group">
                            <label for="filterType">{{ trans('adminlte_lang::message.clienttype') }}</label>
                            {!! Form::select('filterType',
                                ['0' => '_все'] + $clientTypes->toArray(),
                                $filter['type'],
                                [
                                    'class' => 'form-control',
                                    'id' => 'filterType',
                                    'style' => 'margin-right: 1.5em'
                                ]) !!}
                        </div>

                        {{-- City --}}
                        <div class="col-lg-3 col-sm-6 form-group">
                            <label for="filterCity">{{ trans('adminlte_lang::message.city') }}</label>
                            <input type="text" class="form-control" id="filterCity" name="filterCity" value="{{ $filter['city'] }}">
                        </div>

                        {{-- Status --}}
                        <div class="col-lg-3 col-sm-6 form-group">
                            <label for="filterStatus">{{ trans('adminlte_lang::message.status') }}</label>
                            {!! Form::select('filterStatus',
                                ['0' => '_все'] + $clientStatuses->toArray(),
                                $filter['status'],
                                [
                                    'class' => 'form-control',
                                    'id' => 'filterStatus',
                                    'style' => 'margin-right: 1.5em'
                                ]) !!}
                        </div>
                    </div>

                    <div class="row">
                    {{-- Product groups --}}
                        <div class="col-md-10">
                            <div class="checkbox" style="margin-top: 0">
                                <p class="checkbox-inline" style="padding-left: 0"><b>{{ trans('adminlte_lang::message.productgroups') }}</b></p>
                                @foreach($productGroups as $pg)
                                    <label class="checkbox-inline">
                                        {!! Form::checkbox(
                                            'filterProductGroups[]',
                                            $pg['id'],
                                            in_array($pg['id'], $filter['productGroups'])
                                        ); !!}
                                        {!! $pg['name'] !!}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-2" style="text-align: right">
                            {!! Form::hidden('isFiltered', 1) !!}
                            {!! Form::hidden('showAll', request('showAll', null)) !!}
                            <button type="submit" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.applyfilter') }}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            {{-- Data table --}}
            <div class="box box-primary">
                <div class="box-body">
                    <a href="{{ url('/clients/create') }}" class="btn btn-success btn-sm" title="{{ trans('adminlte_lang::message.add') }}">
                        <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('adminlte_lang::message.add') }}
                    </a>

                    {!! Form::open(['method' => 'GET', 'url' => '/clients', 'class' => 'navbar-form navbar-right', 'role' => 'search', 'style' => 'margin: 0 0 5px 0; padding-right: 0'])  !!}
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="{{ trans('adminlte_lang::message.search') }}..." value="{{ request('search') }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                    <br/>

                    <table id="clients-table" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>@include('clients._th', ['field' => 'id', 'def_order' => 'desc'])</th>
                                <th>@include('clients._th', ['field' => 'name', 'def_order' => 'asc'])</th>
                                <th>@include('clients._th', ['field' => 'city', 'def_order' => 'asc'])</th>
                                <th>@include('clients._th', ['field' => 'clienttype', 'def_order' => 'asc'])</th>
                                <th>@include('clients._th', ['field' => 'status', 'def_order' => 'asc'])</th>
                                <th>@include('clients._th', ['field' => 'manager', 'def_order' => 'asc'])</th>
                                <th>@include('clients._th', ['field' => 'tags', 'def_order' => 'asc'])</th>
                                <th>@include('clients._th', ['field' => 'actionlast', 'def_order' => 'desc'])</th>
                                <th>@include('clients._th', ['field' => 'actionnext', 'def_order' => 'desc'])</th>
                                <th>{{ trans('adminlte_lang::message.contacts') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><a href="{{ url('/clients/' . $item->id . '/edit') }}" title="Редактировать клиента">{{ $item->name }}</a></td>
                                <td>{{ $item->city }}</td>
                                <td>{{ $item->type->name }}</td>
                                <td>{{ $item->status->name }}</td>
                                <td>{{ $item->manager->name }}</td>
                                <td>
                                    {{ $item->tags }}
                                    @php
                                        $actionNext = $item->actionNext();
                                    @endphp
                                    @if($actionNext)
                                        @include('actions.flag', ['flag' => $item->actionNext()->flag()])
                                    @endif
                                </td>
                                <td>{{ $item->actionLast() ? $item->actionLast()->action_date->format('d.m.Y') : "&mdash;" }}</td>
                                <td>
                                    {{ $actionNext ? $actionNext->action_date->format('d.m.Y') : "&mdash;" }}
                                </td>
                                <td style="font-size: 90%; color: #555">
                                    @include('clients._contacts', ['client' => $item])
                                </td>
                                {{--
                                    <td>
                                        <a href="{{ url('/clients/' . $item->id) }}" title="View Client"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                        {!! Form::open([
                                            'method'=>'DELETE',
                                            'url' => ['/clients', $item->id],
                                            'style' => 'display:inline'
                                        ]) !!}
                                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger btn-xs',
                                                    'title' => 'Delete Client',
                                                    'onclick'=>'return confirm("Подтвердить удаление?")'
                                            )) !!}
                                        {!! Form::close() !!}
                                    </td>
                                --}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if(! request('showAll', null))
                        <div class="pagination-wrapper"> {!! $clients->appends(['search' => Request::get('search')])->render() !!} </div>
                        <p>Всего клиентов: {{ number_format($clients->total(), 0, "", "&thinsp;") }}. <a href="?showAll=1">Показать всех</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    {{--
    <script>
      $(function () {
        $('#clients-table').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "info": false,
          "rowReorder": false,
          "columnDefs": [{"type": "de_date", "targets": [7, 8]}],
          "order": [[ 0, "desc" ]],
        });
      });
    </script>
    --}}
@endsection