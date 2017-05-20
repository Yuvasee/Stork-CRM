@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.clients') }} - {{ $client->name }}
@endsection

@section('contentheader_title')
    {{ $client->name }}
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('clients.show', $client) !!}
@endsection

@section('main-content')
<div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#info-tab" aria-controls="info-tab" role="tab" data-toggle="tab">{{ trans('adminlte_lang::message.information') }}</a></li>
        <li role="presentation"><a href="#past-tab" aria-controls="past-tab" role="tab" data-toggle="tab">{{ trans('adminlte_lang::message.actionscompleted') }}</a></li>
        <li role="presentation"><a href="#future-tab" aria-controls="future-tab" role="tab" data-toggle="tab">{{ trans('adminlte_lang::message.actionscompleted') }}</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        <!-- Информация -->
        <div role="tabpanel" class="tab-pane active" id="info-tab">
            <div class="row">
                <div class="col-lg-6">
                    <div class="box box-primary">
                        <form class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.name') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->name }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.type') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->type->name }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.status') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->status->name }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.source') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->source->name }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.productgroups') }}</label>
                                <p class="col-lg-9 form-control-static">
                                    @foreach ($productGroups as $productGroup)
                                        @if(!$loop->last)
                                            {{ $productGroup['name'] . ', '}}
                                        @else
                                            {{ $productGroup['name']}}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.manager') }}</label>
                                <p class="col-lg-9 form-control-static"><i class="fa fa-user"></i> {{ $client->manager->name }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.phonenumber') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->phone_number }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.email') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->email }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.address') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->address }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.postaddress') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->post_address }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.city') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->city }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.region') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->region }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.regioncodes') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->region_code }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.tags') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->tags }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.website') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->website }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.additionalinfo') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->additional_info }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.creationdate') }}</label>
                                <p class="col-lg-9 form-control-static">{{ $client->created_at->format('d.m.Y') }}</p>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.creator') }}</label>
                                <p class="col-lg-9 form-control-static"><i class="fa fa-user"></i> {{ $client->createdBy->name }}</p>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    @foreach($contactPersons as $contactPerson)
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-user"></i> {{ $contactPerson['contact_name' . $contactPerson['id']] }}</h3>
                            </div>
                            <form class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.phonework') }}</label>
                                    <p class="col-lg-9 form-control-static">{{ $contactPerson['phone_work'] }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.phonemob') }}</label>
                                    <p class="col-lg-9 form-control-static">{{ $contactPerson['phone_mobile'] }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.email') }}</label>
                                    <p class="col-lg-9 form-control-static">{{ $contactPerson['email'] }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{{ trans('adminlte_lang::message.notes') }}</label>
                                    <p class="col-lg-9 form-control-static">{{ $contactPerson['notes'] }}</p>
                                </div>
                            </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Прошедшие события -->
        <div role="tabpanel" class="tab-pane" id="past-tab">
             @include ('clients.actions', ['actions' => $actionsPast, 'tab' => 'past-tab', 'status' => '1'])
        </div>
        
        <!-- Планируемые события -->
        <div role="tabpanel" class="tab-pane" id="future-tab">
             @include ('clients.actions', ['actions' => $actionsFuture, 'tab' => 'future-tab', 'status' => '0'])
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