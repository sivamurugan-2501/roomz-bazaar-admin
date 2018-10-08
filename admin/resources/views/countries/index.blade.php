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
	<div class="row"><div class="col-md-12">&nbsp;</div></div>
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_content">
					<table id="dt_viewTable" class="table table-bordered table-striped table-hover" style="width: 100%;">
						<thead>
							<tr>
								<th data-paramid="country_name" data-searchtype="text">Country Name</th>
								<th data-paramid="country_code" data-searchtype="text">Country Code</th>
								<th data-paramid="country_status" data-searchtype="select">Country Status</th>
								<th data-paramid="action" data-searchtype="nosearch">Action</th>
							</tr>
						</thead>
						<tbody></tbody>
						<tfoot>
							<tr>
								<th data-paramid="country_name" data-searchtype="text">Country Name</th>
								<th data-paramid="country_code" data-searchtype="text">Country Code</th>
								<th data-paramid="country_status" data-searchtype="select">Country Status</th>
								<th data-paramid="action" data-searchtype="nosearch">Action</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('footer_page_scripts')
<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var columnDef = [{ sortable: false, targets: [2, 3], width: '10%' }];
		create_viewTable('country_list', 'country_id', "{{ route('countries.search') }}", columnDef);
	});
</script>
@endsection