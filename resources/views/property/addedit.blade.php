@extends('layouts.listing')
@section('content')
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>
				@if( isset($property['id']) && !empty($property['id']) && is_numeric($property['id']) )
					Edit Property
				@else
					Add Property
				@endif
				</h3>
			</div>	<!-- /.title_left -->
			<div class="title_right text-right">
				<button type="button" value="Back" class="btn btn-default" onclick="window.open('{{ route('property.index') }}','_parent');">Back</button>
			</div>	<!-- /.title_right -->
		</div>	<!-- /.page-title -->
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form action="{{ $property['form_url'] }}" method="POST" class="form-horizontal form-label-left">
							{{ csrf_field() }}
							<div id="wizard" class="form_wizard wizard_horizontal">
								<ul class="wizard_steps">
									<li>
										<a href="#step-1">
											<span class="step_no">1</span>
											<span class="step_descr">
												Basic Info<br /><small>Start with basic</small>
											</span>
										</a>
									</li>
									<li>
										<a href="#step-2">
											<span class="step_no">2</span>
											<span class="step_descr">
												Location<br /><small></small>
											</span>
										</a>
									</li>
									<li>
										<a href="#step-3">
											<span class="step_no">3</span>
											<span class="step_descr">
												Price & Size<br /><small></small>
											</span>
										</a>
									</li>
									<li>
										<a href="#step-4">
											<span class="step_no">4</span>
											<span class="step_descr">
												Amenities<br /><small>Amenities</small>
											</span>
										</a>
									</li>
								</ul>	<!-- /.wizard_steps -->
								<div id="step-1">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Property Name</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" class="form-control" name="name" id="name" maxlength="100" value="{{ $property['name'] }}">
											<label class="error">{{ $errors->first('name') }}</label>
											<input type="hidden" class="form-control" id="id" name="id" value="{{ $property['id'] }}">
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Property Type</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="property_type_id" id="property_type_id">
												<option value="">Select One</option>
											@foreach($property['property_type_arr'] as $property_type)
												@if( $property['property_type_id'] == $property_type->type_id )
													<option value="{{ $property_type->type_id }}" selected>{{ $property_type->type_name }}</option>
												@else
													<option value="{{ $property_type->type_id }}">{{ $property_type->type_name }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('property_type_id') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Show Property As</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="show_as" id="show_as">
												<option value="">Select One</option>
											@foreach($property['show_as_arr'] as $show_as_key => $show_as_value)
												@if( $property['show_as'] == $show_as_key )
													<option value="{{ $show_as_key }}" selected>{{ $show_as_value }}</option>
												@else
													<option value="{{ $show_as_key }}">{{ $show_as_value }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('show_as') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea class="form-control" name="address" id="address" rows="5">{{ $property['address'] }}</textarea>
											<label class="error">{{ $errors->first('address') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="country_id" id="country_id">
												<option value="">Select One</option>
											@foreach($property['country_arr'] as $country_detail)
												@if( $property['country_id'] == $country_detail->country_id )
													<option value="{{ $country_detail->country_id }}" selected>{{ $country_detail->country_name }}</option>
												@else
													<option value="{{ $country_detail->country_id }}">{{ $country_detail->country_name }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('country_id') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="state_id" id="state_id">
												<option value="">Select One</option>
											@foreach($property['state_arr'] as $state_detail)
												@if( $property['state_id'] == $state_detail->state_id )
													<option value="{{ $state_detail->state_id }}" selected>{{ $state_detail->state_name }}</option>
												@else
													<option value="{{ $state_detail->state_id }}">{{ $state_detail->state_name }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('state_id') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="city_id" id="city_id">
												<option value="">Select One</option>
											@foreach($property['city_arr'] as $city_detail)
												@if( $property['city_id'] == $city_detail->city_id )
													<option value="{{ $city_detail->city_id }}" selected>{{ $city_detail->city_name }}</option>
												@else
													<option value="{{ $city_detail->city_id }}">{{ $city_detail->city_name }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('city_id') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Landmark</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" class="form-control" name="landmark" id="landmark" maxlength="191" value="{{ $property['landmark'] }}">
											<label class="error">{{ $errors->first('landmark') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Property Age (in years)</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="number" class="form-control" name="property_age" id="property_age" maxlength="10" value="{{ $property['property_age'] }}" min="0">
											<label class="error">{{ $errors->first('property_age') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">RERA Number(Real Estate Regulatory Authority)</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" class="form-control" name="rera_number" id="rera_number" maxlength="55" value="{{ $property['rera_number'] }}">
											<label class="error">{{ $errors->first('rera_number') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Total Floors</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="number" class="form-control" name="total_floors" id="total_floors" maxlength="10" value="{{ $property['total_floors'] }}" min="0">
											<label class="error">{{ $errors->first('total_floors') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Floor Number</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="number" class="form-control" name="floor_no" id="floor_no" maxlength="10" value="{{ $property['floor_no'] }}" min="0">
											<label class="error">{{ $errors->first('floor_no') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Active</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="checkbox" class="form-control" name="property_status" id="property_status" value="1" {{ $property['property_status_check'] }}>
											<label class="error">{{ $errors->first('property_status') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
								</div>	<!-- #step-1 -->
								<div id="step-2">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Per Square Feet</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="number" class="form-control" name="per_square_feet" id="per_square_feet" maxlength="10" value="{{ $property['per_square_feet'] }}" min="0">
											<label class="error">{{ $errors->first('per_square_feet') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Total Square Feet</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="number" class="form-control" name="total_square_feet" id="total_square_feet" maxlength="10" value="{{ $property['total_square_feet'] }}" min="0">
											<label class="error">{{ $errors->first('total_square_feet') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Carpet Area</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="number" class="form-control" name="carpet_area" id="carpet_area" maxlength="10" value="{{ $property['carpet_area'] }}" min="0">
											<label class="error">{{ $errors->first('carpet_area') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Usable Area</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="number" class="form-control" name="usable_area" id="usable_area" maxlength="10" value="{{ $property['usable_area'] }}" min="0">
											<label class="error">{{ $errors->first('usable_area') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Total Rate</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="number" class="form-control" name="total_rate" id="total_rate" maxlength="10" value="{{ $property['total_rate'] }}" min="0">
											<label class="error">{{ $errors->first('total_rate') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Negotiable</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="negotiable" id="negotiable">
												<option value="">Select One</option>
											@foreach($property['arr_options'] as $option_key => $option_value)
												@if( $property['negotiable'] == $option_key )
													<option value="{{ $option_key }}" selected>{{ $option_value }}</option>
												@else
													<option value="{{ $option_key }}">{{ $option_value }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('negotiable') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
								</div>	<!-- #step-2 -->
								<div id="step-3">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Advance Deposit</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="number" class="form-control" name="advance_deposite" id="advance_deposite" maxlength="10" value="{{ $property['advance_deposite'] }}" min="0">
											<label class="error">{{ $errors->first('advance_deposite') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Rent Per Month</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="number" class="form-control" name="rent_per_month" id="rent_per_month" maxlength="10" value="{{ $property['rent_per_month'] }}" min="0">
											<label class="error">{{ $errors->first('rent_per_month') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Maintenance</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="maintenance_include" id="maintenance_include">
												<option value="">Select One</option>
											@foreach($property['arr_options'] as $option_key => $option_value)
												@if( $property['maintenance_include'] == $option_key )
													<option value="{{ $option_key }}" selected>{{ $option_value }}</option>
												@else
													<option value="{{ $option_key }}">{{ $option_value }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('maintenance_include') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
								</div>	<!-- #step-3 -->
								<div id="step-4">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Parking</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="parking" id="parking">
												<option value="">Select One</option>
											@foreach($property['arr_options'] as $option_key => $option_value)
												@if( $property['parking'] == $option_key )
													<option value="{{ $option_key }}" selected>{{ $option_value }}</option>
												@else
													<option value="{{ $option_key }}">{{ $option_value }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('parking') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Gym</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="gym" id="gym">
												<option value="">Select One</option>
											@foreach($property['arr_options'] as $option_key => $option_value)
												@if( $property['gym'] == $option_key )
													<option value="{{ $option_key }}" selected>{{ $option_value }}</option>
												@else
													<option value="{{ $option_key }}">{{ $option_value }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('gym') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Water Supply</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="water_supply" id="water_supply">
												<option value="">Select One</option>
											@foreach($property['arr_options'] as $option_key => $option_value)
												@if( $property['water_supply'] == $option_key )
													<option value="{{ $option_key }}" selected>{{ $option_value }}</option>
												@else
													<option value="{{ $option_key }}">{{ $option_value }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('water_supply') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Garden</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="garden" id="garden">
												<option value="">Select One</option>
											@foreach($property['arr_options'] as $option_key => $option_value)
												@if( $property['garden'] == $option_key )
													<option value="{{ $option_key }}" selected>{{ $option_value }}</option>
												@else
													<option value="{{ $option_key }}">{{ $option_value }}</option>
												@endif
											@endforeach
											</select>
											<label class="error">{{ $errors->first('garden') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Others</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" class="form-control" name="others" id="others" maxlength="191" value="{{ $property['others'] }}">
											<label class="error">{{ $errors->first('others') }}</label>
										</div>	<!-- /.col-md-6 col-sm-6 col-xs-12 -->
									</div>	<!-- /.form-group -->
								</div>	<!-- #step-4 -->
							</div>	<!-- #wizard -->
						</form>	<!-- /.form -->
					</div>	<!-- /.x_content -->
				</div>	<!-- /.x_panel -->
			</div>	<!-- /.col-md-12 col-sm-12 col-xs-12 -->
		</div>	<!-- /.row -->
	</div>
@endsection('content')
@section('footer_page_scripts')
<script src="vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var notProcessedRequestText = 'Unable to process your request, try again later';
		$("#property_status").bootstrapSwitch({'onText':'Yes', 'offText':'No'});

		// checks for any errors, if present then choosing the required step
		if( $('label.error:not(:empty):first').closest('div[id^="step-"]').length > 0 ) {
			var firstErrorDivObj = $('label.error:not(:empty):first').closest('div[id^="step-"]'), firstErrorDivID = $(firstErrorDivObj).attr('id');
			if( firstErrorDivID != null && typeof firstErrorDivID != 'undefined' ) {
				if( !firstErrorDivObj.is(':visible') ) {
					firstErrorDivObj.prevAll('div[id^="step-"]').each(function(){
						var currentDivID = $(this).attr('id'), relatedAnchorObj = $('a[href="#'+ currentDivID +'"]');
						if( relatedAnchorObj != null && typeof relatedAnchorObj != 'undefined' ) {
							if( relatedAnchorObj.hasClass('disabled') ) {
								relatedAnchorObj.removeClass('disabled');
							}
							if( !relatedAnchorObj.hasClass('done') ) {
								relatedAnchorObj.addClass('done');
							}
							relatedAnchorObj.attr('isdone', 1);
						}
					});
					$('a[href="#'+ firstErrorDivID +'"]').removeClass('disabled').addClass('selected').attr('isdone', 1).trigger('click');
				}
			}
		}

		// onchange method binding for country dropdown
		$('#country_id').on('change', function(){
			var country_id = $(this).val();
			var inputData = {'country_id': country_id, '_token': '{{ csrf_token() }}'};
			$.ajax({
				url: "{{ route('countries.searchstates') }}",
				type: 'POST',
				data: inputData,
				dataType: 'json',
				error: function() {
					alert(notProcessedRequestText);
				},
				success: function(response) {
					if( response.err_flag != null && response.err_flag == 1 ) {
						var errMsg = '';
						$.each(response.err_msg, function(key, value){
							errMsg += value +'<br>';
						});

						if( err_msg == null || err_msg == '' ) {
							err_msg = notProcessedRequestText;
						}
						alert(err_msg);
					}
					else {
						var optionHTML = '<option value="">Select One</option>';
						$.each(response.states, function(key, value){
							optionHTML += '<option value="'+ value['state_id'] +'">'+ value['state_name'] +'</option>';
						});
						$('#state_id').html(optionHTML);
					}
				}
			});
		});

		// onchange method binding for state dropdown
		$('#state_id').on('change', function(){
			var state_id = $(this).val();
			var inputData = {'state_id': state_id, '_token': '{{ csrf_token() }}'};
			$.ajax({
				url: "{{ route('states.searchcities') }}",
				type: 'POST',
				data: inputData,
				dataType: 'json',
				error: function() {
					alert(notProcessedRequestText);
				},
				success: function(response) {
					if( response.err_flag != null && response.err_flag == 1 ) {
						var errMsg = '';
						$.each(response.err_msg, function(key, value){
							errMsg += value +'<br>';
						});

						if( err_msg == null || err_msg == '' ) {
							err_msg = notProcessedRequestText;
						}
						alert(err_msg);
					}
					else {
						var optionHTML = '<option value="">Select One</option>';
						$.each(response.states, function(key, value){
							optionHTML += '<option value="'+ value['city_id'] +'">'+ value['city_name'] +'</option>';
						});
						$('#city_id').html(optionHTML);
					}
				}
			});
		});
	});
</script>
@endsection('footer_page_scripts')