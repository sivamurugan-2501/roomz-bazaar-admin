@extends('layouts.listing')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="page-title row">
				<div class="title_left col-md-12">
					<h3>
					@if( isset($states['state_id']) && !empty($states['state_id']) && is_numeric($states['state_id']) )
						Edit State
					@else
						Add State
					@endif
					</h3>
				</div>	<!-- /.title_left col-md-12 -->
			</div>	<!-- /.page-title row -->
			<div class="row x_panel">
				<div class="col-md-12 x_content">
					<form action="{{ $states['form_url'] }}" method="POST" class="form-horizontal">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-6 form-group">
								<label class="control-label">State Name</label>
								<input type="text" class="form-control" name="state_name" id="state_name" maxlength="191" value="{{ $states['state_name'] }}">
								<label class="error">{{ $errors->first('state_name') }}</label>
								<input type="hidden" class="form-control" id="state_id" name="state_id" value="{{ $states['state_id'] }}">
							</div>	<!-- /.col-md-6 -->
							<div class="col-md-6">
								<label class="control-label">State Code</label>
								<input type="text" class="form-control" name="state_code" id="state_code" maxlength="10" value="{{ $states['state_code'] }}">
								<label class="error">{{ $errors->first('state_code') }}</label>
							</div>	<!-- /.col-md-6 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-8">
								<label class="control-label">Country</label>
								<select class="form-control" name="country_code" id="country_code">
									<option value="">Select One</option>
									@foreach($country_list as $country_list)
										@if( $entry_country_code == $country_list->country_code )
											<option value="{{ $country_list->country_code }}" selected>{{ $country_list->country_name }}</option>
										@else
											<option value="{{ $country_list->country_code }}">{{ $country_list->country_name }}</option>
										@endif
									@endforeach
								</select>
								<label class="error">{{ $errors->first('country_code') }}</label>
							</div>	<!-- /.col-md-8 -->
							<div class="col-md-4">
								<label class="control-label">Active</label><br>
								<input type="checkbox" class="form-control" name="state_status" id="state_status" value="1" {{ $states['state_status_check'] }}>
								<label class="error">{{ $errors->first('state_status') }}</label>
							</div>	<!-- /.col-md-4 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-12">
								<button type="submit" value="Save" class="btn btn-primary">Save</button>&nbsp;
								<button type="button" value="Back" class="btn btn-default" onclick="window.open('{{ route('states.index', $entry_country_code) }}','_parent');">Back</button>
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
		$("#state_status").bootstrapSwitch({'onText':'Yes', 'offText':'No'});
	});
</script>
@endsection('footer_page_scripts')