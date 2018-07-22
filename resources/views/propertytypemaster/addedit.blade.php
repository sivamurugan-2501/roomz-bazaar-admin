@extends('layouts.listing')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="page-title row">
				<div class="title_left col-md-12">
					<h3>
					@if( isset($propertytypemaster['type_id']) && !empty($propertytypemaster['type_id']) && is_numeric($propertytypemaster['type_id']) )
						Edit Property Type
					@else
						Add Property Type
					@endif
					</h3>
				</div>	<!-- /.title_left col-md-12 -->
			</div>	<!-- /.page-title row -->
			<div class="row x_panel">
				<div class="col-md-12 x_content">
					<form action="{{ $propertytypemaster['form_url'] }}" method="POST" class="form-horizontal">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-6 form-group">
								<label class="control-label">Type Name</label>
								<input type="text" class="form-control" name="type_name" id="type_name" maxlength="191" value="{{ $propertytypemaster['type_name'] }}">
								<label class="error">{{ $errors->first('type_name') }}</label>
								<input type="hidden" class="form-control" id="type_id" name="type_id" value="{{ $propertytypemaster['type_id'] }}">
							</div>	<!-- /.col-md-6 -->
							<div class="col-md-6">
								<label class="control-label">Active</label>
								<input type="checkbox" class="form-control" name="type_status" id="type_status" value="1" {{ $propertytypemaster['type_status_check'] }}>
								<label class="error">{{ $errors->first('type_status') }}</label>
							</div>	<!-- /.col-md-6 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-12">
								<button type="submit" value="Save" class="btn btn-primary">Save</button>&nbsp;
								<button type="button" value="Back" class="btn btn-default" onclick="window.open('{{ route('propertytypemaster.index') }}','_parent');">Back</button>
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
		$("#type_status").bootstrapSwitch({'onText':'Yes', 'offText':'No'});
	});
</script>
@endsection('footer_page_scripts')