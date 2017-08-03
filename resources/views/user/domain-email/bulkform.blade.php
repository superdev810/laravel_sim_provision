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

<div class="form-group">
    <label for="domain_id" class="col-md-4 control-label"></label>
    <div class="col-md-6">
        <div id="fine-uploader-gallery"></div>
    </div>
</div>

{{--<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::submit('Submit',array('class'=>'btn btn-primary'))!!}
    </div>
</div>--}}
{!! Form::close() !!}





