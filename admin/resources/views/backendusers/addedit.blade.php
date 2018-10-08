@extends('layouts.listing')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="page-title row">
				<div class="title_left col-md-12">
					<h3>
					@if( isset($backendusers['id']) && !empty($backendusers['id']) && is_numeric($backendusers['id']) )
						Edit Admin User
					@else
						Add Admin User
					@endif
					</h3>
				</div>	<!-- /.title_left col-md-12 -->
			</div>	<!-- /.page-title row -->
			<div class="row x_panel">
				<div class="col-md-12 x_content">
					<form action="{{ $backendusers['form_url'] }}" method="POST" class="form-horizontal">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-6 form-group">
								<label class="control-label">User Full Name <span class="required">*</span></label>
								<input type="text" class="form-control" name="name" id="name" maxlength="255" value="{{ $backendusers['name'] }}">
								<label class="error">{{ $errors->first('name') }}</label>
								<input type="hidden" class="form-control" id="id" name="id" value="{{ $backendusers['id'] }}">
							</div>	<!-- /.col-md-6 -->
							<div class="col-md-6">
								<label class="control-label">User Email ID <span class="required">*</span></label>
								<input type="text" class="form-control" name="email" id="email" maxlength="191" value="{{ $backendusers['email'] }}">
								<label class="error">{{ $errors->first('email') }}</label>
							</div>	<!-- /.col-md-6 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-4">
								@if( !isset($backendusers['id']) || empty($backendusers['id']) || !is_numeric($backendusers['id']) )
								<label class="control-label">Password <span class="required">*</span></label>
								<input type="password" class="form-control" name="password" id="password" maxlength="32" value="">
								<label class="error">{{ $errors->first('password') }}</label>
								@else
								&nbsp;
								@endif
							</div>	<!-- /.col-md-4 -->
							<div class="col-md-4">
								@if( !isset($backendusers['id']) || empty($backendusers['id']) || !is_numeric($backendusers['id']) )
								<label class="control-label">First Login Password Change?</label><br>
								<input type="checkbox" class="" name="require_password_change" id="require_password_change" value="1" {{ $backendusers['require_password_change_check'] }}>
								<label class="error">{{ $errors->first('require_password_change') }}</label>
								@else
								&nbsp;
								@endif
							</div>	<!-- /.col-md-4 -->
							<div class="col-md-4">
								@if( !isset($backendusers['id']) || empty($backendusers['id']) || !is_numeric($backendusers['id']) )
								<label class="control-label">Send Email Notification To User?</label><br>
								<input type="checkbox" class="" name="user_send_notification" id="user_send_notification" value="1" {{ $backendusers['user_send_notification_check'] }}>
								<label class="error">{{ $errors->first('user_send_notification') }}</label>
								@else
								&nbsp;
								@endif
							</div>	<!-- /.col-md-4 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-6">
								<label class="control-label">User Role <span class="required">*</span></label>
								<select class="form-control" name="role_id" id="role_id">
									<option value="">Select One</option>
									@foreach( $backendusers['role_list'] as $tempField )
									<option value="{{ $tempField['role_id'] }}" {{ $tempField['pre_select'] }}>{{ $tempField['role_name'] }}</option>
									@endforeach
								</select>
								<label class="error">{{ $errors->first('role_id') }}</label>
							</div>	<!-- /.col-md-6 -->
							<div class="col-md-6">
								<label class="control-label">Active</label><br>
								<input type="checkbox" class="" name="user_status" id="user_status" value="1" {{ $backendusers['user_status_check'] }}>
								<label class="error">{{ $errors->first('user_status') }}</label>
							</div>	<!-- /.col-md-6 -->
						</div>	<!-- /.row -->
						<div class="row"><div class="col-md-12">&nbsp;</div></div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-12">
								<button type="submit" value="Save" class="btn btn-primary">Save</button>&nbsp;
								<button type="button" value="Back" class="btn btn-default" onclick="window.open('{{ route('backendusers.index') }}','_parent');">Back</button>
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
		$("#user_status").bootstrapSwitch({'onText':'Yes', 'offText':'No'});
	});
</script>
@endsection('footer_page_scripts')