@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.action') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.action') }}
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('actions.edit', $action) !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ $back_to_url }}" title="{{ trans('adminlte_lang::message.back') }}"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ trans('adminlte_lang::message.back') }}</button></a>
                        </div>
                        <div class="col-sm-6" style="text-align: right;">
                            {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['/actions', $action->id],
                                'style' => 'display:inline'
                            ]) !!}
                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger btn-xs',
                                        'title' => 'Delete Action',
                                        'onclick'=>'return confirm("Подтвердить удаление?")'
                                )) !!}
                            {!! Form::close() !!}                    
                        </div>
                    </div>

                    <br />

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::model($action, [
                        'method' => 'PATCH',
                        'url' => ['/actions', $action->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('actions.form', ['submitButtonText' => trans('adminlte_lang::message.update')])

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
