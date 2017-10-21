@extends('layouts.listing')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="page-title row">
				<div class="title_left col-md-12">
					<h3>
					@if( isset($countries['country_id']) && !empty($countries['country_id']) && is_numeric($countries['country_id']) )
						Edit Country
					@else
						Add Country
					@endif
					</h3>
				</div>	<!-- /.title_left col-md-12 -->
			</div>	<!-- /.page-title row -->
			<div class="row x_panel">
				<div class="col-md-12 x_content">
					<form action="{{ $countries['form_url'] }}" method="POST" class="form-horizontal">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-6 form-group">
								<label class="control-label">Country Name</label>
								<input type="text" class="form-control" name="country_name" id="country_name" maxlength="191" value="{{ $countries['country_name'] }}">
								<label class="error">{{ $errors->first('country_name') }}</label>
								<input type="hidden" class="form-control" id="country_id" name="country_id" value="{{ $countries['country_id'] }}">
							</div>	<!-- /.col-md-6 -->
							<div class="col-md-6">
								<label class="control-label">Country Code</label>
								<input type="text" class="form-control" name="country_code" id="country_code" maxlength="10" value="{{ $countries['country_code'] }}">
								<label class="error">{{ $errors->first('country_code') }}</label>
							</div>	<!-- /.col-md-6 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-1">
								<label class="control-label">Active</label>
								<input type="checkbox" class="form-control" name="country_status" id="country_status" value="1" {{ $countries['country_status_check'] }}>
								<label class="error">{{ $errors->first('country_status') }}</label>
							</div>	<!-- /.col-md-1 -->
							<div class="col-md-11">&nbsp;</div>	<!-- /.col-md-11 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-12">
								<button type="submit" value="Save" class="btn btn-primary">Save</button>&nbsp;
								<button type="button" value="Back" class="btn btn-default" onclick="window.open('{{ route('countries.index') }}','_parent');">Back</button>
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
		$("#country_status").bootstrapSwitch({'onText':'Yes', 'offText':'No'});
	});
</script>
@endsection('footer_page_scripts')