<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">
                <div style="margin-bottom: 0.5em">
                    <a href="{{ url('/actions/create') }}?client_id={{ $client->id }}&back_to_url={{ \Request::path() }}&hash={{ $tab }}&status={{ $status }}" class="btn btn-success btn-xs" title="Добавить">
                        <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('adminlte_lang::message.add') }}
                    </a>
                </div>
                <table id="actions-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('adminlte_lang::message.id') }}</th>
                            <th></th>
                            <th>{{ trans('adminlte_lang::message.date') }}</th>
                            <th>{{ trans('adminlte_lang::message.manager') }}</th>
                            <th>{{ trans('adminlte_lang::message.type') }}</th>
                            <th>{{ trans('adminlte_lang::message.description') }}</th>
                            <th>{{ trans('adminlte_lang::message.tags') }}</th>
                            @if(auth()->user()->can('update', $client))
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($actions as $item)
                        <tr>
                            <td>
                                @if(auth()->user()->can('update', $item))
                                    <a href="/actions/{{ $item->id }}/edit?back_to_url={{ \Request::path() }}&hash={{ $tab }}">{{ $item->id }}</a>
                                @else
                                    {{ $item->id }}
                                @endif
                            </td>
                            <td style="font-size: 150%" align="center">
                                @include('actions.flag', ['flag' => $item->flag()])
                            </td>
                            <td>{{ $item->action_date->format('d.m.Y') }}</td>
                            <td>{{ $item->manager->name }}</td>
                            <td>{{ $item->type->name }}</td>
                            <td>
                                @if(auth()->user()->can('update', $item))
                                    <a href="/actions/{{ $item->id }}/edit?back_to_url={{ \Request::path() }}&hash={{ $tab }}">{{ $item->description }}</a>
                                @else
                                    {{ $item->description }}
                                @endif
                            </td>
                            <td>{{ $item->tags }}</td>
                            @if(auth()->user()->can('update', $client))
                                <td>
                                    @if(auth()->user()->can('update', $item))
                                        {!! Form::open([
                                            'method'=>'DELETE',
                                            'url' => ['/actions', $item->id],
                                            'style' => 'display:inline'
                                        ]) !!}
                                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger btn-xs',
                                                    'title' => 'Delete Action',
                                                    'onclick'=>'return confirm("Подтвердить удаление?")'
                                            )) !!}
                                            {!! Form::hidden('back_to_url', \Request::path()) !!}
                                            {!! Form::hidden('hash', $tab) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p style="margin-top: 0.5em">{{ trans('adminlte_lang::message.actionscount') }}: {{ count($actions) }}.</p>
            </div>
        </div>
    </div>
</div>
