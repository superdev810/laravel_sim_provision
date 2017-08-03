@push('styles')
<link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@extends('layouts.main')

@section('pagebar')
    @include('layouts.pagebar',['title' => 'Global Settings'])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">Settings</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-cloud-upload"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-wrench"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-trash"></i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body util-btn-margin-bottom-5">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                <div class="btn-group pull-right">
                                    <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-print"></i> Print </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="settings-table">
                                <thead>
                                <tr>
                                    <th>Default Domain per user</th>
                                    <th>Per Hour limit</th>
                                    <th>Per Day limit</th>
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
<script src="{{ URL::asset('/assets/global/plugins/parsleyjs/dist/parsley.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/bootstrap-notify-master/bootstrap-notify.min.js') }}"></script>
<script src="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
<script>

    $(function () {

        (function (global) {

            var dataTable = $('#settings-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('settings-list') !!}',
                columns: [
                    {data: 'default_domain_per_user', name: 'default_domain_per_user', "orderable": false, "searchable":false},
                    {data: 'per_hour_limit', name: 'per_hour_limit', "orderable": false, "searchable":false},
                    {data: 'per_day_limit', name: 'per_day_limit', "orderable": false, "searchable":false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            dataTable.on('click', '.edit-item', function () {
                var settingsId = $(this).attr('id').replace("edit-", '');

                if (!settingsId) {
                    toastr.error(response.html,"Invalid settings");
                }

                global.waitingDialog.show('Please wait...', {dialogSize: 'sm', progressType: 'warning'});

                var editPopUp = global.customPopup.show({
                    header: 'Settings Edit form'
                });

                editPopUp.on('shown.bs.modal', function () {
                    var modal = $(this);
                    global.mySiteAjax({
                        url: '{!! route('settings-edit-form') !!}',
                        type: 'post',
                        data: {id: settingsId},
                        loadSpinner: true,
                        success: function (response) {
                            global.waitingDialog.hide();
                            window.nbUtility.ajaxErrorHandling(response, function () {
                                modal.find('.modal-body').html(response.html);
                                $('#settings-from')
                                        .parsley(global.parsleySettings.settings)
                                        .on('form:success', function (formInstance) {
                                            if (formInstance.isValid()) {

                                                $('#settings-from').append($('<input>').attr({
                                                    name: 'id',
                                                    type : 'hidden',
                                                    value: settingsId
                                                }));

                                                global.mySiteAjax({
                                                    url: '{!! route('settings-edit-submit') !!}',
                                                    type: 'post',
                                                    data: $('#settings-from').serialize(),
                                                    loadSpinner: true,
                                                    success: function (response) {
                                                        if (response.status == 'validation-error')
                                                            global.generateErrorMessage(formInstance, response.html);
                                                        else if (response.status == 'success') {
                                                            modal.modal('hide');
                                                            toastr.success(response.html,"Invalid settings");
                                                            dataTable.ajax.reload();
                                                        } else if (response.status == 'error') {
                                                            toastr.error(response.html,"Invalid settings");
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

                editPopUp.on('hidden.bs.modal', function () {
                    $(this).remove();
                });
            });

        })(window);
    });
</script>
@endpush
