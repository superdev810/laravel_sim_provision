{!! Form::open(array('route' => 'sim-upload-contact','class'=>'form-horizontal','id'=>'qq-form')) !!}

{{ Form::bsText('agent', empty($userData->fullname) ? null : $userData->fullname, [
    'class'                         =>'form-control',
    "required"                      => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Agent  name is required'
    ] ,'Enter agent name') }}


{{ Form::bsText('group', empty($userData->fullname) ? null : $userData->fullname, [
    'class'                         =>'form-control',
    "required"                      => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Group  name is required'
    ] ,'Enter Group name') }}


{{ Form::bsPassword('password', null, [
    'class'=>'form-control',
    'id'=>'new_password',
    "required" => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'New password  is required'
    ] ,'Enter password') }}

<div class="form-group">
    <label for="domain_id" class="col-md-4 control-label">Select the contact file</label>
    <div class="col-md-6">
        <div id="fine-uploader-gallery"></div>
    </div>
</div>


<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::submit('Submit',array('class'=>'btn btn-primary submit-file'))!!}
    </div>
</div>

{!! Form::close() !!}





