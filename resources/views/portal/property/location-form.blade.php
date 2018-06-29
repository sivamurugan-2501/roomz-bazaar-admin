<div id="step-2" style="display: none;">
  <form class="form-horizontal form-label-left" method="post" action="{{route('add-edit-property-handler')}}" name="form_2" id="form_2">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="step" id="step" value=1>
  @if(isset($id) && is_numeric($id))
    <input type="hidden" name="id" value= {{$id}}>
  @endif
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address<span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="dropdown3">
          <textarea name="address" id="address" class="form-control" id="address">{{( 
            isset($propertyInstance->address) && $propertyInstance->address!=="" ) ? $propertyInstance->address : ""}}</textarea>
        </div>
      </div>
    </div>

     <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state">State<span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="dropdown3">
         
          <select id="state" name="state" class="form-control">
             <option value="0">Select State</option>
              @foreach($stateList as $eachState)
              <option value=" {{$eachState->state_id}} " {{ (isset($propertyInstance->state) && strtolower($propertyInstance->state) == $eachState->state_id) ? "selected" : " " }}>{{$eachState->state_name}}</option>
              @endforeach
          </select>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City<span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="dropdown3">
          <select id="city" name="city" class="form-control">
             <option value="0">Select City</option>
          </select>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="landmark">Landmark<span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="dropdown3">
          <input type="text" name="landmark" id="landmark" class="form-control" value={{( 
            isset($propertyInstance->landmark) && $propertyInstance->landmark!=="" && $propertyInstance->landmark!=="-" ) ? $propertyInstance->landmark : ""}}>
        </div>
      </div>
    </div>
     <input type="submit" name="submit2" id="submit2" class="btn btn-success" value="Save">
     <div class="buttonFinish buttonDisabled btn btn-default">Next</div>
     <div class="buttonPrevious buttonDisabled btn btn-primary">Previous</div>
    </form>
</div>