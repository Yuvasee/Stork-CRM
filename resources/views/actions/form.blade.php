<div class="form-group">
    {!! Form::label('client_id', 'Клиент', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        <p class="form-control-static"><a href="http://stork-crm/clients/{!! $client->id !!}/edit">{!! $client->name !!}</a></p>
        {!! Form::hidden('client_id', $client->id) !!}
    </div>
</div><div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Статус', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        {!! Form::select('status', $actionStatuses, request()->status, ['class' => 'form-control']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('action_date') ? 'has-error' : ''}}">
    {!! Form::label('action_date', 'Дата', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" datepicker class="form-control" name="action_date" value="{{ isset($action) ? $action->action_date->format('d.m.Y') : '' }}">
        </div>
        {!! $errors->first('action_date', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('action_type_id') ? 'has-error' : ''}}">
    {!! Form::label('action_type_id', 'Тип события', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        {!! Form::select('action_type_id', $actionTypes, null, ['class' => 'form-control']) !!}
        {!! $errors->first('action_type_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('manager_user_id') ? 'has-error' : ''}}">
    {!! Form::label('manager_user_id', 'Менеджер', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        {!! Form::select('manager_user_id', $users, isset($action) ? null : \Auth::user()->id, ['class' => 'form-control']) !!}
        {!! $errors->first('manager_user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Описание', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tags') ? 'has-error' : ''}}">
    {!! Form::label('tags', 'Признак', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        {!! Form::text('tags', null, ['class' => 'form-control']) !!}
        {!! $errors->first('tags', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('client_status_id') ? 'has-error' : ''}}">
    {!! Form::label('client_status_id', 'Статус клиента', ['class' => 'col-lg-3 control-label']) !!}
    <div class="col-lg-9">
        {!! Form::select('client_status_id', $clientStatuses, $client->status->id, ['class' => 'form-control']) !!}
        {!! $errors->first('client_status_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@if (isset($action))
<div class="form-group">
  <div class="col-lg-offset-3 col-lg-9">
    <div class="checkbox">
      <label>
        <input type="checkbox" name="add_new_action" id="add_new_action" value="1"> Добавить новое планируемое событие
      </label>
    </div>
  </div>
</div>
@endif

<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Создать', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@section('scripts')
    @parent
    <script>
        $("[datepicker]").datepicker({
            autoclose: true,
            format: 'dd.mm.yyyy',
            weekStart: 1,
        });
        
        if(! $("[datepicker]").val())
            $("[datepicker]").datepicker('update', new Date());

        $("#status").change(function() {
            if(this.value == 1) {
                $("#add_new_action").prop("checked", true);
            }
            else {
                $("#add_new_action").prop("checked", false);   
            }
        });
    </script>
@endsection