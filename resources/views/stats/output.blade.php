@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Выработка
@endsection

@section('contentheader_title')
    Выработка
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-body">

                    {!! Form::open(['method' => 'GET', 'url' => '/stats/output', 'role' => 'search'])  !!}
                    {{-- Даты --}}
                    <label for="outputDates">{{ trans('adminlte_lang::message.dates') }}</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" id="outputDates" name="outputDates">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.show') }}</button>
                        </span>
                    </div>
                    {!! Form::close() !!}

                    <br>

                    <table id="data-tbl" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Менеджер</th>
                                <th><i class="fa fa-check text-green" aria-hidden="true"></i> Прошедших событий</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($managersActive as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->actions()->past()->from($dtFrom)->till($dtTo)->count() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <br>
                    <a href="#" style="border-bottom: dashed 1px;" onclick="$('#data-tbl2').toggle()">Уволенные</a>
                    <table id="data-tbl2" class="table table-bordered table-hover" style="display: none">
                        <thead>
                            <tr>
                                <th>Менеджер</th>
                                <th><i class="fa fa-check text-green" aria-hidden="true"></i> Прошедших событий</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($managersFired as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->actions()->past()->from($dtFrom)->till($dtTo)->count() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            var tbl = $('#data-tbl').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "info": false,
                "rowReorder": false,
            });
            tbl.order([1, 'desc']).draw();

            var tbl2 = $('#data-tbl2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "info": false,
                "rowReorder": false,
            });
            tbl2.order([1, 'desc']).draw();

            $('#outputDates').daterangepicker(
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
                    "showCustomRangeLabel": true,
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
                    startDate: '{!! $dtFrom->format('d.m.Y') !!}',
                    endDate: '{!! $dtTo->format('d.m.Y') !!}'
                }
            );
        });
    </script>
@endsection