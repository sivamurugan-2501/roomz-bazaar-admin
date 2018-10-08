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
  
  //print_r($edata);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
   	<base href="http://localhost/property_portal/admin/public/portal/">
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
                        <form class="form-horizontal form-label-left" action="http://127.0.0.1:8000/addProperty/update/{{$edata->id}}" method="post" id="addform_1" name="addform_1">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <h1 class="StepTitle">Property Information</h1>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Property Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="name" id="name" placeholder="" value="{{ $edata->name }}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="property_type">Property Type<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown">
                              	<select name="property_type" id="property_type" class="form-control">
                              	<option value="">--Select property type--</option>
                              	 <option <?php echo("1RK"== $edata->property_type)?"selected":""?>>1RK</option>
							      <option <?php echo("1PHK"== $edata->property_type)?"selected":""?>>1PHK</option>
							      <option <?php echo("2PHK"== $edata->property_type)?"selected":""?>>2PHK</option>
							      <option <?php echo("Studio"== $edata->property_type)?"selected":""?>>Studio</option>
							      <option <?php echo("Apartment"== $edata->property_type)?"selected":""?>>Apartment</option>
                              	</select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="show_as">Show As<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="show_as" id="show_as" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Sales" <?php echo("Sales"== $edata->show_as)?"selected":"" ?>>Sales</option>
                              	<option value="Rent" <?php echo("Rent"== $edata->show_as)?"selected":"" ?>>Rent</option>
                              	<option value="PG" <?php echo("PG"== $edata->show_as)?"selected":"" ?>>PG</option>
                              	</select>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<textarea name="address" id="address" class="form-control">{{ $edata->address}}</textarea>
                              </div>
                            </div>
                          </div>

                           <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state">State<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="state" id="state" class="form-control" value="{{ $edata->state }}">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="city" id="city" class="form-control" value="{{ $edata->city}}">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="landmark">Landmark<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="landmark" id="landmark" class="form-control" value="{{ $edata->landmark}}" >
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="age">Age<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="age" id="age" class="form-control" value="{{ $edata->age}}" >
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total-floors">Total Floors<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="total_floors" id="total_floors" class="form-control" value="{{ $edata->total_floors}}">
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="floor_no">Floor No<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown3">
                              	<input type="text" name="floor_no" id="floor_no" class="form-control" value="{{ $edata->floor_no}}">
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
                      <h1 class="StepTitle">Size & Price</h1>
                      <form class="form-horizontal form-label-left" method="post" action="http://127.0.0.1:8000/addProperty/update2/{{ $edata->id }}" name="form_2" id="form_2">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="per_square_feet">Per Square Feet<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="per_square_feet" id="per_square_feet" placeholder="" value="{{ $edata->per_square_feet }}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total_square_feet">Total Square Feet<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="total_square_feet" id="total_square_feet" placeholder="" value="{{ $edata->tota_square_feet }}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="carpet_area">Carpet Area<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="carpet_area" id="carpet_area" placeholder="" value="{{ $edata->carpet_area }}" >
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usable_area">Usable Area<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="usable_area" id="usable_area" placeholder="" value="{{ $edata->usable_area }}" >
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total-rate">Total Rate<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="total_rate" id="total_rate" placeholder="" value="{{ $edata->total_rate}}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="negotiable">Negotiable<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="negotiable" id="negotiable" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Yes" <?php echo("Yes"== $edata->negotiable)?"selected":"" ?>>Yes</option>
                              	<option value="No" <?php echo("No"== $edata->negotiable)?"selected":"" ?>>No</option>
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
                        <h1 class="StepTitle">For Rent</h1>
                        <form class="form-horizontal form-label-left" method="post" action="http://127.0.0.1:8000/addProperty/update3/{{ $edata->id }}" name="form_3" id="form_3">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="advance_deposit">Advance Deposit<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="advance_deposit" id="advance_deposit" placeholder="" value="{{ $edata->advance_deposite}}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rent_per_month">Rent Per Month<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="rent_per_month" id="rent_per_month" placeholder="" value="{{ $edata->rent_per_month}}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="maintenance">Maintenance<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="maintenance" id="maintenance" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Yes"<?php echo("Yes"== $edata->maintenance_include)?"selected":"" ?>>Yes</option>
                              	<option value="No" <?php echo("No"== $edata->maintenance_include)?"selected":"" ?>>No</option>
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
                        <h1 class="StepTitle">Amenities</h1>
                        <form class="form-horizontal form-label-left" method="post" action="http://127.0.0.1:8000/addProperty/update4/{{ $edata->id }}" name="form_4" id="form_4">
                        <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parking">Parking<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dropdown2">
                              	<select name="parking" id="parking" class="form-control">
                              	<option value="">--Select type--</option>
                              	<option value="Yes" <?php echo("Yes"== $edata->parking)?"selected":"" ?>>Yes</option>
                              	<option value="No" <?php echo("No"== $edata->parking)?"selected":"" ?>>No</option>
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
                              	<option value="Yes" <?php echo("Yes"== $edata->gym)?"selected":"" ?>>Yes</option>
                              	<option value="No" <?php echo("No"== $edata->gym)?"selected":"" ?>>No</option>
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
                              	<option value="Yes" <?php echo("Yes"== $edata->furnishes)?"selected":"" ?>>Yes</option>
                              	<option value="No" <?php echo("No"== $edata->furnishes)?"selected":"" ?>>No</option>
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
                              	<option value="Yes" <?php echo("Yes"== $edata->garden)?"selected":"" ?>>Yes</option>
                              	<option value="No" <?php echo("No"== $edata->garden)?"selected":"" ?>>No</option>
                              	</select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="other">Other<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" name="other" id="other" placeholder="" value="{{ $edata->others }}">
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
<script type="text/javascript">
$(document).ready(function(){
	var section = $('#section').val();
	if(section == 1){
		$('#step-1').hide();
		$('#step-2').show();
	}

	if(section == 2){
		$('#step-1').hide();
		$('#step-2').hide();
		$('#step-3').show();
	}

	if(section == 3){
		$('#step-1').hide();
		$('#step-2').hide();
		$('#step-3').hide();
		$('#step-4').show();
	}

	$('#submit1').click(function(){

		$("#addform_1").validate({
			rules:{
				name: 'required',
				property_type:
				{
					required:true
				},
				show_as:
				{
					required:true
				},
				state:'required',
				city: 'required',
				landmark:'required',
				age:'required',
				total_floors:'required',
				floor_no:'required',
			},
			
		});
	});
	$('#submit2').click(function(){

		$("#form_2").validate({
			rules:{
				per_square_feet:'required',
				total_square_feet:'required',
				carpet_area:'required',
				usable_area:'required',
				total_rate:'required',
				
				negotiable:
				{
					required:true
				},
			},
			
		});
	});

	$('#submit3').click(function(){

		$("#form_3").validate({
			rules:{
				advance_deposit:'required',
				rent_per_month:'required',
				maintenance:'required'
			},
			
		});
	});

	$('#submit4').click(function(){

		$("#form_4").validate({
			rules:{
				parking:'required',
				gym:'required',
				furnishes:'required',
				garden:'required',
				other:'required'
			}
			
		});
	});
	$('.buttonPrevious').click(function(){

	var x = document.referrer;
	//alert(x);
	document.location.href= x;
	});
});


  
  

</script>