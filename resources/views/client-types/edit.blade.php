@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.clienttypes') }} - {{ $clienttype->name }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.clienttypes') }} <small>{{ $clienttype->name }}</small>
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('client-types.edit', $clienttype) !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-body">
                    <a href="{{ url('/client-types') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ trans('adminlte_lang::message.back') }}</button></a>
                    <br />
                    <br />

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::model($clienttype, [
                        'method' => 'PATCH',
                        'url' => ['/client-types', $clienttype->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('client-types.form', ['submitButtonText' => trans('adminlte_lang::message.update')])

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
