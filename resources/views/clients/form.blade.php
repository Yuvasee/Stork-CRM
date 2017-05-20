<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', trans('adminlte_lang::message.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('client_type_id') ? 'has-error' : ''}}">
    {!! Form::label('client_type_id', trans('adminlte_lang::message.clienttype')) !!}
    {!! Form::select('client_type_id', $clientTypes, null, ['class' => 'form-control']) !!}
    {!! $errors->first('client_type_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('client_status_id') ? 'has-error' : ''}}">
    {!! Form::label('client_status_id', trans('adminlte_lang::message.status')) !!}
    {!! Form::select('client_status_id', $clientStatuses, null, ['class' => 'form-control']) !!}
    {!! $errors->first('client_status_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('client_source_id') ? 'has-error' : ''}}">
    {!! Form::label('client_source_id', trans('adminlte_lang::message.source')) !!}
    {!! Form::select('client_source_id', $clientSources, null, ['class' => 'form-control']) !!}
    {!! $errors->first('client_source_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('product_groups') ? 'has-error' : ''}}">
    {!! Form::label('product_groups', trans('adminlte_lang::message.productgroups')) !!}
    <div class="checkbox" style="margin-top: 0">
        @foreach ($productGroups as $productGroup)
                <label class="checkbox-inline">
                    {!! Form::checkbox('product_groups[]', $productGroup['id'], in_array($productGroup['id'], $attachedPGs)); !!}
                    {{ $productGroup['name'] }}
                </label>
        @endforeach
    </div>
</div>
<div class="form-group {{ $errors->has('manager_user_id') ? 'has-error' : ''}}">
    {!! Form::label('manager_user_id', trans('adminlte_lang::message.manager')) !!}
    {!! Form::select('manager_user_id', $users, isset($client) ? null : \Auth::user()->id, ['class' => 'form-control']) !!}
    {!! $errors->first('manager_user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
    {!! Form::label('phone_number', trans('adminlte_lang::message.phonenumber')) !!}
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-phone"></i>
        </div>
        {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
    </div>
    {!! $errors->first('phone_number', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', trans('adminlte_lang::message.email')) !!}
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-at"></i>
        </div>
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    {!! Form::label('address',trans('adminlte_lang::message.address')) !!}
    {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => '3']) !!}
    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('post_address') ? 'has-error' : ''}}">
    {!! Form::label('post_address', trans('adminlte_lang::message.postaddress')) !!}
    {!! Form::textarea('post_address', null, ['class' => 'form-control', 'rows' => '3']) !!}
    {!! $errors->first('post_address', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
    {!! Form::label('city', trans('adminlte_lang::message.city')) !!}
    {!! Form::text('city', null, ['class' => 'form-control']) !!}
    {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('region') ? 'has-error' : ''}}">
    {!! Form::label('region', trans('adminlte_lang::message.region')) !!}
    {!! Form::text('region', null, ['class' => 'form-control']) !!}
    {!! $errors->first('region', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('region_code') ? 'has-error' : ''}}">
    {!! Form::label('region_code', trans('adminlte_lang::message.regioncodes')) !!}
    {!! Form::text('region_code', null, ['class' => 'form-control']) !!}
    {!! $errors->first('region_code', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('tags') ? 'has-error' : ''}}">
    {!! Form::label('tags', trans('adminlte_lang::message.tags')) !!}
    {!! Form::text('tags', null, ['class' => 'form-control']) !!}
    {!! $errors->first('tags', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('website') ? 'has-error' : ''}}">
    {!! Form::label('website', trans('adminlte_lang::message.website')) !!}
    {!! Form::text('website', null, ['class' => 'form-control']) !!}
    {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('additional_info') ? 'has-error' : ''}}">
    {!! Form::label('additional_info', trans('adminlte_lang::message.additionalinfo')) !!}
    {!! Form::textarea('additional_info', null, ['class' => 'form-control', 'rows' => '5']) !!}
    {!! $errors->first('additional_info', '<p class="help-block">:message</p>') !!}
</div>
{!! Form::hidden('created_by_user_id', \Auth::user()->id, ['class' => 'form-control']) !!}

<div class="form-group">
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('adminlte_lang::message.create'), ['class' => 'btn btn-success']) !!}
</div>
