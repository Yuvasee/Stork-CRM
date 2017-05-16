<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Название', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('sorting_num') ? 'has-error' : ''}}">
    {!! Form::label('sorting_num', 'Сортировка', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        {!! Form::number('sorting_num', null, ['class' => 'form-control']) !!}
        {!! $errors->first('sorting_num', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('color') ? 'has-error' : ''}}">
    {!! Form::label('color', 'Цвет', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        {!! Form::text('color', null, ['class' => 'form-control']) !!}
        {!! $errors->first('color', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Описание', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-9">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('adminlte_lang::message.create'), ['class' => 'btn btn-primary']) !!}
    </div>
</div>
