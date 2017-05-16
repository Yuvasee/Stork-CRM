@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.userroles') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.userroles') }}
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('user-roles.index') !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <a href="{{ url('/user-roles/create') }}" class="btn btn-success btn-sm" title="Add New UserRole">
                        <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('adminlte_lang::message.add') }}
                    </a>

                    {!! Form::open(['method' => 'GET', 'url' => '/user-roles', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="{{ trans('adminlte_lang::message.search') }}...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    {!! Form::close() !!}

                    <br/>
                    <br/>
                    <table id="data-tbl" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>{{ trans('adminlte_lang::message.id') }}</th>
                                <th>{{ trans('adminlte_lang::message.name') }}</th>
                                <th>{{ trans('adminlte_lang::message.description') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($userroles as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><a href="{{ url('/user-roles/' . $item->id . '/edit') }}" title="Edit UserRoles">{{ $item->name }}</a></td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    {!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => ['/user-roles', $item->id],
                                        'style' => 'display:inline'
                                    ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-xs',
                                                'title' => 'Delete UserRole',
                                                'onclick'=>'return confirm("' . trans('adminlte_lang::message.confirmdelete') . '?")'
                                        )) !!}
                                    {!! Form::close() !!}
                                </td>
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
      });
    </script>
@endsection