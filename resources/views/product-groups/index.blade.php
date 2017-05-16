@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.productgroups') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.productgroups') }}
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('product-groups.index') !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <a href="{{ url('/product-groups/create') }}" class="btn btn-success btn-sm" title="Add New ProductGroup">
                        <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('adminlte_lang::message.add') }}
                    </a>

                    {!! Form::open(['method' => 'GET', 'url' => '/product-groups', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                                <th>{{ trans('adminlte_lang::message.sort_id') }}</th>
                                <th>{{ trans('adminlte_lang::message.color') }}</th>
                                <th>{{ trans('adminlte_lang::message.description') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($productgroups as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><a href="{{ url('/product-groups/' . $item->id . '/edit') }}" title="Edit ProductGroup">{{ $item->name }}</a></td>
                                <td>{{ $item->sorting_num }}</td>
                                <td><span style="color: {{ $item->color }}">{{ $item->color }}</span></td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    {!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => ['/product-groups', $item->id],
                                        'style' => 'display:inline'
                                    ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-xs',
                                                'title' => 'Delete ProductGroup',
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
        tbl.order([2, 'asc']).draw();
      });
    </script>
@endsection