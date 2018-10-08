 <div id="step-1" >
<form class="form-horizontal form-label-left" action="{{route('add-edit-property-handler')}}" method="post" id="addform_1" name="addform_1">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="step" value=1>
@if(isset($id) && is_numeric($id))
<input type="hidden" name="id" value= {{$id}}>
@endif
<input type="hidden" name="step" id="step" value="0">

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
  {{__('property.label_name')}}
  <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
  <input type="text" class="form-control" name="name" id="name" placeholder="" value = '{{ (isset($propertyInstance->name) && $propertyInstance->label_name!=="" ) ? $propertyInstance->name : "" }}' >
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="show_as">Property For<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="dropdown2">
    <select name="show_as" id="show_as" class="form-control">
    <option value="">--Select type--</option>
    <option value="Sales" {{ (isset($propertyInstance->show_as) && strtolower($propertyInstance->show_as) == "sales") ? "selected" : " " }} >Sales</option>
    <option value="Rent" {{ (isset($propertyInstance->show_as) && strtolower($propertyInstance->show_as) == "rent") ? "selected" : " " }}>Rent</option>
    <option value="PG" {{ (isset($propertyInstance->show_as) && strtolower($propertyInstance->show_as) == "pg") ? "selected" : " " }}>PG</option>
    </select>
  </div>
</div>
</div>
<div class="form-group toggle_features" show-on="pg">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">PG For Gender<span class="required">*</span>
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
     <div class="checkbox">
      <label for="for_gender1">
        <input type="radio" class="flat" name="for_gender" id="for_gender1" value='0' checked> All
      </label>
      <label for="for_gender2">
        <input type="radio" class="flat" name="for_gender" id="for_gender2" value='1'> Male
      </label>
       <label for="for_gender3">
        <input type="radio" class="flat" name="for_gender" id="for_gender3" value='2'> FeMale
      </label>
   </div>
  </div>
</div>
<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="property_type">Property Type<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="dropdown">
  	<select name="property_type" id="property_type" class="form-control">
  	<option value="">--Select property type--</option>
    @foreach($propertyTypeList as $eachList)
        @if(!in_array($eachList->parent_name,$parentNames))
          <optgroup label='{{$eachList->parent_name}}'>
        @endif
          <option value={{$eachList->id}}  {{ (isset($propertyInstance->property_type) && strtolower($propertyInstance->property_type) == $eachList->id) ? "selected" : " " }}>{{$eachList->name}}</option>
        @if(!in_array($eachList->parent_name,$parentNames))
          </optgroup>
        @else
          <?php $parentNames[$eachList->parent_name] = $eachList->parent_name; ?>
        @endif
    @endforeach
  	</select>
  </div>
</div>
</div>


<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="total_floors">Total Floors<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="dropdown3">
  	<input type="text" name="total_floors" id="total_floors" class="form-control" value = {{ (isset($propertyInstance->total_floors) && $propertyInstance->total_floors!=="" ) ? $propertyInstance->total_floors : "" }} >
  </div>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="floor_no">Floor No<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="dropdown3">
  	<input type="text" name="floor_no" id="floor_no" class="form-control" value = {{ (isset($propertyInstance->floor_no) && $propertyInstance->floor_no!=="" ) ? $propertyInstance->floor_no : "" }}>
  </div>
</div>
</div>
<div> &nbsp; </div>
<div class="form-group">
<label class="control-label col-md-2 col-sm-2 col-xs-12" for="age">
</label>
<div class="col-md-7 col-sm-7  col-xs-12">
    <div class="x_title">
      <h2><i class="fa fa-folder-o">&nbsp;</i>Property Features</h2>
      <div class="clearfix"></div>
   </div>
</div>
</div>

<div class="form-group toggle_features"  show-on="sales,rent">
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Transaction Type</label>
<div class="checkbox">
      <label>
        <input type="radio" class="flat" name="transaction_type" id="" value=1 required {{ (isset($propertyInstance->transaction_type) && strtolower($propertyInstance->transaction_type) == "1") ? "checked" : " " }}>
        New 
      </label>
       <label>
        <input type="radio" class="flat" name="transaction_type" id="" value=2 required {{ (isset($propertyInstance->transaction_type) && strtolower($propertyInstance->transaction_type) == "2") ? "checked" : " " }}>
        Resale 
      </label>
</div>
</div>

<div class="form-group tt_new_option hide toggle_features"  show-on="sales,rent" id="possession_type_div">
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Possession</label>
<div class="checkbox">
      <label>
        <input type="radio" class="flat" name="possession_type" id="" value=1 {{ (isset($propertyInstance->possession_type) && strtolower($propertyInstance->possession_type) == "1") ? "checked" : " " }}>
        Under Construction 
      </label>
       <label>
        <input type="radio" class="flat" name="possession_type" id="" value=2 {{ (isset($propertyInstance->possession_type) && strtolower($propertyInstance->possession_type) == "2") ? "checked" : " " }}>
        Ready to move 
      </label>
</div>
</div>

<!-- show if possession_type is ready_to_move -->
<div class="form-group hide toggle_features"  show-on="sales,rent,pg" id="age_div">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age">Age<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="dropdown3">
    <input type="text" name="age" id="age" class="form-control" {{ (isset($propertyInstance->age) && $propertyInstance->age!=="" ) ? $propertyInstance->age : "" }}>
  </div>
</div>
</div>

<!-- show if possession_type is under construction -->
<div class="form-group hide" id="possession_year_div">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="property_type">Possession Year<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="dropdown">
    <select name="possession_year" id="possession_year" class="form-control">
    <option value="">--Select Year--</option>
    @while($currentYear <= $posession_year_limit)
        <option value= {{$currentYear}}  {{ (isset($propertyInstance->possession_year) && strtolower($propertyInstance->possession_year) == $currentYear) ? "selected" : " " }}>{{$currentYear}}</option>
        <?php $currentYear++; ?>
    @endwhile
    </select>
  </div>
</div>
</div>

<div class="form-group" id="no_of_bedrooms_box">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="property_type">No of bedroom(s)<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="dropdown button-selector">
    @for($i=0;$i<=10;$i++)
      <button type="button" bind-to="no_of_bedrooms" value={{$i}}  class='{{ ((isset($propertyInstance->no_of_bedroom) && $propertyInstance->no_of_bedroom == $i ) ? "selected" : "") }}' >{{$i}}</button>
    @endfor
    <input type="hidden" name="no_of_bedrooms" id="no_of_bedrooms" value={{ (isset($propertyInstance->no_of_bedroom) ? $propertyInstance->no_of_bedroom : 0) }}> 
  </div>
</div>
</div>

<div class="form-group" id="no_of_bathrooms_box">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="property_type">No of bathroom(s)<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="dropdown button-selector">
    @for($i=0;$i<=10;$i++)
      <button type="button" bind-to="no_of_bathrooms" value={{$i}} class='{{ ((isset($propertyInstance->no_of_bathroom) && $propertyInstance->no_of_bathroom == $i ) ? "selected" : "") }}'>{{$i}}</button>
    @endfor
    <input type="hidden" name="no_of_bathrooms" id="no_of_bathrooms" value={{ (isset($propertyInstance->no_of_bathroom) ? $propertyInstance->no_of_bathroom : 0) }}>
  </div>
</div>
</div>

<div class="form-group" id="no_of_balacony_box">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="property_type">No of Balconies(s)<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="dropdown button-selector">
    @for($i=0;$i<=10;$i++)
      <button type="button" bind-to="no_of_balaconies" value={{$i}} class='{{ ((isset($propertyInstance->no_of_balcony) && $propertyInstance->no_of_balcony == $i ) ? "selected" : "") }}'>{{$i}}</button>
    @endfor
    <input type="hidden" name="no_of_balaconies" id="no_of_balaconies" value={{ (isset($propertyInstance->no_of_balcony) ? $propertyInstance->no_of_balcony : 0) }}>
  </div>
</div>
</div>

<div> &nbsp; </div>
<input type="submit" name="submit" id="submit1" class="btn btn-success" value="Save">
<div class="buttonNext btn btn-success">Next</div-->
<!--  <a href="#" class="buttonNext btn btn-success">Next</a >
<div class="buttonPrevious buttonDisabled btn btn-primary">Previous</div-->

</form>

</div>