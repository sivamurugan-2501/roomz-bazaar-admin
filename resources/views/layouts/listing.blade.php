<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="{{ env('APP_BURL') }}">
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
        @yield('header_page_scripts')
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
        <!--script src="build/js/custom.min.js"></script-->
        <!-- Validation JS -->
        <script src="{!! asset('js/jquery.validate.min.js') !!}" type="text/javascript"></script>
        <!-- Bootstrap Switch JS For Radio Buttons & Checkboxes -->
        <script src="{!! asset('js/bootstrap-switch.min.js') !!}" type="text/javascript"></script>
        <script type="text/javascript">
            function create_viewTable(inputType, defaultColumn, searchURL, columnDef)
            {
                var txtColObj = [];
                $("#dt_viewTable > thead > tr:first th").each(function(){
                    txtColObj.push({"data":$(this).attr("data-paramid")});
                });

                var txtSearchFieldHTML = "";
                $('#dt_viewTable tfoot th').each( function () {
                    var title = '', titleID = '', tempTDHTML = '', tempTHeadObj = '', tempTFootObj = '', searchType = $(this).attr('data-searchtype');
                    tempTHeadObj = $('#dt_viewTable thead > tr:nth-child(1)').find('th').eq($(this).index());
                    tempTFootObj = $('#dt_viewTable thead > tr:nth-child(1)').find('th').eq($(this).index());
                    
                    title = $.trim($(tempTHeadObj).text());

                    if( title != null && title != "" )
                    {
                        /* Code to add searchable input elements starts here */
                        switch(searchType)
                        {
                            case 'nosearch':
                                txtSearchFieldHTML += '<td>&nbsp;</td>';
                                break;
                            case 'select':
                                titleID=$.trim($(tempTFootObj).attr("data-paramid"));
                                titleID=$.trim(titleID).toString().replace(" ","_");
                                
                                txtSearchFieldHTML += '<td>';
                                if( titleID != null && titleID != '' )
                                {
                                    txtSearchFieldHTML +=   '<select class="form-control" name="txt_'+ titleID +'">'+
                                                                '<option value="">All</option>'+
                                                                '<option value="1">Active</option>'+
                                                                '<option value="0">Inactive</option>'+
                                                            '</select>';
                                }
                                txtSearchFieldHTML += '</td>';
                                break;
                            case 'text':
                                titleID=$.trim($(tempTFootObj).attr("data-paramid"));
                                titleID=$.trim(titleID).toString().replace(" ","_");
                                
                                txtSearchFieldHTML += '<td>';
                                if( titleID != null && titleID != '' )
                                {
                                    txtSearchFieldHTML += '<input type="text" class="form-control" name="txt_'+titleID+'" '+
                                                         'maxlength="30" placeholder="Search '+title+'">';
                                }else{  txtSearchFieldHTML += '&nbsp;';  }
                                txtSearchFieldHTML += '</td>';
                        }
                        /* Code to add searchable input elements ends here */
                    }else{  txtSearchFieldHTML += '<td>&nbsp;</td>';  }
                } );
                txtSearchFieldHTML ="<tr>"+ txtSearchFieldHTML +"</tr>";
                $('#dt_viewTable thead').html(txtSearchFieldHTML+$('#dt_viewTable thead').html());

                tableDataTable = $('#dt_viewTable').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "asc" ]],
                    "ajax": {
                        "url": searchURL,
                        "type":"POST",
                        "data": function ( d ) {
                            d.list_for = inputType;
                            d.default_column = defaultColumn;
                            d._token = "{{ csrf_token() }}";
                        }
                    },
                    "columns"     : txtColObj,
                    columnDefs    : columnDef,
                    searching     : true
                });

                if( $('div[id="dt_viewTable_filter"]').length > 0 )
                {  $('div[id="dt_viewTable_filter"]').remove();  }
                
                // Apply the filter
                tableDataTable.columns().indexes().each( function (idx) {
                    var txtObjType = 'input, select';
                    $('table.dataTable thead > tr > td').eq(idx).find(txtObjType).on('change', function(){
                        var txtSearchedValue = this.value;
                        tableDataTable
                            .column( idx )
                            .search( txtSearchedValue )
                            .draw();
                    });
                });
            }
        </script>
        @yield('footer_page_scripts')
    </body>
</html>