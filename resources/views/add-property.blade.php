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

	   <script>

        $("input").on("ifClicked", function(){
            alert("maintenance_no sdsd");
        });
        /*click(function(){
          console.log("maintenance_no clicked.....")
            alert($(this).val());
        }); */


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
            hideButtonsOnDisabled: false, // when the previous/next/finish buttons are disabled, hide them instead
            errorSteps:[],    // array of step numbers to highlighting as error steps
            labelNext:'Next', // label for Next button
            labelPrevious:'Previous', // label for Previous button
            labelFinish:'Finish',  // label for Finish button        
            noForwardJumping:false,
            ajaxType: 'POST',
            // Events
            onLeaveStep: null, // triggers when leaving a step
            onShowStep: null,  // triggers when showing a step
            onFinish: null,  // triggers when Finish button is clicked  
            buttonOrder: ['finish', 'next', 'prev']  // button order, to hide a button remove it from the list
        }); 


        $("input[name='transaction_type']").click(function(event){
            checked = $(this).is(":checked");
            if(checked == true){

                value = $(this).val();
                value = parseInt(value);
                alert("here... "+value);
                transaction_type_action(value);
            }
        });

        $("input[name='possession_type']").click(function(event){
            checked = $(this).is(":checked");
            if(checked == true){
                value = $(this).val();
                 value = parseInt(value);
               possession_type_action(value);
            }
        });

        function transaction_type_action(value,reset){
          if(value == 1){
            $("#possession_year_div").addClass("hide");
            $("#age_div").addClass("hide");
            $("#possession_type_div").removeClass("hide");
            if(reset===undefined || reset==0)
            $("input[name='possession_type']").removeAttr("checked");
          }else if(value==2){
            $("#possession_year_div").addClass("hide");
            $("#possession_type_div").addClass("hide");
            $("#age_div").removeClass("hide");
            if(reset===undefined || reset==0)
            $("#age").val("");
          }
        }

        function possession_type_action(value,reset){
              if(value==1){
                  $("#possession_year_div").removeClass("hide");
                  if(reset===undefined || reset==0)
                  document.getElementById("possession_year").options[0].selected = "selected";
              }else{
                  $("#possession_year_div").addClass("hide");
              }
        }

        function move_wizard(step){
            if(step!==undefined && step!==""){

            }
        }

        function fill_city(cityId){
          stateSelected = $("#state").val();
          stateSelected = parseInt(stateSelected);
          $.ajax({
             url : "../ajax/cities/"+stateSelected,
             method : "POST",
             data : {"_token": "{{ csrf_token() }}"},
             success :  function(response,status){
                if(response!==undefined){
                    
                    response = JSON.parse(response);
                    console.log("response : "+response);
                    $("#city").find("option").not(':eq(0)').remove();
                    $(response).each(function(key,cityObj){
                        console.log("city : "+cityObj.city_name );
                        optionTag = document.createElement("option");
                        optionTag.value = cityObj.city_id;
                        optionTag.innerHTML = cityObj.city_name;
                        if(cityId!=="" && cityId>0){
                            optionTag.selected = "selected";
                        }
                        $("#city").append(optionTag);
                    });
                }
             }
          });
        }
        var showOn;
        function toggle_features(show_as){
            $("div.toggle_features").hide();
            divs =  $("div.toggle_features");
            console.log("show_as : "+show_as)
            if(show_as!==undefined && show_as!==""){
              show_as = show_as.toLowerCase();
              $(divs).each(function(key, elem){
                  showOn = $(elem).attr("show-on");
                  console.log("show on : "+showOn);
                  if(showOn!==undefined){
                      splitShowOn = showOn.split(",");
                      $(splitShowOn).each(function(ind,value){
                          if(value == show_as){
                              $(elem).show();
                          }
                      });
                  }
              });
            }
        }

        $("#state").change(function(){
            fill_city(0);
        });

        $("#show_as").change(function(){
            selectedVal = $(this).val();
            toggle_features(selectedVal);
        });

        $(".button-selector button").click(function(){
            isSelected = $(this).hasClass("selected");
            if(isSelected == false){
                closestOuter = $(this).closest("div.button-selector");
                allButtons = $(closestOuter).find("button");
                $(allButtons).removeClass("selected");
                bindTo = $(this).attr("bind-to");
                $(this).addClass("selected");
                $("#"+bindTo).val($(this).val());
            }
        });

        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
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
      <script type="text/javascript" src="{!! asset('js/script.js') !!}"></script>
  @endsection
  

