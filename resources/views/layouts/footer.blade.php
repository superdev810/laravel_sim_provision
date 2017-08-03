
</div>
<div class="page-footer">
    <div class="page-footer-inner"> {{date('Y')}} &copy; {{strtoupper('orangetoolz')}}
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
<!--[if lt IE 9]>
<script src="{{ URL::asset('/assets/global/plugins/respond.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/excanvas.min.js') }}" type="text/javascript"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ URL::asset('/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/parsleyjs/dist/parsley.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
@stack('scripts-middle')
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ URL::asset('/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ URL::asset('/assets/layouts/layout/scripts/layout.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/layouts/layout/scripts/demo.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>




<script src="{{ URL::asset('/assets/global/scripts/global.js')}}" type="text/javascript"></script>

@stack('scripts')


</body>

</html>