<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{env('APP_NAME')}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF TOKEN AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- Bootstrap template -->
    <link rel="stylesheet" href="{{ asset('admin-lte/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin-lte/font-awesome/css/font-awesome.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('admin-lte/ionicons/css/ionicons.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-lte/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="{{ asset('admin-lte/dist/css/skins/skin-yellow.min.css') }}">

    <!--bootstrap tab-->
    <link rel="stylesheet" href="{{asset('admin-lte/tag/bootstrap-tagsinput.css')}}">


            <!-- ================================ Plugins Bootstrap ================================= -->

    <!-- Bootstrap Include Date Range Picker -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Bootstrap DATE TIME PICKER -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') }}">

    <!-- Bootstrap validator -->
    <link rel="stylesheet" href="{{asset('admin-lte/plugins/bootstrap-validator/css/bootstrapValidator.min.css')}}" >


            <!-- ================================ Others Plugins ================================= -->

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/iCheck/all.css') }}">
    <!-- css viewbox -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/viewbox/viewbox.css') }}">

    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/select2/select2.css') }}" >

    <!-- Wait me CSS -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/waitMe/waitMe.css') }}" >


            <!-- ================================ CUSTOM ================================= -->

    <!-- CUSTOM css-->
    <link rel="stylesheet" href="{{ asset('admin-lte/css/style.css') }}">



            <!-- ================================ PRELOADING ================================= -->

    <!-- PACE PRELOADING -->
    <script src="{{asset('admin-lte/plugins/pace/pace.min.js')}}"></script>
    <link href="{{asset('admin-lte/plugins/pace/themes/blue/pace-theme-flash.css')}}" rel="stylesheet" />


    @yield('css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

    <script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>





<body class="hold-transition skin-yellow sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            @component('components.admin_header')@endcomponent
        </header>
        <aside class="main-sidebar">
            @component('components.admin_main_sidebar')@endcomponent
        </aside>


        <!-- =============CONTENT===============-->

        <div class="content-wrapper">
            @include('core::messages.msg')
            @yield('content')
        </div>


        <!-- ===========ENDCONTENT===============-->





        <footer class="main-footer">
            @component('components.admin_footer')@endcomponent
        </footer>
        <aside class="control-sidebar control-sidebar-dark">

        </aside>
    </div>
    <div aria-hidden="false" aria-labelledby="mySmallModalLabel" role="dialog" class="modal fade in" id="detailModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 id="finishModalLabel" class="modal-title">Cập nhật dữ liệu</h4>
                </div>
                <div id='modal_content' class="modal-body"></div>
            </div>
        </div>
    </div>


    <!-- ==================================JAVASCRIPT HERE==========================================-->

    <!-- jQuery 3 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('admin-lte/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- JQUERY VALIDATION link:https://github.com/proengsoft/laravel-jsvalidation/wiki/Laravel-5.6-installation-->
    <script src="{{ asset('admin-lte/plugins/jqueryValidation/jquery.validate.min.js') }}"></script>


    <!-- =======DATE TIME======= -->
    <!-- AdminLTE App -->
    <script src="{{ asset('admin-lte/dist/js/adminlte.min.js') }}"></script>
    <!-- Moment js-->
    <script src="{{ URL::asset('admin-lte/dist/js/moment-with-locales.min.js') }}"></script>
    <!-- DATE PICKER -->
    <script src="{{ asset('admin-lte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- DATE TIME PICKER -->
    <script src="{{ URL::asset('admin-lte/dist/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- DATE RANGE PICKER -->
    <script src="{{ asset('admin-lte/plugins/daterangepicker/daterangepicker.js') }}"></script>


    <!-- ================================ Plugins Bootstrap ================================= -->
    <!--bootstrap tab-->
    <script src="{{ asset('admin-lte/tag/bootstrap-tagsinput.js') }}"></script>

    <!-- DATATABLE -->
    <script src="{{ asset('admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

    <!--Datatable helper -->
    <script src="{{ asset('helperJS/dataTableHelper.js') }}"></script>



    <!-- ================================ Others Plugins ================================= -->

    <!-- NOTIFICATION doc:https://notifyjs.jpillora.com/-->
    <script src="{{ asset('admin-lte/plugins/notifyJS/notify.min.js') }}"></script>

    <!--Icheck-->
    <script src="{{ asset('admin-lte/plugins/iCheck/icheck.min.js') }}"></script>

    <!-- Select 2 -->
    <script src="{{ asset('admin-lte/plugins/select2/select2.js') }}"></script>


    <!-- Wait me JS -->
    <script src="{{ asset('admin-lte/plugins/waitMe/waitMe.js') }}"></script>

    <!-- Jquery View-->
    <script src="{{ asset('admin-lte/plugins/viewbox/jquery.viewbox.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/gdoc/jquery.gdocsviewer.min.js') }}"></script>



    <!-- ====================================CHART JS====================================== -->

    <script src="{{ asset('admin-lte/plugins/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/flot/jquery.flot.categories.js') }}"></script>
    <script src="{{asset('/helperJS/autoNumeric.js')}}"></script>




    <!-- ==================================MODAL HELPER================================== -->

    <div id="div-fill-modal"></div>
    <!-- Show Notify, Show Modal, Btn_loading -->
    <script src="{{asset('/helperJS/multipleHelper.js')}}"></script>
    <script src="{{asset('/helperJS/profile.js')}}"></script>

    <!-- ==================================CUSTOM JS================================== -->

    <!-- Call modal, call Ajax -->
    <script src="{{ asset('helperJS/jqueryFunctionHelper.js') }}"></script>

    <!-- Initial DateTimePicker and Validation form-->
    <script src="{{ asset('helperJS/initDatetimeAndValidateFormJS.js') }}"></script>

    <!-- Some function need to run in document ready function: Select2 ,.... -->
    <script src="{{ asset('helperJS/documentReadyFunction.js') }}"></script>

    @yield('scripts')

</body>
</html>
