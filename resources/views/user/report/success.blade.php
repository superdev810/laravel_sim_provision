@push('styles')
<link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@extends('layouts.main')

@section('pagebar')
    @include('layouts.pagebar',['title' => 'Sim Processing Report'])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">Sim Processing Success List</span>
                    </div>
                </div>
                <div class="portlet-body util-btn-margin-bottom-5">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="domain-email-table">
                                <thead>
                                <tr>
                                    <th>Fullname</th>
                                    <th>Sumame</th>
                                    <th>Id Number</th>
                                    <th>Address</th>
                                    <th>Contact <No></No></th>
                                    <th>Sim Number</th>
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
                "lengthMenu": [ 10, 25, 50, 100, 300 ,500 ],
                "pageLength": 200,
                dom: 'Bfrtip',
                buttons: [
                    'pdf', 'print'
                ],
                ajax: '{!! route('report-success-list') !!}',
                columns: [
                    {data: 'full_name', name: 'full_name', "orderable": true, "searchable":true},
                    {data: 'sumame', name: 'sumame', "orderable": true, "searchable":true},
                    {data: 'id_number', name: 'id_number', "orderable": true, "searchable":true},
                    {data: 'address_1', name: 'address_1', "orderable": true, "searchable":true},
                    {data: 'contact_no', name: 'contact_no', "orderable": true, "searchable":true},
                    {data: 'sim_number', name: 'sim_number', "orderable": true, "searchable":true},
                ],
                "createdRow": function ( row, data ) {


                    var statusObj = { status : 'invalid', class : 'label label-danger'};

                    if(data.process_flag === 0) {
                        statusObj = { 'status' : 'pending', 'class' : 'label label-warning'}
                    } else if(data.status === 3) {
                        statusObj = { 'status' : 'retry', 'class' : 'label label-primary'}
                    } else if(data.status === 2) {
                        statusObj = { 'status' : 'failed', 'class' : 'label label-danger'}
                    } else if(data.status === 1) {
                        statusObj = { 'status' : 'seccess', 'class' : 'label label-success'}
                    }

                    $('td', row).eq(8).html($('<span>').attr({
                        class: statusObj.class
                    }).html(statusObj.status));
                }
            });


        })(window);
    });
</script>
@endpush


