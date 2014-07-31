<div class="form-group {{ $errors->has($field['name']) ? 'has-error' : '' }}">
    {{ Form::label($field['name'], '') }}
    {{ Form::text($field['name'], null, ['class' => 'form-control']) }}
    {{ $errors->first($field['name'], '<span class="help-block">:message</span>') }}
</div>