<?php 
  $list_amenities = App\Amenities::where("status",1)->orderBy("name","asc")->get();
  
  //$list_amenities_json = "";
  $updateId =  0 ;
  $updateData = [];
  $showForm = "none";
  $className = "col-md-12";

  $formActionURL = route("add-master-amenities-do");
  
  if(isset($id) && $id>0){
      $updateId = $id;
      $showForm = "";
      $className = "col-md-6";
      $formActionURL = route("update-master-amenities-do");
  }elseif(isset($mode) && $mode==1){
      $showForm = "";
      $className = "col-md-6";
      $formActionURL = route("add-master-amenities-do");
  }
  $errorMessages = [];
  foreach($errors->all() as $key=>$error){
      //echo $key. " = ". $error;
      $errorMessages[$key] = $error; 
  }
?>

@extends('layouts.listing')

@section("pageTitle")
  {{__("amenities.title")}}
@endsection


@section('additional_css_files')
     <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
    .error{
      color:#E85445;
    }

    input.error{
        background: #FAEDEC;
        border: 1px solid #E85445;
    }
    </style>
    <!-- Custom Theme Style created by Siva -->
     <link href="style.css" rel="stylesheet">`
@endsection('additional_css_files')
@section('content')
          <div class="row">

            <div class="{{$className}} col-sm-12 col-xs-12">
              @if(session("action_message"))
                   <div class="alert alert-success alert-dismissible fade in" role="alert">
                      {{ session('action_message') }}
                  </div>
              @endif
              <div class="x_panel">
              <div class="x_content">
                <div class="card-box table-responsive">
                  <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Icon</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($list_amenities as $eachRow)
                        @if($eachRow->id == $updateId)
                          <?php
                            $updateData["name"] = $eachRow->name;
                            $updateData["icon_path"] = $eachRow->icon_path;
                          ?>
                        @endif
                        <tr>
                        <td>{{$eachRow->name}}</td>
                        <td>
                          -
                        </td>
                        <td>
                          <a href={{route("update-master-amenities",["id"=>$eachRow->id])}}> 
                            <i class="fa fa-pencil">&nbsp;</i>
                          </a>
                          <a href={{route("update-master-amenities",["id"=>$eachRow->id])}}> 
                            <i class="fa fa-trash-o">&nbsp;</i>
                          </a>

                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div>
                <a href={{route("add-master-amenities",["mode"=>"1"])}} class="btn btn-primary">Add</a>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xs-12" style="display:{{$showForm}}">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Master<small>{{__("amenities.title")}}</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <form class="form-horizontal form-label-left input_mask" id="amenitiesForm" action={{$formActionURL}} method="post" enctype="multipart/form-data">
                    <!-- if id (number) is present in the url, form will displayed in edit mode with  -->
                    @if(isset($id) && $id >0)
                      <input type="hidden" name="id" value="{{$id}}">
                    @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group item">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Ex. Gym" value='{{(isset($updateData["name"])) ?  $updateData["name"] : "" }}' {{ ($showForm!="none") ? "autofocus" : "" }} >
                      </div>
                    </div>
                     @foreach ($errors->get('name') as $message)
                    <div class="form-group item">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;</label>
                      <div class="col-md-9 col-sm-9 col-xs-12 error">
                        {{$message}}

                      </div>
                    </div>
                    <?php break; ?>}
                    @endforeach
                   
                    <div class="form-group">
                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Set Icon</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                             
                              <input type="file" class="form-control" name="icon_path" id="icon_path" placeholder="File Upload" value='{{(isset($updateData["icon_path"])) ?  $updateData["icon_path"] : "" }}'>
                      </div>
                    </div>
                      @foreach ($errors->get('icon_path') as $message) {
                    <div class="form-group item">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;</label>
                      <div class="col-md-9 col-sm-9 col-xs-12 error">
                        {{$message}}

                      </div>
                    </div>
                    <?php break; ?>}
                    @endforeach
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="button" class="btn btn-primary">Cancel</button>
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
            </div>
          </div>
@endsection
@section("footer_page_scripts")
     <script src="vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
     <script>
        $("#is_parent").click(function(){
          status = $(this).is(":checked");
          console.log("is parent : "+status);
        });

        $('#is_parent').on('ifChanged', function(){
          status = $(this).is(":checked");
          //alert(status);
          if(status == "true"){
              $("#parent").closest(".form-group").hide();
          }else{
              document.getElementById("parent").options[0].selected="selected";
              $("#parent").closest(".form-group").show();
          }
          
        });
    </script>
    <script type="text/javascript" src="{!! asset('js/script.js') !!}"></script>
@endsection


  
  

