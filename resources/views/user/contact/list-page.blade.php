@push('styles')
<link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset('/assets/global/plugins/fine-uploader/jquery.fine-uploader/fine-uploader.min.css') }}">
@endpush

@extends('layouts.main')

@section('pagebar')
    @include('layouts.pagebar',['title' => 'Add User Address'])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">User Address List</span>
                    </div>
                </div>
                <div class="portlet-body util-btn-margin-bottom-5">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="domain-email-table">
                                <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Full name</th>
                                    <th>Surname</th>
                                    <th>Type</th>
                                    <th>ID Nationality</th>
                                    <th>ID Number</th>
                                    <th>Contact no</th>
                                    <th>Address</th>
                                    <th>Country</th>
                                    <th>Postal Code</th>
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
<script src="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
<script>

    $(function () {

        (function (global) {
            var dataTable = $('#domain-email-table').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                "pageLength": 50,
                dom: 'Bfltip',
                buttons: [
                    'pdf', 'print', 'colvis'
                ],
                ajax: '{!! route('contact-list') !!}',
                columns: [
                    {data: 'file_name', name: 'file_name', "orderable": true, "searchable":true,"width": '20%'},
                    {data: 'full_name', name: 'full_name', "orderable": true, "searchable":true},
                    {data: 'sumame', name: 'sumame', "orderable": true, "searchable":true},
                    {data: 'indentification_type', name: 'indentification_type',"visible": false, "orderable": true, "searchable":true},
                    {data: 'id_nationality', name: 'id_nationality',"visible": false, "orderable": true, "searchable":true},
                    {data: 'id_number', name: 'id_number', "orderable": true, "searchable":true},
                    {data: 'contact_no', name: 'contact_no', "orderable": true, "searchable":true},
                    {data: 'address_1', name: 'address_1', "orderable": true, "searchable":true},
                    {data: 'country', name: 'country', "orderable": true, "searchable":true},
                    {data: 'postal_code', name: 'postal_code', "orderable": true, "searchable":true},
                ]
            });

        })(window);
    });
</script>
@endpush
@push('scripts-middle')
<script src="{{ URL::asset('/assets/pages/scripts/ui-blockui.min.js') }}"></script>

@endpush



