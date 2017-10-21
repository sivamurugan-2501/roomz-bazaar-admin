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
	@if(!empty($cities))
	<div class="row">
		<div class="col-md-12">
			<div class="pull-left">
				<h2>Cities List</h2>
			</div>
			<div class="pull-right">
				@if( isset($country_code) && !empty($country_code) )
				<a class="btn btn-info" href="{{ route('states.index', $country_code) }}">State List</a>&nbsp;
				@endif
				<a class="btn btn-success" href="{{ route('cities.add', array($state_id)) }}"> Add New</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped task-table">
				<!-- Table Headings Starts -->
				<thead>
					<th>City Name</th>
					<th>State Name</th>
					<th>State Code</th>
					<th>Country Name</th>
					<th>Country Code</th>
					<th>City Status</th>
					<th width="20%">Action</th>
				</thead>
				<!-- Table Headings Ends -->
				<!-- Table Body Starts -->
				<tbody>
					@foreach($cities as $city)
					<tr>
						<td class="table-text">
							<div>{{$city->city_name}}</div>
						</td>
						<td class="table-text">
							<div>{{$city->state_name}}</div>
						</td>
						<td class="table-text">
							<div>{{$city->state_code}}</div>
						</td>
						<td class="table-text">
							<div>{{$city->country_name}}</div>
						</td>
						<td class="table-text">
							<div>{{$city->country_code}}</div>
						</td>
						<td class="table-text">
							<div>
								@if( $city->city_status == 1 )
									Active
								@else
									Inactive
								@endif
							</div>
						</td>
						<td>
							<a href="{{ route('cities.edit', array($city->state_id, $city->city_id)) }}">Edit</a>&nbsp;
							@if( $city->city_status == 1 )
							<a href="{{ route('cities.delete', array($city->state_id, $city->city_id)) }}" onclick="return confirm('Are you sure to delete?')">Delete</a>
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