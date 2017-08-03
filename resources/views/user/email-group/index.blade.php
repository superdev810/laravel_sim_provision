@push('styles')
<link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@extends('layouts.main')

@section('pagebar')
    @include('layouts.pagebar',['title' => 'Add Group'])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">Email group</span>
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
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="domain-email-table">
                                <thead>
                                <tr>
                                    <th>Group Name</th>
                                    <th>Created</th>
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
<script>

    $(function () {

        (function (global) {

            var dataTable = $('#domain-email-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('list-group') !!}',
                columns: [
                    {data: 'name', name: 'name', "orderable": true, "searchable":true},
                    {data: 'created_at', name: 'created_at', "orderable": true, "searchable":true},
                    {data: 'action', name: 'action', "orderable": false, "searchable":false},
                ]
            });



            var addButton = $(".add-item");

            addButton.on('click', function () {

                global.waitingDialog.show('Please wait...', {dialogSize: 'sm', progressType: 'warning'});

                var detailPopUp = global.customPopup.show({
                    header: 'Add EmailBox Group',
                    message: ''
                });

                detailPopUp.on('shown.bs.modal', function () {
                    var modal = $(this);

                    global.mySiteAjax({
                        url: '{!! route('email-group-form') !!}',
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
                                                    url: '{!! route('group-submit') !!}',
                                                    type: 'post',
                                                    data: $('#group-from').serialize(),
                                                    loadSpinner: true,
                                                    success: function (response) {
                                                        if (response.status == 'validation-error')
                                                            global.generateErrorMessage(formInstance, response.html);
                                                        else if (response.status == 'success') {
                                                            modal.modal('hide');
                                                            var searchResult = JSON.parse(response.html);
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


            dataTable.on('click', '.edit-item', function () {
                var groupId = $(this).attr('id').replace("edit-", '');

                if (!groupId) {
                    toastr.error(response.html,"Invalid group");
                }

                global.waitingDialog.show('Please wait...', {dialogSize: 'sm', progressType: 'warning'});

                var editPopUp = global.customPopup.show({
                    header: 'Show Group Emails',
                    message: ''
                });

                editPopUp.on('shown.bs.modal', function () {
                    var modal = $(this);
                    global.mySiteAjax({
                        url: '{!! route('group-details') !!}',
                        type: 'post',
                        data: {id: groupId},
                        loadSpinner: true,
                        success: function (response) {
                            window.nbUtility.ajaxErrorHandling(response, function () {
                                modal.find('.modal-body').html(response.html);
                                global.waitingDialog.hide();
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
@push('scripts-middle')
<script src="{{ URL::asset('/assets/pages/scripts/ui-blockui.min.js') }}"></script>
@endpush



