<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="{{config('constants.baseURL')}}">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Property Portal') }}</title>

        <!-- Bootstrap -->
        <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- iCheck -->
        <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">

        <!-- bootstrap-progressbar -->
        <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <!-- bootstrap-daterangepicker -->
        <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <!-- Bootstrap Switch CSS for radio buttons & checkboxes -->
        <link href="{!! asset('css/bootstrap-switch.min.css') !!}" rel="stylesheet" type="text/css">

        <!-- Custom Theme Style -->
        <link href=" build/css/custom.min.css" rel="stylesheet">
        <!-- Custom Theme Style created by Siva -->
        <link href="style.css" rel="stylesheet">
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include("portal.includes.left_menu")
                <!-- top navigation -->
                @include("portal.includes.header")
                <!-- /top navigation -->
                <!-- page content -->
                <div class="right_col" role="main">
                    @yield('content')
                </div>
                <!-- /page content -->
                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Developed By - , &copy;&nbsp;{{ date('Y') }}
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>
        <!-- jQuery -->
        <script src="vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="vendors/nprogress/nprogress.js"></script>
        <!-- iCheck -->
        <script src="vendors/iCheck/icheck.min.js"></script>
        <!-- DateJS -->
        <script src="vendors/DateJS/build/date.js"></script>
        <!-- bootstrap-daterangepicker -->
        <script src="vendors/moment/min/moment.min.js"></script>
        <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- Custom Theme Scripts -->
        <script src="build/js/custom.min.js"></script>
        <!-- Validation JS -->
        <script src="{!! asset('js/jquery.validate.min.js') !!}" type="text/javascript"></script>
        <!-- Bootstrap Switch JS For Radio Buttons & Checkboxes -->
        <script src="{!! asset('js/bootstrap-switch.min.js') !!}" type="text/javascript"></script>
        @yield('footer_page_scripts')
    </body>
</html>