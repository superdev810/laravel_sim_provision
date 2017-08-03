{!! Form::open(array('class'=>'form-horizontal','id'=>'user-from')) !!}

{{ Form::bsText('full_name', empty($userData->full_name) ? null : $userData->full_name, [
    'class'                         =>'form-control',
    "required"                      => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Full name is required'
    ] ,'Enter Full name') }}
<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::submit('Submit',array('class'=>'btn btn-primary'))!!}
    </div>
</div>
{!! Form::close() !!}