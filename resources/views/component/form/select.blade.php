<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(!empty($label))
        {!! Form::label($name, $label, array('class' => 'col-md-4 control-label')) !!}
    @endif
    <div class="col-md-6">
        {!!  Form::select($name, $value, $selected, $attributes)!!}
        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>