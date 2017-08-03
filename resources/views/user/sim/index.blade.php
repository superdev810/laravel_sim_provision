@push('styles')
<link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset('/assets/global/plugins/fine-uploader/jquery.fine-uploader/fine-uploader.min.css') }}">
<link href="{{ URL::asset('/assets/global/plugins/sweetalert/dist/sweetalert.css') }}" rel="stylesheet"/>
<style>
    #trigger-upload {
        background: #00ABC7;
        color: #FFFFFF;
        border-radius: 2px;
        border: 1px solid #37B7CC;
        box-shadow: 0 1px 1px rgba(255, 255, 255, 0.37) inset, 1px 0 1px rgba(255, 255, 255, 0.07) inset, 0 1px 0 rgba(0, 0, 0, 0.36), 0 -2px 12px rgba(0, 0, 0, 0.08) inset;
    }

    .qq-upload-button {
        margin-right: 15px;
        float: left;
    }

    #fine-uploader-manual-trigger .qq-upload-button {
        margin-right: 15px;
        float: left;
    }

    #fine-uploader-manual-trigger .buttons {
        width: 36%;
    }

    #fine-uploader-manual-trigger .qq-uploader .qq-total-progress-bar-container {
        width: 60%;
    }

    .qq-upload-button {
        display: block;
        width: 105px;
        padding: 7px 0;
        text-align: center;
        color: #FFF;
        background: #286090;
    }

    .qq-gallery .qq-upload-button {
        width: 124px !important;
        margin-right: 15px;
    }

    .qq-gallery.qq-uploader {

        min-height: 71px !important;
    }
</style>
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
                        <div class="row">
                            <div class="col-md-12">
                                <p style="color: red">Before Upload please check the sample file And you have to follow the cloumn order also file extension. </p>
                                <div class="btn-group">
                                    <button id="sample_editable_1_new" class="btn sbold green bluk-add"> Bulk Upload
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <a href="{{route('download-address','2')}}"  class="btn sbold green"> Download Sample file
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="domain-email-table">
                                <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Total Contact</th>
                                    <th>Status</th>
                                    <th>Agent</th>
                                    <th>Password</th>
                                    <th>Group</th>
                                    <th>Uploaded at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script src="{{ URL::asset('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/fine-uploader/jquery.fine-uploader/jquery.fine-uploader.js') }}"></script>
<script src="{{ URL::asset('/assets/global/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
<script type="text/template" id="qq-template-validation">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector qq-upload-button">
            <div>Select file</div>
        </div>
        <button type="button" id="trigger-upload" class="btn btn-primary">
            <i class="icon-upload icon-white"></i>Process Contact list
        </button>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
        <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
            <li>
                <div class="qq-progress-bar-container-selector">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                <span class="qq-upload-file-selector qq-upload-file"></span>
                <span class="qq-upload-size-selector qq-upload-size"></span>
                <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
                <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
                <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
            </li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Close</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">No</button>
                <button type="button" class="qq-ok-button-selector">Yes</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Cancel</button>
                <button type="button" class="qq-ok-button-selector">Ok</button>
            </div>
        </dialog>
    </div>
</script>

<script>

    $(function () {

        (function (global) {
            var dataTable = $('#domain-email-table').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                "pageLength": 50,
                ajax: '{!! route('sim-file-list') !!}',
                columns: [
                    {data: 'file_name', name: 'file_name', "orderable": true, "searchable":true,"width": "20%"},
                    {data: 'total_contact', name: 'total_contact', "orderable": false, "searchable":false,"width": "5%"},
                    {data: 'status', name: 'status', "orderable": true, "searchable":true,"width": "5%"},
                    {data: 'agent', name: 'agent', "orderable": true, "searchable":true,"width": "5%"},
                    {data: 'group', name: 'group', "orderable": true, "searchable":true,"width": "5%"},
                    {data: 'password', name: 'password', "orderable": true, "searchable":true,"width": "5%"},
                    {data: 'created_at', name: 'created_at', "orderable": false, "searchable":false,"width": "5%"},
                    {data: 'action', name: 'action', "orderable": false, "searchable":false,"width": "50%"},
                ],
                "createdRow": function ( row, data ) {
                    var statusObj = { status : 'invalid', class : 'label label-danger'};

                    if(data.status === 'pending') {
                        statusObj = { 'status' : 'pending', 'class' : 'label label-warning'}
                    } else if(data.status === 'processing') {
                        statusObj = { 'status' : 'processing', 'class' : 'label label-primary'}
                    } else if(data.status === 'failed') {
                        statusObj = { 'status' : 'failed', 'class' : 'label label-danger'}
                    } else if(data.status === 'success') {
                        statusObj = { 'status' : 'success', 'class' : 'label label-success'}
                    }

                    $('td', row).eq(2).html($('<span>').attr({
                        class: statusObj.class
                    }).html(statusObj.status));
                }
            });


            var bulkAddButton = $(".bluk-add");
            bulkAddButton.on('click', function () {

                global.waitingDialog.show('Please wait...', {dialogSize: 'sm', progressType: 'warning'});

                var detailPopUp = global.customPopup.show({
                    header: 'Add Sim file',
                    message: '',
                    dialogSize: 'lg'
                });

                detailPopUp.on('shown.bs.modal', function () {
                    var modal = $(this);

                    global.mySiteAjax({
                        url: '{!! route('sim-contact-form') !!}',
                        type: 'get',
                        loadSpinner: false,
                        success: function (response) {
                            window.nbUtility.ajaxErrorHandling(response, function () {
                                modal.find('.modal-body').html(response.html);
                                global.waitingDialog.hide();

                                $('#fine-uploader-gallery').fineUploader({
                                    template: 'qq-template-validation',
                                    request: {
                                        endpoint: '{!! route('sim-upload-contact') !!}'
                                    },
                                    thumbnails: {
                                        placeholders: {
                                            waitingPath: '/assets/global/img/waiting-generic.png',
                                            notAvailablePath: '/assets/global/img/not_available-generic.png'
                                        }
                                    },
                                    validation: {
                                        allowedExtensions: ['csv'],
                                        itemLimit : 1,
                                        sizeLimit : 772097152
                                    },
                                    callbacks: {
                                        onComplete: function(id, name,responseJSON) {
                                            if(responseJSON.success) {
                                                modal.modal('hide');
                                                dataTable.ajax.reload();
                                                toastr.success("File uploaded and processing list","Server Notification");
                                            }
                                        },
                                        onError: function(id, name, errorReason, xhrOrXdr) {
                                            toastr.error(qq.format("Error on file number {} - {}.  Reason: {}", id, name, errorReason));
                                        }
                                    },
                                    autoUpload: false,
                                });

                                $('#trigger-upload').click(function() {
                                    $('#qq-form')
                                            .parsley(global.parsleySettings.settings)
                                            .on('form:success', function (formInstance) {
                                                if (formInstance.isValid()) {
                                                    ///$('#fine-uploader-gallery').fineUploader('uploadStoredFiles');
                                                }
                                            }).on('form:submit', function () {
                                                return false;
                                            });
                                   // $('#fine-uploader-gallery').fineUploader('uploadStoredFiles');
                                    //$('.submit-file').click();
                                });



                            });
                        }
                    });
                });

                detailPopUp.on('hidden.bs.modal', function () {
                    $(this).remove();
                });
            });


            dataTable.on('click', '.delete-item', function () {

                var enrollId = $(this).attr('id').replace("delete-", '');

                if (!enrollId) {
                    toastr.error('Invalid Item', "Server Notification");
                }


                SweetAlert.confirm({
                    text: 'You will not be able to recover this data. Do you want to remove this feature?'
                }, function () {

                    global.mySiteAjax({
                        url: '{!! route('delete-sim-file') !!}',
                        type: 'post',
                        data: {type: 'singel', ids: enrollId},
                        loadSpinner: true,
                        success: function (response) {
                            if (response.status == 'success') {
                                toastr.success(response.html, "Server Notification");
                            } else if (response.status == 'error') {
                                toastr.error(response.html, "Server Notification");
                            }
                            dataTable.ajax.reload();
                        }
                    });
                });
            });

            dataTable.on('click', '.reprocess-item', function () {

                var fileId = $(this).attr('id').replace("reprocess-", '');

                if (!fileId) {
                    toastr.error('Invalid Item', "Server Notification");
                }


                SweetAlert.confirm({
                    text: 'Do you want to reporcess sim registration?'
                }, function () {

                    global.mySiteAjax({
                        url: '{!! route('reprocess-sim-file') !!}',
                        type: 'post',
                        data: { fileId : fileId},
                        loadSpinner: true,
                        success: function (response) {
                            if (response.status == 'success') {
                                toastr.success(response.html, "Server Notification");
                            } else if (response.status == 'error') {
                                toastr.error(response.html, "Server Notification");
                            }
                            dataTable.ajax.reload();
                        }
                    });
                });
            });

        })(window);
    });
</script>
@endpush
@push('scripts-middle')
<script src="{{ URL::asset('/assets/pages/scripts/ui-blockui.min.js') }}"></script>

@endpush



