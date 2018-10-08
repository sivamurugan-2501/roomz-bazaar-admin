@extends('layouts.listing')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="page-title row">
				<div class="title_left col-md-12">
					<h3>
					@if( isset($cities['city_id']) && !empty($cities['city_id']) && is_numeric($cities['city_id']) )
						Edit City
					@else
						Add City
					@endif
					</h3>
				</div>	<!-- /.title_left col-md-12 -->
			</div>	<!-- /.page-title row -->
			<div class="row x_panel">
				<div class="col-md-12 x_content">
					<form action="{{ $cities['form_url'] }}" method="POST" class="form-horizontal">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-6 form-group">
								<label class="control-label">City Name</label>
								<input type="text" class="form-control" name="city_name" id="city_name" maxlength="255" value="{{ $cities['city_name'] }}">
								<label class="error">{{ $errors->first('city_name') }}</label>
								<input type="hidden" class="form-control" id="city_id" name="city_id" value="{{ $cities['city_id'] }}">
							</div>	<!-- /.col-md-6 -->
							<div class="col-md-6">
								<label class="control-label">State</label>
								<select class="form-control" name="state_id" id="state_id">
									<option value="">Select One</option>
									@foreach($states_list as $states_list)
										@if( $entry_state_id == $states_list->state_id )
											<option value="{{ $states_list->state_id }}" selected>{{ $states_list->country_name .' >> '. $states_list->state_name }}</option>
										@else
											<option value="{{ $states_list->state_id }}">{{ $states_list->country_name .' >> '. $states_list->state_name }}</option>
										@endif
									@endforeach
								</select>
								<label class="error">{{ $errors->first('state_id') }}</label>
							</div>	<!-- /.col-md-6 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-1">
								<label class="control-label">Active</label><br>
								<input type="checkbox" class="form-control" name="city_status" id="city_status" value="1" {{ $cities['city_status_check'] }}>
								<label class="error">{{ $errors->first('city_status') }}</label>
							</div>	<!-- /.col-md-1 -->
							<div class="col-md-11">&nbsp;</div>	<!-- /.col-md-11 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-12">
								<button type="submit" value="Save" class="btn btn-primary">Save</button>&nbsp;
								<button type="button" value="Back" class="btn btn-default" onclick="window.open('{{ route('cities.index', $entry_state_id) }}','_parent');">Back</button>
							</div>	<!-- /.col-md-12 -->
						</div>	<!-- /.row -->
					</form>	<!-- /.form -->
				</div>	<!-- /.col-md-12 -->
			</div>	<!-- /.row -->
		</div>	<!-- /.col-md-12 -->
	</div>	<!-- /.row -->
@endsection('content')
@section('footer_page_scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$("#city_status").bootstrapSwitch({'onText':'Yes', 'offText':'No'});
	});
</script>
@endsection('footer_page_scripts')