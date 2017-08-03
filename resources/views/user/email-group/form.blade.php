{!! Form::open(array('class'=>'form-horizontal slimScrollDiv','id'=>'group-from')) !!}


{{ Form::bsText('name', empty($groupData->name) ? null : $groupData->name, [
    'class'                         =>'form-control',
    "required"                      => "required",
    'data-parsley-trigger'          => 'change focusout',
    'data-parsley-required-message' => 'Name  is required'
    ] ,'Enter Group name') }}

<div class="form-group">
    {!! Form::label("email-label", "Select Emails", array('class' => 'col-md-4 control-label')) !!}
    <div class="col-md-6">
        @foreach($emailList as $email)
            <div class="row">
                <div class="col-md-1">
                    {!!  Form::checkbox('emails[]', $email->id ,null,[
                    "required"                      => "required",
                    'data-parsley-errors-container' => '#email-error',
                    'data-parsley-required-message' => 'Email is required',
                    ])
                 !!}
                </div>
                <div class="col-md-6"> {{$email->email}} </div>
            </div>
        @endforeach
            <div id="email-error"></div>

    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::submit('Submit',array('class'=>'btn btn-primary'))!!}
    </div>
</div>
{!! Form::close() !!}