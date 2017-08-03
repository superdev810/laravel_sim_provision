{!! Form::open(array('class'=>'form-horizontal','id'=>'group-from')) !!}

{{ Form::bsSelect('domain_id', $domainList, [
    'class'                         =>'form-control',
    "required"                      => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Group  is required'
    ] ,'Select Domain name') ,empty($groupData->group_id) ? null : $groupData->group_id}}



{{ Form::bsText('name', empty($groupData->name) ? null : $groupData->name, [
    'class'                         =>'form-control',
    "required"                      => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Name  is required'
    ] ,'Enter name') }}

{{ Form::bsText('email', empty($groupData->email) ? null : $groupData->email, [
    'class'                         =>'form-control',
    "required"                      => "required",
    "data-parsley-type"             => "email",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Email  is required'
    ] ,'Enter Email name') }}

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::submit('Submit',array('class'=>'btn btn-primary'))!!}
    </div>
</div>
{!! Form::close() !!}