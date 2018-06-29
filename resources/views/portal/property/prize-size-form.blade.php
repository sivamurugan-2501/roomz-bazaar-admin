<div id="step-3" style="display:none;">
  <form class="form-horizontal form-label-left" method="post" action="{{route('add-edit-property-handler')}}" name="form_3" id="form_3">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="step" id="step" value="2">
     @if(isset($id) && is_numeric($id))
      <input type="hidden" name="id" value= {{$id}}>
     @endif
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_builtUp">{{ __('property.label_areaBuiltUp') }}<span class="required">*</span>
        </label>
        <div class="col-md-1 col-sm-6 col-xs-12">
          <input type="text" class="form-control" name="area_builtUp" id="area_builtUp" placeholder="0" value = '{{ (isset($propertyInstance->usable_area) && $propertyInstance->usable_area!=="" ) ? $propertyInstance->usable_area : "" }}'>
        </div>
        <div class="col-md-1 col-sm-6 col-xs-12" style="padding: 6px 0;">
          <span>SQ FT</span>
        </div>
        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="area_carpet">{{ __('property.label_areaCarpet') }}<span class="required">*</span>
        </label>
        <div class="col-md-1 col-sm-6 col-xs-12">
          <input type="text" class="form-control" name="area_carpet" id="area_carpet" placeholder="0" value = '{{ (isset($propertyInstance->carpet_area) && $propertyInstance->carpet_area!=="" ) ? $propertyInstance->carpet_area : "" }}'>
        </div>
        <div class="col-md-1 col-sm-6 col-xs-12" style="padding: 6px 0;">
          <span>SQ FT</span>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_builtUp">{{ __('property.label_supAreaBuiltUp') }}<span class="required">*</span>
        </label>
        <div class="col-md-1 col-sm-6 col-xs-12">
          <input type="text" class="form-control" name="super_area_builtUp" id="super_area_builtUp" placeholder="0" value = '{{ (isset($propertyInstance->super_area_builtUp) && $propertyInstance->super_area_builtUp!=="" ) ? $propertyInstance->super_area_builtUp : "" }}'>
        </div>
        <div class="col-md-1 col-sm-6 col-xs-12" style="padding: 6px 0;">
          <span>SQ FT</span>
        </div>
    </div>

     <div class="form-group toggle_features" show-on="sales">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="include_stampduty_charge">Include  Stamp Duty Charges<span class="required">*</span>
        </label>
         <div class="col-md-6 col-sm-6 col-xs-12" style="padding:8px">
          <input type="checkbox" class="flat" name="include_stampduty_charge" id="include_stampduty_charge" class="form-control" value=1>
        </div>
      </div>



    <div class="form-group toggle_features" show-on='sales'>
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expected_price">{{ __('property.label_expectedPrice') }}<span class="required">*</span>
        </label>
        <div class="col-md-2 col-sm-6 col-xs-12 form-group has-feedback">
          <input type="text" class="form-control has-feedback-left" name="expected_price" id="expected_price" placeholder="0" value = '{{ (isset($propertyInstance->total_rate) && $propertyInstance->total_rate!=="" ) ? $propertyInstance->total_rate : "" }}'>
          <span class="fa fa-inr form-control-feedback left" aria-hidden="true"></span>
        </div>
        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="other_charges">{{ __('property.label_otherCharges') }}<span class="required">*</span>
        </label>
        <div class="col-md-2 col-sm-6 col-xs-12  form-group has-feedback">
          <input type="text" class="form-control has-feedback-left" name="other_charges" id="other_charges" placeholder="0" value = '{{ (isset($propertyInstance->other_charges) && $propertyInstance->other_charges!=="" ) ? $propertyInstance->other_charges : "" }}'>
          <span class="fa fa-inr form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>

     <div class="form-group toggle_features"  show-on='pg,rent'>
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="advance_deposit">{{ __('property.label_advance') }}<span class="required">*</span>
        </label>
        <div class="col-md-2 col-sm-6 col-xs-12 form-group has-feedback">
          <input type="text" class="form-control has-feedback-left" name="advance_deposit" id="advance_deposit" placeholder="0" value = '{{ (isset($propertyInstance->advance_deposit) && $propertyInstance->advance_deposit!=="" ) ? $propertyInstance->advance_deposit : "" }}'>
          <span class="fa fa-inr form-control-feedback left" aria-hidden="true"></span>
        </div>
        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="rent">{{ __('property.label_rent') }}<span class="required">*</span>
        </label>
        <div class="col-md-2 col-sm-6 col-xs-12  form-group has-feedback">
          <input type="text" class="form-control has-feedback-left" name="rent" id="rent" placeholder="0" value = '{{ (isset($propertyInstance->rent) && $propertyInstance->rent!=="" ) ? $propertyInstance->rent : "" }}'>
          <span class="fa fa-inr form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>
    <div class="form-group toggle_features" show-on='pg,rent'>
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="maintenance">Include Maintenance<span class="required">*</span>
      </label>
      <div class="col-md-2 col-sm-6 col-xs-12">
        	<input type="radio" class="flat" name="includes_maintenance" id="maintenance_yes" value=1  <?php echo ((isset($propertyInstance->includes_maintenance) && $propertyInstance->includes_maintenance==1 ) ? "checked" : ""  ) ?> > Yes
          <input type="radio" class="flat" name="includes_maintenance" id="maintenance_no" value=0  <?php echo (( isset($propertyInstance) && $propertyInstance->includes_maintenance==0 ) ? "checked" : "" ) ?> > No
      </div>
    </div>

     <div class="form-group" id="maintenance_charge_div">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="maintenance_charge">{{__('property.label_maintenance_charge') }}<span class="required">*</span>
        </label>
        <div class="col-md-2 col-sm-6 col-xs-12">
          <input type="text" class="form-control has-feedback-left" name="maintenance_charge" id="maintenance_charge" placeholder="0" value = '{{ (isset($propertyInstance->maintenance_charge) && $propertyInstance->maintenance_charge!=="" ) ? $propertyInstance->maintenance_charge : "" }}'>
          <span class="fa fa-inr form-control-feedback left" aria-hidden="true"></span>
        </div>
    </div>

    <div class="form-group toggle_featuress" show-ons='sales'>
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="maintenance">Negotiable<span class="required">*</span>
      </label>
       <div class="col-md-6 col-sm-6 col-xs-12" style="padding:8px">
        <input type="checkbox" class="flat" name="negotiable" id="negotiable" class="form-control" value=1 <?php echo ((isset($propertyInstance->negotiable) && $propertyInstance->negotiable==1 ) ? "checked" : ""  ) ?> >
      </div>
    </div>

       <input type="submit" name="submit3" id="submit3" class="btn btn-success" value="Save">
       <div class="buttonFinish buttonDisabled btn btn-default">Next</div>
    	<div class="buttonPrevious buttonDisabled btn btn-primary">Previous</div>
  </form>
</div>