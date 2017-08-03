@push('styles')

<link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet"
      type="text/css"/>
<link href="{{ URL::asset('/assets/global/plugins/sweetalert/dist/sweetalert.css') }}" rel="stylesheet"/>

@endpush

@extends('layouts.main')

@section('pagebar')
    @include('layouts.pagebar',['title' => 'Sim Information list'])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">Processing Retry List</span>
                    </div>
                </div>
                <div class="portlet-body util-btn-margin-bottom-5">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="domain-email-table">
                                <thead>
                                <tr>
                                    <th>File</th>
                                    <th>NetworK</th>
                                    <th>Subscribe</th>
                                    <th>Sim Pack</th>
                                    <th>Last digit</th>
                                    <th>Sim Number</th>
                                    <th>Code</th>
                                    <th>Retry</th>
                                    <th>Process date</th>
                                    <th>Status</th>
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
<script src="{{ URL::asset('/assets/global/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>

<script>

    $(function () {

        (function (global) {
            var dataTable = $('#domain-email-table').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [ 10, 25, 50, 100, 200, 300 ,500 ],
                "pageLength": 200,
                dom: 'Bfltip',
                buttons: [
                    'pdf', 'print', 'selectAll',
                    'selectNone', 'colvis',
                    {
                        text: 'Delete All',
                        action: function (e, dt, node, config) {
                            if(dataTable.rows('.selected').data().length <= 0){
                                toastr.error("Please select some row first", "Server Notification");
                                return false;
                            }
                            SweetAlert.confirm({
                                text: 'You will not be able to recover this data. Do you want to remove this feature?'
                            }, function () {
                                var ids = [];
                                var allIds = dataTable.rows('.selected').data();

                                for(var i = 0; i < allIds.length; i++) {
                                    ids[i] = allIds[i].id;
                                }

                                global.mySiteAjax({
                                    url: '{!! route('delete-sim-contact') !!}',
                                    type: 'post',
                                    data: {type: 'bulk', ids: ids},
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
                        }
                    }
                ],
                ajax: '{!! route('report-retry-list') !!}',
                columns: [
                    {data: 'file_name', name: 'file_name', "orderable": true, "searchable":true,"width": '20%'},
                    {data: 'network', name: 'network', "orderable": true, "searchable":true},
                    {data: 'existing_new_subscribe', name: 'existing_new_subscribe', "orderable": true, "searchable":true,"visible": false},
                    {data: 'sim_stater_pack', name: 'sim_stater_pack', "orderable": true, "searchable":true},
                    {data: 'last_4_digit_of_sim', name: 'last_4_digit_of_sim', "orderable": true, "searchable":true},
                    {data: 'sim_number', name: 'sim_number', "orderable": true, "searchable":true},
                    {data: 'response_code', name: 'response_code', "orderable": true, "searchable":true},
                    {data: 'retry', name: 'retry', "orderable": true, "searchable":true},
                    {data: 'process_date', name: 'process_date', "orderable": true, "searchable":true},
                    {data: 'process_flag', name: 'process_flag', "orderable": true, "searchable":true},
                    {data: 'action', name: 'action', "orderable": false, "searchable":false},
                ],"createdRow": function ( row, data ) {


                    var statusObj = { status : 'invalid', class : 'label label-danger'};

                    if(data.process_flag == '0') {
                        statusObj = { 'status' : 'pending', 'class' : 'label label-warning'}
                    } else if(data.process_flag == '3') {
                        statusObj = { 'status' : 'retry', 'class' : 'label label-primary'}
                    } else if(data.process_flag == '2') {
                        statusObj = { 'status' : 'failed', 'class' : 'label label-danger'}
                    } else if(data.process_flag == '1') {
                        statusObj = { 'status' : 'seccess', 'class' : 'label label-success'}
                    }

                    $('td', row).eq(8).html($('<span>').attr({
                        class: statusObj.class
                    }).html(statusObj.status));
                }
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
                        url: '{!! route('delete-sim-contact') !!}',
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
        })(window);
    });
</script>
@endpush


