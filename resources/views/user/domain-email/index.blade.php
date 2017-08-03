@push('styles')
<link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset('/assets/global/plugins/fine-uploader/jquery.fine-uploader/fine-uploader.min.css') }}">
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
    @include('layouts.pagebar',['title' => 'Add domain'])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">User domain</span>
                    </div>
                </div>
                <div class="portlet-body util-btn-margin-bottom-5">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <button id="sample_editable_1_new" class="btn sbold green add-item"> Add New
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button id="sample_editable_1_new" class="btn sbold green bluk-add"> Bulk Upload
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="domain-email-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Enable</th>
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
            <div>Select files</div>
        </div>
        <button type="button" id="trigger-upload" class="btn btn-primary">
            <i class="icon-upload icon-white"></i> Upload
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
                ajax: '{!! route('list-domain-email') !!}',
                columns: [
                   /* {data: 'domains.name', name: 'domains.name', "orderable": true, "searchable":true},*/
                    {data: 'name', name: 'name', "orderable": true, "searchable":true},
                    {data: 'email', name: 'email', "orderable": true, "searchable":true},
                    {data: 'enable', name: 'enable', "orderable": false, "searchable":false},
                    {data: 'action', name: 'action', "orderable": false, "searchable":false},
                ],
                "createdRow": function ( row, data ) {
                    $('td', row).eq(2).html($('<span>').attr({
                        class: (data.enable == true) ? 'label label-success' : "label label-danger"
                    }).html((data.enable == true) ? 'Active' : 'Disable'));
                }
            });



            var addButton = $(".add-item");

            addButton.on('click', function () {

                global.waitingDialog.show('Please wait...', {dialogSize: 'sm', progressType: 'warning'});

                var detailPopUp = global.customPopup.show({
                    header: 'Add EmailBox',
                    message: ''
                });

                detailPopUp.on('shown.bs.modal', function () {
                    var modal = $(this);

                    global.mySiteAjax({
                        url: '{!! route('domain-email-form') !!}',
                        type: 'get',
                        loadSpinner: false,
                        success: function (response) {
                            window.nbUtility.ajaxErrorHandling(response, function () {
                                modal.find('.modal-body').html(response.html);
                                global.waitingDialog.hide();

                                $('#group-from')
                                        .parsley(global.parsleySettings.settings)
                                        .on('form:success', function (formInstance) {
                                            if (formInstance.isValid()) {
                                                global.mySiteAjax({
                                                    url: '{!! route('domain-email-submit') !!}',
                                                    type: 'post',
                                                    data: $('#group-from').serialize(),
                                                    loadSpinner: true,
                                                    success: function (response) {
                                                        if (response.status == 'validation-error')
                                                            global.generateErrorMessage(formInstance, response.html);
                                                        else if (response.status == 'success') {
                                                            modal.modal('hide');
                                                            var searchResult = JSON.parse(response.html);
                                                            console.log(searchResult);
                                                            if(searchResult.success === true)
                                                                toastr.success(searchResult.message,"Server Notification");
                                                            else
                                                                toastr.error(searchResult.message,"Server Notification");
                                                            dataTable.ajax.reload();
                                                        } else if (response.status == 'error') {
                                                            toastr.error(response.html,"Server Notification");
                                                        }
                                                    }
                                                });
                                            }
                                        }).on('form:submit', function () {
                                            return false;
                                        });

                            });
                        }
                    });
                });

                detailPopUp.on('hidden.bs.modal', function () {
                    $(this).remove();
                });
            });

            var bulkAddButton = $(".bluk-add");
            bulkAddButton.on('click', function () {

                global.waitingDialog.show('Please wait...', {dialogSize: 'sm', progressType: 'warning'});

                var detailPopUp = global.customPopup.show({
                    header: 'Add Bulk EmailBox',
                    message: '',
                    dialogSize: 'lg'
                });

                detailPopUp.on('shown.bs.modal', function () {
                    var modal = $(this);

                    global.mySiteAjax({
                        url: '{!! route('bulk-email-form') !!}',
                        type: 'get',
                        loadSpinner: false,
                        success: function (response) {
                            window.nbUtility.ajaxErrorHandling(response, function () {
                                modal.find('.modal-body').html(response.html);
                                global.waitingDialog.hide();

                                $('#fine-uploader-gallery').fineUploader({
                                    template: 'qq-template-validation',
                                    request: {
                                        endpoint: '{!! route('bulk-upload') !!}'
                                    },
                                    thumbnails: {
                                        placeholders: {
                                            waitingPath: '/assets/global/img/waiting-generic.png',
                                            notAvailablePath: '/assets/global/img/not_available-generic.png'
                                        }
                                    },
                                    validation: {
                                        allowedExtensions: ['csv'],
                                        itemLimit : 5,
                                        sizeLimit : 2097152
                                    },
                                    callbacks: {
                                        onAllComplete: function(id, xhr, isError) {
                                            if(qq.status.UPLOAD_SUCCESSFUL) {

                                            }

                                        }
                                    },
                                    autoUpload: true,
                                });

                                $('#trigger-upload').click(function() {
                                    $('#fine-uploader-gallery').fineUploader('uploadStoredFiles');
                                });

                            });
                        }
                    });
                });

                detailPopUp.on('hidden.bs.modal', function () {
                    $(this).remove();
                });
            });

        })(window);
    });
</script>
@endpush
@push('scripts-middle')
<script src="{{ URL::asset('/assets/pages/scripts/ui-blockui.min.js') }}"></script>

@endpush



