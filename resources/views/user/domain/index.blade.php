@push('styles')
<link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
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
                        <span class="caption-subject font-green sbold uppercase">Add domain</span>
                    </div>
                </div>
                <div class="portlet-body util-btn-margin-bottom-5">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <input id="domain-val" type="text" class="form-control" placeholder="Enter Domain name..(google.com)">
                                            <span class="input-group-btn">
                                                <a href="javascript:;" class="btn blue btn-outline" id="search-domain"> Search Domain</a>
                                            </span>
                                    </div>
                                </div>
                                <div class="mt-element-list" id="blockui_sample_4_portlet_body">
                                    <div class="mt-list-head list-simple ext-1 font-white bg-green-sharp">
                                        <div class="list-head-title-container">
                                            <h3 class="list-title">Domain list</h3>
                                        </div>
                                    </div>
                                    <div class="mt-list-container list-simple">
                                        <div class="table-scrollable">
                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        Domain name</th>
                                                    <th class="hidden-xs">
                                                        Status </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="domainResult">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="domain-table">
                                <thead>
                                <tr>
                                    <th>Domain name</th>
                                    <th>Status</th>
                                    <th>Message</th>
                                    <th>Enable</th>
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
            var dataTable = $('#domain-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('list-domain') !!}',
                columns: [
                    {data: 'name', name: 'name', "orderable": true, "searchable":true},
                    {data: 'status', name: 'status', "orderable": true, "searchable":true},
                    {data: 'message', name: 'message', "orderable": false, "searchable":false},
                    {data: 'enable', name: 'enable', "orderable": false, "searchable":false},
                ],
                "createdRow": function ( row, data ) {
                    $('td', row).eq(3).html($('<span>').attr({
                        class: (data.enable == true) ? 'label label-success' : "label label-danger"
                    }).html((data.enable == true) ? 'Active' : 'Disable'));

                    var statusObj = { status : 'invalid', class : 'label label-danger'};

                    if(data.status === 'pending') {
                        statusObj = { 'status' : 'pending', 'class' : 'label label-warning'}
                    } else if(data.status === 'processing') {
                        statusObj = { 'status' : 'processing', 'class' : 'label label-primary'}
                    } else if(data.status === 'failed') {
                        statusObj = { 'status' : 'failed', 'class' : 'label label-danger'}
                    } else if(data.status === 'success') {
                        statusObj = { 'status' : 'seccess', 'class' : 'label label-success'}
                    }

                    $('td', row).eq(1).html($('<span>').attr({
                        class: statusObj.class
                    }).html(statusObj.status));
                }
            });

            $('#domainResult').on('click','.order-now',function() {

                var domainName = $(this).attr('id');

                if(!domainName.length){
                    toastr.error("Invalid Doamin name","Server Response");
                    return false;
                }


                global.mySiteAjax({
                    url: '{!! route('order-domain') !!}',
                    type: 'post',
                    data: {domainName : domainName},
                    loadSpinner: true,
                    success: function (response) {
                        App.unblockUI('#blockui_sample_4_portlet_body');
                        $("#domainResult").html('');
                        if (response.status == 'success') {
                            toastr.success(response.html,"Server Notification");
                            dataTable.ajax.reload();
                        } else if (response.status == 'error') {
                            toastr.error(response.html,"Server Notification");
                        }
                    },
                    beforeSend: function () {
                        App.blockUI({
                            target: '#blockui_sample_4_portlet_body'
                        });
                    },
                });
            });

            var Template = function(data) {

                var Defaultdata = {
                    domain : "domain name",
                    availavility : 'Available',
                    order : false
                };

                data = $.extend(Defaultdata, data);

                var template = '<tr> ' +
                        '<td class="highlight"> <a href="javascript:;"> ' + data.domain + ' </a> </td> ' +
                        '<td class="hidden-xs"> <a href="javascript:;" class="btn  btn-sm purple">'+ data.availavility + '</a> </td>' +
                        ' <td> ';

                if(data.order === true) {
                    template +=  '<a href="javascript:;" id="'+ data.domain+'" class="btn btn-outline btn-circle btn-sm purple order-now"> <i class="fa fa-edit"></i> Order now </a> ';
                }


                template += '</td> ' + '</tr>';


                this.render =  function () {
                    return template;
                }

            };

            $("#search-domain").on('click',function() {
               var domain = $.trim($('#domain-val').val());

                if(!domain.length) {
                    toastr.error("Invalid Doamin name","Server Response");
                    return false;
                }

                global.mySiteAjax({
                    url: '{!! route('check-domain') !!}',
                    type: 'post',
                    data: {domainName : domain},
                    loadSpinner: true,
                    success: function (response) {
                        App.unblockUI('#blockui_sample_4_portlet_body');

                        if (response.status == 'success') {
                            var searchResult = JSON.parse(response.html);
                            if(searchResult.success === true) {
                                toastr.success(searchResult.message,"Server Notification");
                            }
                            else {
                                toastr.error(searchResult.message,"Server Notification");
                            }
                            var TemplateData = new Template({
                                domain : domain,
                                availavility : (searchResult.success === true) ? "Available" : 'Not Available',
                                order : searchResult.success
                            });

                            $("#domainResult").html(TemplateData.render());

                        } else if (response.status == 'error') {
                            toastr.error(response.html,"Server Notification");
                        }
                    },
                    beforeSend: function () {
                        App.blockUI({
                            target: '#blockui_sample_4_portlet_body'
                        });
                    },
                });
            });


        })(window);
    });
</script>
@endpush
@push('scripts-middle')
<script src="{{ URL::asset('/assets/pages/scripts/ui-blockui.min.js') }}"></script>

@endpush



