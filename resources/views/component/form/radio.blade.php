<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {!! Form::label($name, $label, array('class' => 'col-md-4 control-label')) !!}
    <div class="col-md-6">
        @foreach($value as $key => $each)
            <label class="col-md-4 radio rd-primary">
                {!! Form::radio($name, $key,($selected == $key) ? true : false)!!}
                <span class="label">{{$each}}</span>
            </label>
        @endforeach

        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>
