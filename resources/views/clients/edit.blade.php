@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.clients') }} - {{ $client->name }}
@endsection

@section('contentheader_title')
    {{ $client->name }}
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('clients.edit', $client) !!}
@endsection

@section('main-content')
<div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#info-tab" aria-controls="info-tab" role="tab" data-toggle="tab">Информация</a></li>
        <li role="presentation"><a href="#past-tab" aria-controls="past-tab" role="tab" data-toggle="tab">Прошедшие события</a></li>
        <li role="presentation"><a href="#future-tab" aria-controls="future-tab" role="tab" data-toggle="tab">Планируемые события</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        <!-- Информация -->
        <div role="tabpanel" class="tab-pane active" id="info-tab">
            <div class="row">
                <div class="col-lg-6">
                    <div class="box box-primary">
                        <div class="box-body">

                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            {!! Form::model($client, [
                                'method' => 'PATCH',
                                'url' => ['/clients', $client->id],
                                'files' => true
                            ]) !!}

                            @include ('clients.form', ['submitButtonText' => trans('adminlte_lang::message.update')])

                            {!! Form::close() !!}

                            <div class="row">
                                <div class="col-md-6">
                            <p><b>{{ trans('adminlte_lang::message.creationdate') }}:</b> {{ $client->created_at->format('d.m.Y') }}<br/>
                            <b>{{ trans('adminlte_lang::message.creator') }}:</b> {{ $client->createdBy->name }}</p>
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    {!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => ['/clients', $client->id],
                                        'style' => 'display:inline'
                                    ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-xs',
                                                'title' => 'Delete Action',
                                                'onclick'=>'return confirm("' . trans('adminlte_lang::message.confirmdelete') . '?")'
                                        )) !!}
                                    {!! Form::close() !!}                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    @foreach($contactPersons as $contactPerson)
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-user"></i> {{ $contactPerson['contact_name' . $contactPerson['id']] }}</h3>
                            </div>
                            <div class="box-body">
                                {!! Form::model($contactPerson, [
                                    'method' => 'PATCH',
                                    'url' => ['/contact-persons', $contactPerson['id']],
                                ]) !!}

                                <div class="form-group {{ $errors->has('contact_name' . $contactPerson['id']) ? 'has-error' : ''}}">
                                    {!! Form::label('contact_name' . $contactPerson['id'], trans('adminlte_lang::message.contactname')) !!}
                                    {!! Form::text('contact_name' . $contactPerson['id'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    {!! $errors->first('contact_name' . $contactPerson['id'], '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="form-group {{ $errors->has('phone_work' . $contactPerson['id']) ? 'has-error' : ''}}">
                                    {!! Form::label('phone_work' . $contactPerson['id'], trans('adminlte_lang::message.phonework')) !!}
                                    {!! Form::text('phone_work' . $contactPerson['id'], null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('phone_work' . $contactPerson['id'], '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="form-group {{ $errors->has('phone_mobile' . $contactPerson['id']) ? 'has-error' : ''}}">
                                    {!! Form::label('phone_mobile' . $contactPerson['id'], trans('adminlte_lang::message.phonemob')) !!}
                                    {!! Form::text('phone_mobile' . $contactPerson['id'], null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('phone_mobile' . $contactPerson['id'], '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="form-group {{ $errors->has('contact_email' . $contactPerson['id']) ? 'has-error' : ''}}">
                                    {!! Form::label('contact_email' . $contactPerson['id'], trans('adminlte_lang::message.email')) !!}
                                    {!! Form::text('contact_email' . $contactPerson['id'], null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_email' . $contactPerson['id'], '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="form-group {{ $errors->has('notes' . $contactPerson['id']) ? 'has-error' : ''}}">
                                    {!! Form::label('notes' . $contactPerson['id'], trans('adminlte_lang::message.notes')) !!}
                                    {!! Form::textarea('notes' . $contactPerson['id'], null, ['class' => 'form-control', 'rows' => '2']) !!}
                                    {!! $errors->first('notes' . $contactPerson['id'], '<p class="help-block">:message</p>') !!}
                                </div>
                                {!! Form::hidden('client_id' . $contactPerson['id'], $client->id) !!}
                                <div class="form-group">
                                    {!! Form::button('<i class="fa fa-save" aria-hidden="true"></i> ' . trans('adminlte_lang::message.save'), [
                                            'type' => 'submit',
                                            'class' => 'btn btn-success btn-xs',
                                            'title' => trans('adminlte_lang::message.save'),
                                        ]) !!}
                                    <a href="{{ url('/contact-persons/' . $contactPerson['id'] . '/delete?client_id=' . $client->id) }}" title="{{ trans('adminlte_lang::message.delete') }}" onclick="return confirm('{{ trans('adminlte_lang::message.confirmdelete') }}?')"><button class="btn btn-danger btn-xs" type="button"><i class="fa fa-trash-o"></i> {{ trans('adminlte_lang::message.delete') }}</button></a>
                                </div>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endforeach

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-user"></i> Новое контактное лицо</h3>
                        </div>
                        <div class="box-body">
                            {!! Form::open(['url' => '/clients/' . $client->id . '/new-contact']) !!}

                                <div class="form-group {{ $errors->has('contact_name_new') ? 'has-error' : ''}}">
                                    {!! Form::label('contact_name_new', trans('adminlte_lang::message.contactname')) !!}
                                    {!! Form::text('contact_name_new', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    {!! $errors->first('contact_name_new', '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="form-group {{ $errors->has('phone_work_new') ? 'has-error' : ''}}">
                                    {!! Form::label('phone_work_new', trans('adminlte_lang::message.phonework')) !!}
                                    {!! Form::text('phone_work_new', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('phone_work_new', '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="form-group {{ $errors->has('phone_mobile_new') ? 'has-error' : ''}}">
                                    {!! Form::label('phone_mobile_new', trans('adminlte_lang::message.phonemob')) !!}
                                    {!! Form::text('phone_mobile_new', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('phone_mobile_new', '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="form-group {{ $errors->has('contact_email_new') ? 'has-error' : ''}}">
                                    {!! Form::label('contact_email_new', trans('adminlte_lang::message.email')) !!}
                                    {!! Form::text('contact_email_new', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('contact_email_new', '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="form-group {{ $errors->has('notes_new') ? 'has-error' : ''}}">
                                    {!! Form::label('notes_new', trans('adminlte_lang::message.notes')) !!}
                                    {!! Form::textarea('notes_new', null, ['class' => 'form-control', 'rows' => '2']) !!}
                                    {!! $errors->first('notes_new', '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::button('<i class="fa fa-save" aria-hidden="true"></i> ' . trans('adminlte_lang::message.save'), [
                                            'type' => 'submit',
                                            'class' => 'btn btn-success btn-xs',
                                            'title' => trans('adminlte_lang::message.save'),
                                        ]) !!}
                                </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Прошедшие события -->
        <div role="tabpanel" class="tab-pane" id="past-tab">
             @include ('clients._actions', ['actions' => $actionsPast, 'tab' => 'past-tab', 'status' => '1'])
        </div>
        
        <!-- Планируемые события -->
        <div role="tabpanel" class="tab-pane" id="future-tab">
             @include ('clients._actions', ['actions' => $actionsFuture, 'tab' => 'future-tab', 'status' => '0'])
        </div>

    </div>

</div>
@endsection

@section('scripts')
    @parent
    <script>
        // Javascript to enable link to tab
        var url = document.location.toString();
        if (url.match('#')) {
            $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
        } //add a suffix

        // Change hash for page-reload
        $('.nav-tabs a').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
            window.scrollTo(0, 0);
        })
    </script>
@endsection