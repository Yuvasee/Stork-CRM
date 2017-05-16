@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.clientstatuses') }} - {{ $clientstatus->name }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.clientstatuses') }} <small>{{ $clientstatus->name }}</small>
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('client-statuses.edit', $clienttype) !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-body">
                    <a href="{{ url('/client-statuses') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ trans('adminlte_lang::message.back') }}</button></a>
                    <br />
                    <br />

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::model($clientstatus, [
                        'method' => 'PATCH',
                        'url' => ['/client-statuses', $clientstatus->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('client-statuses.form', ['submitButtonText' => trans('adminlte_lang::message.update')])

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
