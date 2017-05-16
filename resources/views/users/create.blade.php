@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.users') }} - {{ trans('adminlte_lang::message.creation') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.users') }} <small>{{ trans('adminlte_lang::message.creation') }}</small>
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('users.create', $user) !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-body">
                    <a href="{{ url('/users') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ trans('adminlte_lang::message.back') }}</button></a>
                    <br />
                    <br />

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::open(['url' => '/users', 'files' => true]) !!}

                    @include ('users.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

