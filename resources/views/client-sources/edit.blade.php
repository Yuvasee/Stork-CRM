@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.clientsources') }} - {{ $clientsource->name }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.clientsources') }} <small>{{ $clientsource->name }}</small>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-body">
                    <a href="{{ url('/client-sources') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ trans('adminlte_lang::message.back') }}</button></a>
                    <br />
                    <br />

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::model($clientsource, [
                        'method' => 'PATCH',
                        'url' => ['/client-sources', $clientsource->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('client-sources.form', ['submitButtonText' => trans('adminlte_lang::message.update')])

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
