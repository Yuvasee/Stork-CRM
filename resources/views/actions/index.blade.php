@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.actions') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.actions') }}
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('actions.index') !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">

            {{-- FILTER --}}
            <div class="box box-default">
                <div class="box-body">
                    {!! Form::open(['method' => 'GET', 'url' => '/actions', 'role' => 'search'])  !!}
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 form-group">
                            {{-- Dates --}}
                            <label for="filterDates">{{ trans('adminlte_lang::message.dates') }}</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="filterDates" name="filterDates">
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 form-group">
                            {{-- Manager --}}
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

                        <div class="col-lg-3 col-sm-6 form-group">
                            {{-- Клиент --}}
                            <label for="filterClient">Клиент</label>
                            <input type="text" class="form-control" id="filterClient" name="filterClient" value="{{ $filter['client'] }}">
                        </div>

                        <div class="col-lg-3 col-sm-6 form-group">
                            {{-- Город --}}
                            <label for="filterCity">Город</label>
                            <input type="text" class="form-control" id="filterCity" name="filterCity" value="{{ $filter['city'] }}">
                        </div>
                    </div>

                    <div class="row">
                    {{-- Статус --}}
                        <div class="col-md-10">
                            <div class="checkbox" style="margin-top: 0">
                                <label class="checkbox-inline">
                                    {!! Form::checkbox('filterStatuses[]', 0, in_array(0, $filter['statuses'])); !!} <i class="fa fa-spinner" aria-hidden="true"></i> Запланированные
                                </label>
                                <label class="checkbox-inline">
                                    {!! Form::checkbox('filterStatuses[]', 1,  in_array(1, $filter['statuses'])); !!} <i class="fa fa-check" aria-hidden="true"></i> Выполненные
                                </label>
                                <!--
                                <label class="checkbox-inline" style="color: lightgrey">
                                    {!! Form::checkbox('filterStatusess[]', 2,  in_array(1, $filter['statuses']), ['disabled']); !!} <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Просроченные
                                </label>
                                -->
                            </div>
                        </div>
                        <div class="col-md-2" style="text-align: right">
                            <button type="submit" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.applyfilter') }}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            {{-- Таблица данных --}}
            <div class="box box-primary">

                <div class="box-body">
                    {!! Form::open([
                        'method' => 'GET',
                        'url' => '/actions',
                        'class' => 'navbar-form navbar-right', 'role' => 'search', 'style' => 'margin: 0 0 5px 0; padding-right: 0'
                    ])  !!}
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

                    <table id="actions-table" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>@include('partials._th', ['field' => 'id', 'def_order' => 'desc'])</th>
                                <th></th>
                                <th>@include('partials._th', ['field' => 'date', 'def_order' => 'desc'])</th>
                                <th>@include('partials._th', ['field' => 'manager', 'def_order' => 'asc'])</th>
                                <th>@include('partials._th', ['field' => 'client', 'def_order' => 'asc'])</th>
                                <th>@include('partials._th', ['field' => 'city', 'def_order' => 'asc'])</th>
                                <th>@include('partials._th', ['field' => 'type', 'def_order' => 'asc'])</th>
                                <th>@include('partials._th', ['field' => 'description', 'def_order' => 'asc'])</th>
                                <th>@include('partials._th', ['field' => 'tags', 'def_order' => 'asc'])</th>
                                <th>{{ trans('adminlte_lang::message.contacts') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($actions as $item)
                            @php
                                $canUpdate = auth()->user()->can('update', $item);
                                $client = $item->client;
                            @endphp
                            <tr>
                                <td>
                                    @if($canUpdate)
                                        <a href="/actions/{{ $item->id }}/edit">{{ $item->id }}</a>
                                    @else
                                        {{ $item->id }}
                                    @endif
                                </td>
                                <td style="font-size: 150%" align="center">
                                    @include('actions.flag', ['flag' => $item->flag()])
                                </td>
                                <td>{{ $item->action_date->format('d.m.Y') }}</td>
                                <td>{{ $users[$item->manager_user_id] }}</td>
                                <td><a href="/clients/{{ $client->id }}/edit">{{ $client->name }}</a></td>
                                <td>{{ $client->city }}</td>
                                <td>{{ $actionTypes[$item->action_type_id] }}</td>
                                <td>
                                    @if($canUpdate)
                                        <a href="/actions/{{ $item->id }}/edit">{{ $item->description }}</a>
                                    @else
                                        {{ $item->description }}
                                    @endif
                                </td>
                                <td>{{ $item->tags }}</td>
                                <td style="font-size: 90%; color: #555">
                                    @include('clients._contacts', ['client' => $client])
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper"> {!! $actions->appends(['search' => Request::get('search')])->render() !!} </div>
                    <p>Всего событий: {{ number_format($actions->total(), 0, "", "&thinsp;") }}.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
      $(function () {
        $('#filterDates').daterangepicker(
            {
                "locale": {
                    "format": 'DD.MM.YYYY',
                    "separator": " - ",
                    "applyLabel": "Применить",
                    "cancelLabel": "Отмена",
                    "fromLabel": "С",
                    "toLabel": "По",
                    "monthNames": [
                        "Январь",
                        "Февраль",
                        "Март",
                        "Апрель",
                        "Май",
                        "Июнь",
                        "Июль",
                        "Август",
                        "Сентябрь",
                        "Октябрь",
                        "Ноябрь",
                        "Декабрь"
                    ],
                    "customRangeLabel": "Свой диапазон",
                    "daysOfWeek": [
                        "вс",
                        "пн",
                        "вт",
                        "ср",
                        "чт",
                        "пт",
                        "сб"
                    ],
                    "firstDay": 1,
                },
                "showCustomRangeLabel": false,
                "showDropdowns": true,
                "linkedCalendars": false,
                "ranges": {
                    "Сегодня": [
                        "{!! \Carbon\Carbon::now()->format('d.m.Y') !!}",
                        "{!! \Carbon\Carbon::now()->format('d.m.Y') !!}"
                    ],
                    "Завтра": [
                        "{!! \Carbon\Carbon::tomorrow()->format('d.m.Y') !!}",
                        "{!! \Carbon\Carbon::tomorrow()->format('d.m.Y') !!}"
                    ],
                    "Эта неделя": [
                        "{!! \Carbon\Carbon::parse('this week monday')->format('d.m.Y') !!}",
                        "{!! \Carbon\Carbon::parse('this week sunday')->format('d.m.Y') !!}"
                    ],
                    "Этот месяц": [
                        "{!! \Carbon\Carbon::parse('first day of this month')->format('d.m.Y') !!}",
                        "{!! \Carbon\Carbon::parse('last day of this month')->format('d.m.Y') !!}"
                    ],
                    "Этот год": [
                        "{!! \Carbon\Carbon::parse('first day of January ' . date('Y'))->format('d.m.Y') !!}",
                        "{!! \Carbon\Carbon::parse('last day of December ' . date('Y'))->format('d.m.Y') !!}"
                    ],
                },
                startDate: '{!! $filter['datesFrom']->format('d.m.Y') !!}',
                endDate: '{!! $filter['datesTo']->format('d.m.Y') !!}'
            }
        );
      });
    </script>
@endsection