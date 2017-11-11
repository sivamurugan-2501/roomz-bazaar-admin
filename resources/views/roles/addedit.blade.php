@extends('layouts.listing')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="page-title row">
				<div class="title_left col-md-12">
					<h3>
					@if( isset($roles['role_id']) && !empty($roles['role_id']) && is_numeric($roles['role_id']) )
						Edit Roles
					@else
						Add Roles
					@endif
					</h3>
				</div>	<!-- /.title_left col-md-12 -->
			</div>	<!-- /.page-title row -->
			<div class="row x_panel">
				<div class="col-md-12 x_content">
					<form action="{{ $roles['form_url'] }}" method="POST" class="form-horizontal">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-6 form-group">
								<label class="control-label">Role Name</label>
								<input type="text" class="form-control" name="role_name" id="role_name" maxlength="191" value="{{ $roles['role_name'] }}">
								<label class="error">{{ $errors->first('role_name') }}</label>
								<input type="hidden" class="form-control" id="role_id" name="role_id" value="{{ $roles['role_id'] }}">
							</div>	<!-- /.col-md-6 -->
							<div class="col-md-6">&nbsp;</div>	<!-- /.col-md-6 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-12">
								<label class="control-label">Permission List</label>
								<div>
								@if( isset($roles['permissions']) )
									<ul class="checktree">
									@foreach($roles['permissions'] as $m_key => $m_value)
										@if( $m_value->permission_parent == 0 )
											<li>
												<input type="checkbox" id="chk_{{$m_value->permission_key}}" name="permissions[]" value="{{$m_value->permission_key}}" {{$m_value->role_permission_id}}>
												<label for="chk_{{$m_value->permission_key}}">{{$m_value->permission_label}}</label>
												<ul>
												@foreach($roles['permissions'] as $p_key => $p_value)
													@if( ($m_value->module_id == $p_value->module_id) && ($m_value->permission_id == $p_value->permission_parent) )
													<li>
														<input type="checkbox" id="chk_{{$p_value->permission_key}}" name="permissions[]" value="{{$p_value->permission_key}}" {{$p_value->role_permission_id}}>
														<label for="chk_{{$p_value->permission_key}}">{{$p_value->permission_label}}</label>
													</li>
													@endif
												@endforeach
												</ul>
											</li>
										@endif
									@endforeach
									</ul>
								@else
									Roles Not Found
								@endif
								</div>
								<label class="error"></label>
							</div>	<!-- ./col-md-12 -->
						</div>	<!-- ./row -->
						<div class="row">
							<div class="col-md-1">
								<label class="control-label">Active</label>
								<input type="checkbox" class="form-control" name="role_status" id="role_status" value="1" {{ $roles['role_status_check'] }}>
								<label class="error">{{ $errors->first('role_status') }}</label>
							</div>	<!-- /.col-md-1 -->
							<div class="col-md-11">&nbsp;</div>	<!-- /.col-md-11 -->
						</div>	<!-- /.row -->
						<div class="row">
							<div class="col-md-12">
								<button type="submit" value="Save" class="btn btn-primary">Save</button>&nbsp;
								<button type="button" value="Back" class="btn btn-default" onclick="window.open('{{ route('roles.index') }}','_parent');">Back</button>
							</div>	<!-- /.col-md-12 -->
						</div>	<!-- /.row -->
					</form>	<!-- /.form -->
				</div>	<!-- /.col-md-12 -->
			</div>	<!-- /.row -->
		</div>	<!-- /.col-md-12 -->
	</div>	<!-- /.row -->
@endsection('content')
@section('header_page_scripts')

		<!-- JQuery ui css for accordion -->
		<!--link href="{!! asset('css/jquery-ui.css') !!}" rel="stylesheet" type="text/css"-->
		<style type="text/css">
			ul {
				list-style-type: none;
				margin: 3px;
			}
			ul.checktree li:before {
				height: 1em;
				width: 12px;
				border-bottom: 1px dashed;
				content: "";
				display: inline-block;
				top: -0.3em;
			}
			ul.checktree li { border-left: 1px dashed; }
			ul.checktree li:last-child:before { border-left: 1px dashed; }
			ul.checktree li:last-child { border-left: none; }
		</style>
@endsection('header_page_scripts')
@section('footer_page_scripts')

		<!--script type="text/javascript" src="{!! asset('js/jquery-ui.js') !!}"></script-->
		<script type="text/javascript">
			$(document).ready(function(){
				$("#role_status").bootstrapSwitch({'onText':'Yes', 'offText':'No'});
				if(  $("ul.checktree").length > 0 )
				{  $("ul.checktree").checktree();  }
			});
			(function($){
				$.fn.checktree = function(){
					$(':checkbox').on('click', function (event){
						event.stopPropagation();
						var clk_checkbox = $(this),
						chk_state = clk_checkbox.is(':checked'),
						parent_li = clk_checkbox.closest('li'),
						parent_uls = parent_li.parents('ul');
						//parent_li.find(':checkbox').prop('checked', chk_state);
						parent_uls.each(function(){
							parent_ul = $(this);
							//parent_state = (parent_ul.find(':checkbox').length == parent_ul.find(':checked').length); 
							parent_state = (parent_ul.find(':checked').length > 0);
							parent_ul.siblings(':checkbox').prop('checked', parent_state);
						});
					});
				};
			}(jQuery));
		</script>
@endsection('footer_page_scripts')