<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="http://localhost/admin/public/portal/">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
  
    <title>Property View</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
     <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <style type="text/css">
    .error{
      color:red;
    }
    </style>
  </head>
<body class="nav-md">
<input type="hidden" name="addres" id="addres" value="{{ $data->address}}">
    <div class="container body">
      <div class="main_container">
        @include("portal.includes.left_menu")
        @include("portal.includes.header")
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Property view</h3>
              </div>
             
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">
                   
                      
                    
                      
                      <a href="http://127.0.0.1:8000/online-property/" class="buttonPrevious buttonDisabled btn btn-primary">Add New Property</a>
                      <div class="foo">
                        <h3 class="trigger active"></h3>
                        <div class="block">
                        <table border="" class="table table-striped table-bordered dataTable no-footer" style="width:100%;" id="datatable">
                        <tr>
                        <th>Name</th>
                        <th>Property Type</th>
                        <th>Show As</th>
                        <th>Total SF</th>
                            <th>Price</th>
                            <th>Action</th>
                            </tr>
                            <tr>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->property_type }}</td>
                            <td>{{ $data->show_as }}</td>
                            <td>{{ $data->tota_square_feet }}SF</td>
                            <td>{{ $data->total_rate }}</td>
                            <td><a href="http://127.0.0.1:8000/edit/{{ $data->id }}" class="btn btn-success" role="button">Edit</a>
                            <a href="http://127.0.0.1:8000/delete/{{ $data->id }}" class="btn btn-danger" role="button">Delete</a></td>
                            
                            </tr>
                          </table>
                        </div>
                    </div> 
                      <div id="map_div" style="height: 400px;">welcome to map view</div>

            
                    <!-- End SmartWizard Content -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
       @includeif("portal.includes.footer")
        <!-- /footer content -->
      </div>
    </div>


    <!-- jQuery -->
    <!-- <script src="vendors/jquery/dist/jquery.min.js"></script> -->
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- jQuery Smart Wizard -->
    <script src="vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- Custom Theme Scripts -->

    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
 
 
   

  </body>
</html>
<script type="text/javascript">

var map;
var geocoder;
var markers = new Array();



$(document).on('ready', initMap);
//alert('welcome');
var add = $('#addres').val();

function initMap() {
  var map = new google.maps.Map(document.getElementById('map_div'), {
    zoom: 4,
    center: {
      lat: -34.397,
      lng: 150.644
    }
  });
  var geocoder = new google.maps.Geocoder();

  geocodeAddress(add, geocoder, map);
  
}

function geocodeAddress(address, geocoder, resultsMap) {
  geocoder.geocode({
    'address': address
  }, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      resultsMap.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: resultsMap,
        position: results[0].geometry.location
      });
      markers.push(marker);
      updateZoom(resultsMap);
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function updateZoom(resultsMap) {
  var bounds = new google.maps.LatLngBounds();
  for (i = 0; i < markers.length; i++) {
    bounds.extend(markers[i].getPosition());
  }

  resultsMap.fitBounds(bounds);
}
</script>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqx8eRui1a5u9I2BCl1U9LfGogfOzZp6g&callback=initMap"
  type="text/javascript"></script>