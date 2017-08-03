@push('styles')
<link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

@endpush

@extends('layouts.main')

@section('pagebar')
    @include('layouts.pagebar',['title' => 'Add Sim Information'])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">User Sim Information</span>
                    </div>
                </div>
                <div class="portlet-body util-btn-margin-bottom-5">
                    <div class="table-toolbar">

                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="response"></div>

                            {!! Form::open(array('class'=>'form-horizontal','id'=>'group-from')) !!}

                            {{ Form::bsSelect('MSISDNnetwork', ['MTN', 'Vodacom', 'CellC', 'Telkom', 'Virgin'], [
                                'class'                         =>'form-control',
                                "required"                      => "required",
                                'data-parsley-trigger'          => 'change focusout',
                                'data-parsley-required-message' => 'Network  is required'
                                ] ,'Enter network name') ,null}}


                            {{ Form::bsText('last4SIM', null, [
                                'class'                         =>'form-control',
                                "required"                      => "required",
                                'data-parsley-trigger'          => 'change focusout',
                                'data-parsley-required-message' => 'Last 4 digit of sim number  is required'
                                ] ,'Enter last 4 digit of sim number') }}

                            {{ Form::bsText('referenceNumber', null, [
                                'class'                         =>'form-control',
                                "required"                      => "required",
                                'data-parsley-trigger'          => 'change focusout',
                                'data-parsley-required-message' => 'ReferenceNumber  is required'
                                ] ,'Enter ReferenceNumber') }}


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {!! Form::submit('Submit',array('class'=>'btn btn-primary'))!!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')

<script>

    $(function () {

        (function (global) {


            /* repeatString() returns a string which has been repeated a set number of times */
            function repeatString(str, num) {
                out = '';
                for (var i = 0; i < num; i++) {
                    out += str;
                }
                return out;
            }

            /*
             dump() displays the contents of a variable like var_dump() does in PHP. dump() is
             better than typeof, because it can distinguish between array, null and object.
             Parameters:
             v:              The variable
             howDisplay:     "none", "body", "alert" (default)
             recursionLevel: Number of times the function has recursed when entering nested
             objects or arrays. Each level of recursion adds extra space to the
             output to indicate level. Set to 0 by default.
             Return Value:
             A string of the variable's contents
             Limitations:
             Can't pass an undefined variable to dump().
             dump() can't distinguish between int and float.
             dump() can't tell the original variable type of a member variable of an object.
             These limitations can't be fixed because these are *features* of JS. However, dump()
             */
            function dump(v, howDisplay, recursionLevel) {
                howDisplay = (typeof howDisplay === 'undefined') ? "alert" : howDisplay;
                recursionLevel = (typeof recursionLevel !== 'number') ? 0 : recursionLevel;


                var vType = typeof v;
                var out = vType;

                switch (vType) {
                    case "number":
                    /* there is absolutely no way in JS to distinguish 2 from 2.0
                     so 'number' is the best that you can do. The following doesn't work:
                     var er = /^[0-9]+$/;
                     if (!isNaN(v) && v % 1 === 0 && er.test(3.0))
                     out = 'int';*/
                    case "boolean":
                        out += ": " + v;
                        break;
                    case "string":
                        out += "(" + v.length + '): "' + v + '"';
                        break;
                    case "object":
                        //check if null
                        if (v === null) {
                            out = "null";

                        }
                        //If using jQuery: if ($.isArray(v))
                        //If using IE: if (isArray(v))
                        //this should work for all browsers according to the ECMAScript standard:
                        else if (Object.prototype.toString.call(v) === '[object Array]') {
                            out = 'array(' + v.length + '): {\n';
                            for (var i = 0; i < v.length; i++) {
                                out += repeatString('   ', recursionLevel) + "   [" + i + "]:  " +
                                        dump(v[i], "none", recursionLevel + 1) + "\n";
                            }
                            out += repeatString('   ', recursionLevel) + "}";
                        }
                        else { //if object
                            sContents = "{\n";
                            cnt = 0;
                            for (var member in v) {
                                //No way to know the original data type of member, since JS
                                //always converts it to a string and no other way to parse objects.
                                sContents += repeatString('   ', recursionLevel) + "   " + member +
                                        ":  " + dump(v[member], "none", recursionLevel + 1) + "\n";
                                cnt++;
                            }
                            sContents += repeatString('   ', recursionLevel) + "}";
                            out += "(" + cnt + "): " + sContents;
                        }
                        break;
                }

                if (howDisplay == 'body') {
                    var pre = document.createElement('pre');
                    pre.innerHTML = out;
                    document.getElementById('response').appendChild(pre)
                }
                else if (howDisplay == 'alert') {
                    alert(out);
                }

                return out;
            }



            $('#group-from')
                    .parsley(global.parsleySettings.settings)
                    .on('form:success', function (formInstance) {
                        if (formInstance.isValid()) {
                            global.mySiteAjax({
                                url: '{!! route('registration-submit') !!}',
                                type: 'post',
                                data: $('#group-from').serialize(),
                                loadSpinner: true,
                                success: function (response) {
                                    if (response.status == 'validation-error')
                                        global.generateErrorMessage(formInstance, response.html);
                                    else if (response.status == 'success') {
                                        dump(response.html.registerMSISDNReturn,'body');
                                    }
                                }
                            });
                        }
                    }).on('form:submit', function () {
                        return false;
                    });

        })(window);
    });
</script>

@endpush
@push('scripts-middle')

@endpush



