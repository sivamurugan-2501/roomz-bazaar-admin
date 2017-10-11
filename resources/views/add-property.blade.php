<?php 
  use  App\MasterPropertyType;
  $propertyType =  App\MasterPropertyType::all();
  $propertyFor = array(1=>"PG","Sale","Rent");
 if(isset($_GET['id'])){
 	$id = $_GET['id'];
 }else{
 	$id = 0;
 }

 if(isset($_GET['section'])){
 	$section = $_GET['section'];
 }else{
 	$section = 0;
 }
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
   	<base href="http://localhost/pro-portal/pprht_backend/public/portal/">    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <title>Add property</title>

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

    <!-- Custom Theme Style created by Siva -->
     <link href="style.css" rel="stylesheet">`
  </head>
<body class="nav-md">
<input type="hidden" name="section" id='section' value="<?php echo $section;?>">
    <div class="container body">
      <div class="main_container">
        @include("portal.includes.left_menu")
        @include("portal.includes.header")
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Add Property</h3>
              </div>
             
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">
                   
                    <div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="wizard_steps">
                        <li>
                          <a href="#step-1">
                            <span class="step_no">1</span>
                            <span class="step_descr">
                                  Basic Info<br />
                                  <small>Start with basic</small>
                              </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr">
                                Location<br />
                                <small></small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr">
                                Price & Size<br />
                                <small></small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-4">
                            <span class="step_no">4</span>
                            <span class="step_descr">
                                Amenities<br />
                                <small>Amenities</small>
                            </span>
                          </a>
                        </li>
                      </ul>

                      <div id="step-1">
                        <form class="form-horizontal form-label-left" action="{{route('add-edit-property-handler')}}" method="post" id="addform_1" name="addform_1">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Property|Project|Society Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="name" id="name" placeholder="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="property_type">Property Type<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown">
                              	<select name="property_type" id="property_type" class="form-control">
                              	<option value="">--Select property type--</option>
                              	<option value="1RK"> </option>
                              	<option value="1BHK">1BHK</option>
                              	<option value="2BHK">2BHK</option>
                              	<option value="Apartment">Apartment</option>
                              	<option value="Studio">Studio</option>
                              	</select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="show_as">Property For<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="show_as" id="show_as" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Sales">Sales</option>
                              	<option value="Rent">Rent</option>
                              	<option value="PG">PG</option>
                              	</select>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<textarea name="address" id="address" class="form-control" id="address"></textarea>
                              </div>
                            </div>
                          </div>

                           <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state">State<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="state" id="state" class="form-control">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="city" id="city" class="form-control">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="landmark">Landmark<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="landmark" id="landmark" class="form-control">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="age">Age<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="age" id="age" class="form-control">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total-floors">Total Floors<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="total_floors" id="total_floors" class="form-control">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="floor_no">Floor No<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="floor_no" id="floor_no" class="form-control">
                              </div>
                            </div>
                          </div>
                        
                         
                         
	                         <input type="submit" name="submit" id="submit1" class="btn btn-success" value="Save">
	                         <div class="buttonFinish buttonDisabled btn btn-default">Next</div>
	                        <!--  <a href="#" class="buttonNext btn btn-success">Next</a -->
	                         <div class="buttonPrevious buttonDisabled btn btn-primary">Previous</div>
                         
                         </form>
                         
                         </div>
                      <div id="step-2" style="display: none;">
                      <form class="form-horizontal form-label-left" method="post" action="http://127.0.0.1:8000/addProperty/{{ $id }}" name="form_2" id="form_2">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="per_square_feet">Per Square Feet<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="per_square_feet" id="per_square_feet" placeholder="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total_square_feet">Total Square Feet<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="total_square_feet" id="total_square_feet" placeholder="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="carpet_area">Carpet Area<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="carpet_area" id="carpet_area" placeholder="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usable_area">Usable Area<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="usable_area" id="usable_area" placeholder="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total-rate">Total Rate<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="total_rate" id="total_rate" placeholder="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="negotiable">Negotiable<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="negotiable" id="negotiable" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Yes">Yes</option>
                              	<option value="No">No</option>
                              	</select>
                              </div>
                            </div>
                          </div>
                           <input type="submit" name="submit2" id="submit2" class="btn btn-success" value="Save">
	                         <div class="buttonFinish buttonDisabled btn btn-default">Next</div>
							<div class="buttonPrevious buttonDisabled btn btn-primary">Previous</div>
                          </form>
                      </div>
                      <div id="step-3" style="display:none;">

                        <form class="form-horizontal form-label-left" method="post" action="http://127.0.0.1:8000/addProperty/section3/{{ $id }}" name="form_3" id="form_3">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Advance Deposit<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="advance_deposit" id="advance_deposit" placeholder="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rent_per_month">Rent Per Month<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="rent_per_month" id="rent_per_month" placeholder="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="maintenance">Maintenance<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="maintenance" id="maintenance" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Yes">Yes</option>
                              	<option value="No">No</option>
                              	</select>
                              </div>
                            </div>
                          </div>
                           <input type="submit" name="submit3" id="submit3" class="btn btn-success" value="Save">
	                         <div class="buttonFinish buttonDisabled btn btn-default">Next</div>
							<div class="buttonPrevious buttonDisabled btn btn-primary">Previous</div>
                          </form>
                      </div>
                      <div id="step-4" style="display: none;">
                        <form class="form-horizontal form-label-left" method="post" action="http://127.0.0.1:8000/addProperty/section4/{{ $id }}" name="form_4" id="form_4">
                        <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parking">Parking<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="parking" id="parking" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Yes">Yes</option>
                              	<option value="No">No</option>
                              	</select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gym">Gym<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="gym" id="gym" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Yes">Yes</option>
                              	<option value="No">No</option>
                              	</select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="furnishes">Furnishes<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="furnishes" id="furnishes" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Yes">Yes</option>
                              	<option value="No">No</option>
                              	</select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="garden">Garden<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="garden" id="garden" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Yes">Yes</option>
                              	<option value="No">No</option>
                              	</select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="other">Other<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="other" id="other" placeholder="">
                            </div>
                          </div>
                           <input type="submit" name="submit4" id="submit4" class="btn btn-success" value="Save">
	                         <div class="buttonFinish buttonDisabled btn btn-default">Next</div>
							 <div class="buttonPrevious buttonDisabled btn btn-primary">Previous</div>
                          </form>
                      </div> 

                    </div>
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
	

<script type="text/javascript" src="{!! asset('js/script.js') !!}"></script>
  
  

