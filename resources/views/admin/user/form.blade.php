{!! Form::open(array('class'=>'form-horizontal','id'=>'user-from')) !!}

{{ Form::bsText('full_name', empty($userData->fullname) ? null : $userData->fullname, [
    'class'                         =>'form-control',
    "required"                      => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Full name is required'
    ] ,'Enter Full name') }}

{{ Form::bsText('email', empty($userData->email) ? null : $userData->email, [
    'class'                         =>'form-control',
    "required"                      => "required",
    "data-parsley-type"             => "email",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Email is required'
    ] ,'Enter email address') }}


{{ Form::bsPassword('password', null, [
    'class'=>'form-control',
    'id'=>'new_password',
    "required" => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'New password  is required'
    ] ,'Enter password') }}

{{ Form::bsPassword('new_confirm', null, [
    'class'=>'form-control',
    "required" => "required",
    "data-equalto"=>"#new_password",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Confirm new  is required'
    ] ,'Confirm password') }}


<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::submit('Submit',array('class'=>'btn btn-primary'))!!}
    </div>
</div>
{!! Form::close() !!}