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
	@if(!empty($countries))
	<div class="row">
		<div class="col-md-12">
			<div class="pull-left">
				<h2>Country List</h2>
			</div>
			<div class="pull-right">
				<a class="btn btn-success" href="{{ route('countries.add') }}"> Add New</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped task-table">
				<!-- Table Headings Starts -->
				<thead>
					<th>Country Name</th>
					<th>Country Code</th>
					<th>Country Status</th>
					<th width="20%">Action</th>
				</thead>
				<!-- Table Headings Ends -->
				<!-- Table Body Starts -->
				<tbody>
					@foreach($countries as $country)
					<tr>
						<td class="table-text">
							<div>{{$country->country_name}}</div>
						</td>
						<td class="table-text">
							<div>{{$country->country_code}}</div>
						</td>
						<td class="table-text">
							<div>
								@if( $country->country_status == 1 )
									Active
								@else
									Inactive
								@endif
							</div>
						</td>
						<td>
							<a href="{{ route('countries.edit', $country->country_id) }}">Edit</a>&nbsp;
							@if( $country->country_status == 1 )
							<a href="{{ route('countries.delete', $country->country_id) }}" onclick="return confirm('Are you sure to delete?')">Delete</a>&nbsp;
							<a href="{{ route('states.index', $country->country_code) }}">View States</a>
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