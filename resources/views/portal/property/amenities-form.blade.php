
<div id="step-4" style="display: none;">

  <form class="form-horizontal form-label-left" method="post" action="{{route('add-edit-property-handler')}}" name="pro_amenities_form" id="pro_amenities_form">
  <div class="form-group">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  @if(isset($id) && is_numeric($id))
  <input type="hidden" name="id" value= {{$id}}>
  @endif
  <input type="hidden" name="step" id="step" value="3">
        @foreach ($errors->get('amenities') as $message)
        <div class="col-md-3 col-sm-3 col-xs-3">&nbsp;</div>
        <div class="col-md-10 col-sm-9 col-xs-9">
          <div class="alert alert-danger alert-dismissible fade in" role="alert">
              {{$message}}
          </div>
        </div>
        <?php break; ?>}
       @endforeach
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parking">Select Amenities<span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
      	 @foreach($amenitiesList as $amenitiesObj)
         <div class="col-md-6 col-sm-12 col-xs-12">
         <div class="checkbox">
          <label>
            <input type="checkbox" class="flat" name="amenities[]" value='{{$amenitiesObj->id}}'  {{ ( in_array( $amenitiesObj->id,$amenitiesSelected) ) ? "checked" : "" }}> {{$amenitiesObj->name}} 
          </label>
         </div>
        </div>
         @endforeach
      </div>
    </div>
    
     <input type="submit" name="submit4" id="submit4" class="btn btn-success" value="Save">
     <div class="buttonFinish buttonDisabled btn btn-default">Next</div>
     <div class="buttonPrevious buttonDisabled btn btn-primary">Previous</div>
    </form>
</div>