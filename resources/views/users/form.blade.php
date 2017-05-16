<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Имя') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('pw') ? 'has-error' : ''}}">
    @if (strpos(Request::url(), 'edit') !== false)
        {!! Form::label('pw', 'Новый пароль') !!}
        {!! Form::text('pw', null, ['class' => 'form-control']) !!}
    @else
        {!! Form::label('pw', 'Пароль') !!}
        {!! Form::text('pw', null, ['class' => 'form-control', 'required' => 'required']) !!}
    @endif
    {!! $errors->first('pw', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('client_status_id') ? 'has-error' : ''}}">
    {!! Form::label('user_role_id', 'Роль') !!}
    @if (strpos(Request::url(), 'edit') !== false)
        {!! Form::select('user_role_id', $roles, null, ['class' => 'form-control']) !!}
    @else
        {!! Form::select('user_role_id', $roles, 2, ['class' => 'form-control']) !!}
    @endif
    {!! $errors->first('user_role_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
    {!! Form::label('phone_number', 'Номер телефона') !!}
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-phone"></i>
        </div>
        <input class="form-control" name="phone_number" type="text" id="phone_number" value="{{ $user->phone_number }}">
    </div>
    {!! $errors->first('phone_number', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('birthday') ? 'has-error' : ''}}">
    {!! Form::label('birthday', 'День рождения') !!}
    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" datepicker class="form-control" name="birthday" value="{{ $user->birthday }}">
    </div>
    {!! $errors->first('birthday', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('hired_date') ? 'has-error' : ''}}">
    {!! Form::label('hired_date', 'Дата начала работы') !!}
    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" datepicker class="form-control" name="hired_date" value="{{ $user->hired_date }}">
    </div>
    {!! $errors->first('hired_date', '<p class="help-block">:message</p>') !!}
</div>
@if (strpos(Request::url(), 'edit') !== false)
    <div class="form-group {{ $errors->has('fired_date') ? 'has-error' : ''}}">
        {!! Form::label('fired_date', 'Дата увольнения') !!}
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" datepicker class="form-control" name="fired_date" value="{{ $user->fired_date }}">
        </div>
        {!! $errors->first('fired_date', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group {{ $errors->has('about') ? 'has-error' : ''}}">
        {!! Form::label('about', 'Дополнительная информация') !!}
        {!! Form::textarea('about', null, ['class' => 'form-control', 'rows' => '4']) !!}
        {!! $errors->first('about', '<p class="help-block">:message</p>') !!}
    </div>
@endif

<div class="form-group">
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('adminlte_lang::message.create'), ['class' => 'btn btn-primary']) !!}
</div>

@section('scripts')
    @parent
    <script>
        $(function () {
            $("[datepicker]").datepicker({
                autoclose: true,
                format: 'dd.mm.yyyy'
            });
    });
    </script>
@endsection