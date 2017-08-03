@push('styles')
<link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@extends('layouts.main')

@section('pagebar')
    @include('layouts.pagebar',['title' => 'User Creation'])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">User Creation</span>
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
                                <div class="btn-group">
                                    <button id="sample_editable_1_new" class="btn sbold green add-item"> Add New
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
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
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="user-table">
                                <thead>
                                <tr>
                                    <th>Full name</th>
                                    <th>Email</th>
                                    <th>Active</th>
                                    <th>Created at</th>
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

<script src="{{ URL::asset('/assets/global/plugins/bootstrap-notify-master/bootstrap-notify.min.js') }}"></script>
<script src="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
<script>

    $(function () {

        (function (global) {
            var dataTable = $('#user-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('user-list') !!}',
                columns: [
                    {data: 'full_name', name: 'full_name', "orderable": true, "searchable":true},
                    {data: 'email', name: 'email', "orderable": true, "searchable":true},
                    {data: 'active', name: 'active', "orderable": false, "searchable":false},
                    {data: 'created_at', name: 'created_at', "orderable": false, "searchable":false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "createdRow": function ( row, data ) {
                    $('td', row).eq(2).html($('<button>').attr({
                        class: (data.active == true) ? 'btn btn-sm btn-primary' : "btn btn-sm btn-danger"
                    }).html((data.active == true) ? 'Active' : 'Disable'));
                }
            });

            var addButton = $(".add-item");

            addButton.on('click', function () {

                global.waitingDialog.show('Please wait...', {dialogSize: 'sm', progressType: 'warning'});

                var detailPopUp = global.customPopup.show({
                    header: 'Add User',
                    message: ''
                });

                detailPopUp.on('shown.bs.modal', function () {
                    var modal = $(this);

                    global.mySiteAjax({
                        url: '{!! route('user-add-form') !!}',
                        type: 'get',
                        loadSpinner: true,
                        success: function (response) {
                            window.nbUtility.ajaxErrorHandling(response, function () {
                                modal.find('.modal-body').html(response.html);
                                global.waitingDialog.hide();

                                $('#user-from')
                                        .parsley(global.parsleySettings.settings)
                                        .on('form:success', function (formInstance) {
                                            if (formInstance.isValid()) {
                                                global.mySiteAjax({
                                                    url: '{!! route('user-add-submit') !!}',
                                                    type: 'post',
                                                    data: $('#user-from').serialize(),
                                                    loadSpinner: true,
                                                    success: function (response) {
                                                        if (response.status == 'validation-error')
                                                            global.generateErrorMessage(formInstance, response.html);
                                                        else if (response.status == 'success') {
                                                            modal.modal('hide');
                                                            toastr.success(response.html,"Server Notification");
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


            dataTable.on('click', '.edit-item', function () {
                var userId = $(this).attr('id').replace("edit-", '');

                if (!userId) {
                    toastr.error(response.html,"Invalid settings");
                }

                global.waitingDialog.show('Please wait...', {dialogSize: 'sm', progressType: 'warning'});

                var editPopUp = global.customPopup.show({
                    header: 'User Edit form',
                    message: ''
                });

                editPopUp.on('shown.bs.modal', function () {
                    var modal = $(this);
                    global.mySiteAjax({
                        url: '{!! route('user-edit-form') !!}',
                        type: 'post',
                        data: {id: userId},
                        loadSpinner: true,
                        success: function (response) {
                            window.nbUtility.ajaxErrorHandling(response, function () {
                                modal.find('.modal-body').html(response.html);
                                global.waitingDialog.hide();

                                $('#user-from')
                                        .parsley(global.parsleySettings.settings)
                                        .on('form:success', function (formInstance) {
                                            if (formInstance.isValid()) {

                                                $('#user-from').append($('<input>').attr({
                                                    name: 'id',
                                                    type : 'hidden',
                                                    value: userId
                                                }));

                                                global.mySiteAjax({
                                                    url: '{!! route('user-edit-submit') !!}',
                                                    type: 'post',
                                                    data: $('#user-from').serialize(),
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
