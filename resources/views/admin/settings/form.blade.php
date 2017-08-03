{!! Form::open(array('class'=>'form-horizontal','id'=>'settings-from')) !!}



{{ Form::bsText('default_domain_per_user', empty($settingData->default_domain_per_user) ? null : $settingData->default_domain_per_user, [
    'class'                         =>'form-control',
    "required"                      => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Default domain per user required'
    ] ,'Enter Default domain per user  ') }}


{{ Form::bsText('per_hour_limit', empty($settingData->per_hour_limit) ? null : $settingData->per_hour_limit, [
    'class'                         =>'form-control',
    "required"                      => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Per hour limit required'
    ] ,'Enter  Per hour lmit') }}


{{ Form::bsText('per_day_limit', empty($settingData->per_day_limit) ? null : $settingData->per_day_limit, [
    'class'                         =>'form-control',
    "required"                      => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Per day limit required'
    ] ,'Enter per day limit') }}



<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::submit('Submit',array('class'=>'btn btn-primary'))!!}
    </div>
</div>
{!! Form::close() !!}