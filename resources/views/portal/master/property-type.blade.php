<?php 
  $list_propertyType = App\MasterPropertyType::where("status",1)->orderBy("name","asc")->get();
  $parentTypes = App\MasterPropertyType::onlyParents();

  //$list_propertyType_json = "";
  $updateId =  0 ;
  $updateData = [];
  $showForm = "none";
  $className = "col-md-12";

  $formActionURL = route("add-property-type-do");

  if(isset($id) && $id>0){
      $updateId = $id;
      $showForm = "";
      $className = "col-md-6";
      $formActionURL = route("update-property-type-do");
  }elseif(isset($mode) && $mode==1){
      $showForm = "";
      $className = "col-md-6";
      $formActionURL = route("add-property-type-do");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="{{config('constants.baseURL')}}">    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <title>{{$pageTitle}}</title>

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

     <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
    .error{
      color:red;
    }
    </style>

    <!-- Custom Theme Style created by Siva -->
     <link href="style.css" rel="stylesheet">`
  </head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        @include("portal.includes.left_menu")
        @include("portal.includes.header")
        <!-- page content -->
         <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Property Type</h3>
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>

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
                          <th>Type</th>
                          <th>Show as</th>
                          <th>Parent</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($list_propertyType as $eachRow)
                          @if($eachRow->id == $updateId)
                            <?php
                              $updateData["name"] = $eachRow->name;
                              $updateData["parent"] = $eachRow->parent;
                              $updateData["is_parent"] = $eachRow->is_parent;
                            ?>
                          @endif
                          <tr>
                          <td>{{$eachRow->name}}</td>
                          <td>
                            @if($eachRow->is_parent ==1)
                              Parent
                            @else
                              Sub Type
                            @endif
                          </td>
                          <td>
                            @if($eachRow->is_parent ==1)
                              -
                            @else
                              {{ (isset($parentTypes[$eachRow->parent])) ? $parentTypes[$eachRow->parent] : "-" }}
                            @endif
                          </td>
                          <td>
                            <a href={{route("update-property-type",["id"=>$eachRow->id])}}> 
                              <i class="fa fa-pencil">&nbsp;</i>
                            </a>
                            <a href={{route("update-property-type",["id"=>$eachRow->id])}}> 
                              <i class="fa fa-trash-o">&nbsp;</i>
                            </a>

                          </td>
                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                  </div>
                  <a href={{route("add-property-type",["mode"=>"1"])}} class="btn btn-primary">Add</a>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xs-12" style="display:{{$showForm}}">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Master<small>Property Type</small></h2>
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
                    <form class="form-horizontal form-label-left input_mask" id="property-type" action={{$formActionURL}} method="post">
                      <!-- if id (number) is present in the url, form will displayed in edit mode with  -->
                      @if(isset($id) && $id >0)
                        <input type="hidden" name="id" value="{{$id}}">
                      @endif
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="name" id="name" placeholder="Property type" value='{{(isset($updateData["name"])) ?  $updateData["name"] : "" }}'>
                        </div>
                      </div>
                      <div class="form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12">Mark as parent</label>
                        <div class="checkbox">
                              <label>
                                <input type="checkbox" class="flat" name="is_parent" id="is_parent" value=1
                                {{ (isset($updateData['is_parent']) && $updateData['is_parent']==1) ? "checked" : "" }}
                                > 
                              </label>
                        </div>
                      </div>

                      <div class="form-group" style="display: {{ (isset($updateData['is_parent']) && $updateData['is_parent']==1) ? "none" : '' }}">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Parent</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="parent" id="parent">
                            <option>Choose option</option>
                            @foreach($parentTypes as $id => $name)
                                <option value={{$id}}>{{$name}}</option>
                            @endforeach 
                          </select>
                        </div>
                      </div>
                      
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

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
  
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
  </body>
</html>
  

<script type="text/javascript" src="{!! asset('js/script.js') !!}"></script>
  
  

