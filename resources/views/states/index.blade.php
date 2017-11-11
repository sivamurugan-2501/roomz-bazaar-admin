@extends('layouts.listing')

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        @if(Session::has('success_msg'))
	        <div class="alert alert-success alert-dismissable">
	        	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	        	{{ Session::get('success_msg') }}
	        </div>
	        @elseif(Session::has('error_msg'))
	        <div class="alert alert-danger alert-dismissable">
	        	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	        	{{ Session::get('error_msg') }}
	        </div>
	        @endif
	    </div>
	</div>
	@if(!empty($states))
	<div class="row">
		<div class="col-md-12">
			<div class="pull-left">
				<h2>States List</h2>
			</div>
			<div class="pull-right">
				<a class="btn btn-info" href="{{ route('countries.index') }}">Country List</a>&nbsp;
				<a class="btn btn-success" href="{{ route('states.add', $country_code) }}"> Add New</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped task-table">
				<!-- Table Headings Starts -->
				<thead>
					<th>State Name</th>
					<th>State Code</th>
					<th>Country Name</th>
					<th>Country Code</th>
					<th>State Status</th>
					<th width="20%">Action</th>
				</thead>
				<!-- Table Headings Ends -->
				<!-- Table Body Starts -->
				<tbody>
					@foreach($states as $state)
					<tr>
						<td class="table-text">
							<div>{{$state->state_name}}</div>
						</td>
						<td class="table-text">
							<div>{{$state->state_code}}</div>
						</td>
						<td class="table-text">
							<div>{{$state->country_name}}</div>
						</td>
						<td class="table-text">
							<div>{{$state->country_code}}</div>
						</td>
						<td class="table-text">
							<div>
								@if( $state->state_status == 1 )
									<span class="btn btn-success btn-xs">Active&nbsp;&nbsp;&nbsp;</span>
								@else
									<span class="btn btn-warning btn-xs">Inactive</span>
								@endif
							</div>
						</td>
						<td>
							<a class="btn btn-info btn-xs" href="{{ route('states.edit', array($state->country_code, $state->state_id)) }}" title="Edit Record"><i class="fa fa-pencil"></i>&nbsp;Edit</a>&nbsp;
							@if( $state->state_status == 1 )
							<a class="btn btn-danger btn-xs" href="{{ route('states.delete', array($state->country_code, $state->state_id)) }}" onclick="return confirm('Are you sure to delete?')" title="Delete Record"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>&nbsp;
							<a class="btn btn-primary btn-xs" href="{{ route('cities.index', array($state->state_id)) }}" title="View Cities"><i class="fa fa-sitemap"></i>&nbsp;Cities</a>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
				<!-- Table Body Ends -->
			</table>
		</div>
	</div>
	@endif
@endsection