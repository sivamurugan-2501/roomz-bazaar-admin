<?php 
    use  App\MasterPropertyType;
    use  App\GeneralInfo;
    use  App\Amenities;
    $propertyTypeList =  App\MasterPropertyType::groupByType();
    $stateList = App\State::all();
    $amenitiesList = App\Amenities::where("status",1)->get();
   

    $propertyFor = array(1=>"PG","Sale","Rent");
    $id = Request::route('id');
    $step = Request::route('step');

    $propertyInstance = false;
    $amenitiesSelected = [];
    if(isset($id) && is_numeric($id)){
      $propertyInstance= App\GeneralInfo::get($id);
      if(isset($propertyInstance->amenities)){
          try{
              $amenitiesSelected = $propertyInstance->amenities;
              $amenitiesSelected = json_decode($amenitiesSelected);
          }catch(Exception $e){}
      }
    }
    

   if(isset($_GET['section'])){
   	$section = $_GET['section'];
   }else{
   	$section = 0;
   }

   $classDisabled =  "disabled";
   $classEnabled = "selected"; 
   $classHidden = "hide";

   $parentNames =[];
   $posession_year_range = config('constants.settings_posession_year');
   $posession_year_limit = (int)date('Y') + (int)$posession_year_range;
   $currentYear = (int)date('Y');
  
?>
@extends('layouts.listing')

@section("pageTitle")
  {{__("Add property")}}
@endsection
@section('additional_css_files')
     <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <style type="text/css">
    .error{
    	color:red;
    }
    .button-selector button{
        margin-left: -3px !important;
        margin-right: 0 !important;
        border-radius: 3px;
        width: 28px;
    }

    .button-selector button.selected{
      margin-left: -3px !important;
      margin-right: 0 !important;
      background: #ed5565;
      border: 1px solid #ed5565;
      color: wheat;
      border-radius: 3px;
      border-left: 1px solid #fff;
    }
    
    </style>
    <!-- Custom Theme Style created by Siva -->
     <link href="style.css" rel="stylesheet">`
@endsection

@if(!isset($id) || !is_numeric($id))

<style>
.actionBar{
      display: none !important;
    }
</style>
@endif


@section('content')
        <!-- page content -->
        
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Add Property</h3>
              </div>
             
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                @if(session("action_message"))
                     <div class="alert alert-success alert-dismissible fade in" role="alert">
                        {{ session('action_message') }}
                    </div>
                @endif
                <div class="x_panel">
                  
                  <div class="x_content">
                   
                    <div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="wizard_steps">
                        <li>
                          <a href="#step-1" class={{$classEnabled}}>
                            <span class="step_no">1</span>
                            <span class="step_descr">
                                  {{__('property.label_tab_1')}}<br />
                                  <small>Start with basic</small>
                              </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-2" class={{$classDisabled}}>
                            <span class="step_no">2</span>
                            <span class="step_descr">
                                Location<br />
                                <small></small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-3" class={{$classDisabled}}>
                            <span class="step_no">3</span>
                            <span class="step_descr">
                                Price & Size<br />
                                <small></small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-4" class={{$classDisabled}}>
                            <span class="step_no">4</span>
                            <span class="step_descr">
                                Amenities<br />
                                <small>Amenities</small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-4" class={{$classDisabled}}>
                            <span class="step_no">4</span>
                            <span class="step_descr">
                                {{__('property.label_tab_5')}}<br />
                                <small>Amenities</small>
                            </span>
                          </a>
                        </li>
                      </ul>

                      @include("portal.property.general-info-form")
                      @include("portal.property.location-form")
                      @include("portal.property.prize-size-form")
                      @include("portal.property.amenities-form")
                       

                    </div>
                    <!-- End SmartWizard Content -->
                  </div>
                </div>
              </div>
            </div>
          </div>
     @endsection  

   @section("footer_page_scripts")
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

    <script src="vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- Custom Theme Scripts -->

    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!--script src="build/js/custom.min.js"></script-->
    
    <script type="text/javascript" src="{!! asset('js/script.js') !!}"></script>
	   <script>

        $("input").on("ifClicked", function(){
            alert("maintenance_no sdsd");
        });
       
        $(document).ready(function(){
          
        });

        $('#wizard').smartWizard({
            // Properties
              selected: {{ (isset($step) ? $step : 0) }},  // Selected Step, 0 = first step   
              keyNavigation: true, // Enable/Disable key navigation(left and right keys are used if enabled)
              enableAllSteps: false,  // Enable/Disable all steps on first load
              transitionEffect: 'fade', // Effect on navigation, none/fade/slide/slideleft
              contentURL:null, // specifying content url enables ajax content loading
              contentURLData:null, // override ajax query parameters
              contentCache:true, // cache step contents, if false content is fetched always from ajax url
              cycleSteps: false, // cycle step navigation
              enableFinishButton: false, // makes finish button enabled always
              hideButtonsOnDisabled: true, // when the previous/next/finish buttons are disabled, hide them instead
              errorSteps:[],    // array of step numbers to highlighting as error steps
              labelNext: "Next", // label for Next button
              labelPrevious:'Previous', // label for Previous button
              labelFinish:'Finish',  // label for Finish button        
              noForwardJumping:false,
              ajaxType: 'POST',
              // Events
              onLeaveStep: null, // triggers when leaving a step
              onShowStep: null,  // triggers when showing a step
              onFinish: null,  // triggers when Finish button is clicked  
              buttonOrder: [] //['finish', 'next', 'prev']  // button order, to hide a button remove it from the list
          }); 
        
        $(".stepContainer").removeAttr("style").css("overflow-x","unset");

        @if(isset($propertyInstance->state) && $propertyInstance->state>0)
          fill_city({{$propertyInstance->city}});
        @endif

        @if(isset($propertyInstance->transaction_type))
          transaction_type_action({{$propertyInstance->transaction_type}}, 1);
        @endif

         @if(isset($propertyInstance->possession_type))
          possession_type_action({{$propertyInstance->possession_type}}, 1);
        @endif

        @if(isset($propertyInstance->show_as))
          toggle_features('{{$propertyInstance->show_as}}');
        @endif
     </script>
      
  @endsection
  

