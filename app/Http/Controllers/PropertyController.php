<?php

namespace App\Http\Controllers;
use App\Property;
use App\PropertyTypeMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
class PropertyController extends Controller
{
	private $recordStatus = 1;
	private $propertyTypeTable = 'property_type_master';
	private $countryTable = 'country_master';
	private $stateTable = 'state_master';
	private $cityTable = 'city_master';
    public function __construct() {
		$this->middleware('auth');
    }

	// display list of properties
	public function index(){
		// pass properties data to view and load list view
		return view('property.index', ['property' => array()]);
	}

    public function search(Request $request){
        // get post data
        $postData = $request->all();

        $draw = 0;
        if( isset($postData['draw']) && !empty($postData['draw']) && is_numeric($postData['draw']) )
        {  $draw = $postData['draw'];  }

        $start = 0;
        if( isset($postData['start']) && !empty($postData['start']) && is_numeric($postData['start']) )
        {  $start = $postData['start'];  }
        
        $length = 0;
        if( isset($postData['length']) && !empty($postData['length']) && is_numeric($postData['length']) )
        {  $length = $postData['length'];  }
        
        $list_for = '';
        if( isset($postData['list_for']) && !empty($postData['list_for']) )
        {  $list_for = trim($postData['list_for']);  }
        
        $tempColumns = array();     //Will try to retrieve data from POSTED Variables
        if( isset($postData['columns']) && count($postData['columns']) > 0 )
        {  $tempColumns=$postData['columns'];  }

        $data = array();
        $tempFieldList = array();
        if( isset($postData['default_column']) && !empty($postData['default_column']) )
        {  $tempFieldList['normal'][] = $postData['default_column'];  }
        $tempSearchFlds = array();

        if( is_array($tempColumns) && count($tempColumns) > 0 )
        {
            foreach( $tempColumns as $tempField )
            {
                $tempSearchValue = $tempField['search']['value'];
                switch ( strtolower($tempField['data']) ) {
                    case 'action':
                    case 'check_all':
                        break;
                    case 'created_on':
                        $tempFieldList['raw'][] = " DATE_FORMAT(created_at, '%d %M %Y') AS created_on ";
                        break;
                    default:
                        $tempFieldList['normal'][] = $tempField['data'];
                        if( isset($tempSearchValue) )
                        {
                            if( strpos($tempField['data'], 'status') !== FALSE && is_numeric($tempSearchValue) )
                            {  $tempSearchFlds[] = array($tempField['data'], '=', $tempSearchValue);  }
                            elseif( !empty($tempSearchValue) )
                            {  $tempSearchFlds[] = array($tempField['data'], 'like', '%'. $tempSearchValue .'%');  }
                        }
                }
            }
            unset($tempField);
        }

        if( !is_array($tempFieldList) || count($tempFieldList) == 0 )
        {  $tempFieldList = array('normal' => array('*'));  }

        $tempOrderList = array();
        $tempOrderArr = array();
        if( isset($postData['order']) && count($postData['order']) > 0 )
        {  $tempOrderArr = $postData['order'];  }

        if( is_array($tempOrderArr) && count($tempOrderArr) > 0 )
        {
            foreach( $tempOrderArr as $tempField )
            {
                if( count($tempColumns) >= $tempField['column'] )
                {
                    switch( $tempColumns[$tempField['column']]['data'] )
                    {
                        case 'Action':
                        case 'check_all':
                            break;
                        default:
                            $tempOrderList[$tempColumns[$tempField['column']]['data']] = $tempField['dir'];
                    }
                }
            }
            unset($tempField);
        }

        $Property = Property::select($tempFieldList['normal']);
        if( isset($tempFieldList['raw']) && is_array($tempFieldList['raw']) && !empty($tempFieldList['raw']) )
        {  $Property = $Property->addSelect(DB::raw(implode(',', $tempFieldList['raw'])));  }
        if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
        {  $Property = $Property->where($tempSearchFlds);  }
        if( isset($tempOrderList) && is_array($tempOrderList) && count($tempOrderList) > 0 )
        {
            foreach( $tempOrderList as $tempKey => $tempField )
            {  $Property = $Property->orderBy($tempKey, $tempField);  }
            unset($tempKey, $tempField);
        }
        $Property = $Property->offset($start)->limit($length);
        $Property = $Property->get();

        if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
        {  $noOfRecords = Property::where($tempSearchFlds)->count();  }
        else{  $noOfRecords = Property::count();  }

        foreach($Property as $_key => $_value)
        {
            $tempDataArray = array();
            if( is_array($tempColumns) && count($tempColumns) > 0 )
            {
                $temp_rowID = 0;
                $tempAction = '';
                if( isset($postData['default_column']) && !empty($postData['default_column']) )
                {
                    $temp_rowID = $_value[$postData['default_column']];
                    $tempDataArray = array_merge( $tempDataArray, array( 'DT_RowId' => $temp_rowID ) );
                }
                
                foreach($tempColumns as $tempField)
                {
                    $tempField['data'] = strtolower($tempField['data']);
                    if( strpos($tempField['data'], 'action') !== FALSE )
                    {
                        $tempAction = '<a class="btn btn-info btn-xs" href="'. route('property.edit', $temp_rowID) .'" title="Edit Record"><i class="fa fa-pencil"></i>&nbsp;Edit</a>&nbsp;' . $tempAction;
                        $tempDataArray = array_merge( $tempDataArray, array( $tempField['data'] => $tempAction ) );
                    }
                    elseif( strpos($tempField['data'], 'status') !== FALSE )
                    {
                        $tempStatus = '<span class="btn btn-warning btn-xs">Inactive</span>';
                        if( isset($_value[$tempField['data']]) && !empty($_value[$tempField['data']]) )
                        {
                            $tempStatus = '<span class="btn btn-success btn-xs">Active&nbsp;&nbsp;&nbsp;</span>';
                            $tempAction .= '<a class="btn btn-danger btn-xs" href="'. route('property.delete', $temp_rowID) .'" onclick="return confirm(\'Are you sure to delete?\')" title="Delete Record"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>';
                        }
                        $tempDataArray = array_merge( $tempDataArray, array( $tempField['data'] => $tempStatus ) );
                        unset($tempStatus);
                    }
                    else
                    {
                        $tempDataArray = array_merge( $tempDataArray, array( $tempField['data'] => $_value[$tempField['data']] ) );
                    }
                }
                unset($tempAction, $tempField);
            }
            $data[] = $tempDataArray;
        }
        unset($_key, $_value);

        return json_encode(array("draw"=>$draw, "recordsFiltered"=>$noOfRecords, "recordsTotal"=> $noOfRecords, "data"=>$data));
    }

	// add form for property
	public function addedit($id = null){
		// retrieving property type master details
		$property_type_arr = DB::table($this->propertyTypeTable)
							->where(array('type_status' => $this->recordStatus))
							->select(array('type_id', 'type_name'))
							->orderBy($this->propertyTypeTable .'.type_name', 'asc')->get();

		$show_as_arr = array('sale' => 'Sale', 'rent' => 'Rent', 'pg' => 'PG');

		$arr_options = array('yes' => 'Yes', 'no' => 'No');

		$property_data = array('name' => '', 'property_type_id' => 0, 'show_as' => '', 'address' => '', 'property_status' => 1, 
							  'city_id' => 0, 'state_id' => 0, 'country_id' => 0, 'landmark' => '', 'property_age' => '', 'total_floors' => '', 
							  'floor_no' => '', 'per_square_feet' => '', 'total_square_feet' => '', 'carpet_area' => '', 'usable_area' => '', 
							  'total_rate' => '', 'negotiable' => 'no', 'advance_deposite' => '', 'rent_per_month' => '', 'maintenance_include' => 'no', 
							  'parking' => 'no', 'gym' => 'no', 'water_supply' => 'no', 'garden' => 'no', 'others' => '', 
							  'rera_number' => '', 'property_status_check' => '', 
							  'id' => 0, 'form_url' => route('property.insert'), 'property_type_arr' => $property_type_arr, 'show_as_arr' => $show_as_arr,
							  'arr_options' => $arr_options);
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			$property = Property::find($id);
			if( isset($property->name) && !empty($property->name) )
			{  $property_data['name'] = $property->name;  }
			if( isset($property->property_type_id) && !empty($property->property_type_id) )
			{  $property_data['property_type_id'] = $property->property_type_id;  }
			if( isset($property->show_as) && !empty($property->show_as) )
			{  $property_data['show_as'] = $property->show_as;  }
			if( isset($property->address) && !empty($property->address) )
			{  $property_data['address'] = $property->address;  }
			if( isset($property->city_id) && !empty($property->city_id) )
			{  $property_data['city_id'] = $property->city_id;  }
			if( isset($property->state_id) && !empty($property->state_id) )
			{  $property_data['state_id'] = $property->state_id;  }
			if( isset($property->country_id) && !empty($property->country_id) )
			{  $property_data['country_id'] = $property->country_id;  }
			if( isset($property->landmark) && !empty($property->landmark) )
			{  $property_data['landmark'] = $property->landmark;  }
			if( isset($property->property_age) && !empty($property->property_age) )
			{  $property_data['property_age'] = $property->property_age;  }
			if( isset($property->total_floors) && !empty($property->total_floors) )
			{  $property_data['total_floors'] = $property->total_floors;  }
			if( isset($property->floor_no) && !empty($property->floor_no) )
			{  $property_data['floor_no'] = $property->floor_no;  }
			if( isset($property->per_square_feet) && !empty($property->per_square_feet) )
			{  $property_data['per_square_feet'] = $property->per_square_feet;  }
			if( isset($property->total_square_feet) && !empty($property->total_square_feet) )
			{  $property_data['total_square_feet'] = $property->total_square_feet;  }
			if( isset($property->carpet_area) && !empty($property->carpet_area) )
			{  $property_data['carpet_area'] = $property->carpet_area;  }
			if( isset($property->usable_area) && !empty($property->usable_area) )
			{  $property_data['usable_area'] = $property->usable_area;  }
			if( isset($property->total_rate) && !empty($property->total_rate) )
			{  $property_data['total_rate'] = $property->total_rate;  }
			if( isset($property->negotiable) && !empty($property->negotiable) )
			{  $property_data['negotiable'] = $property->negotiable;  }
			if( isset($property->advance_deposite) && !empty($property->advance_deposite) )
			{  $property_data['advance_deposite'] = $property->advance_deposite;  }
			if( isset($property->rent_per_month) && !empty($property->rent_per_month) )
			{  $property_data['rent_per_month'] = $property->rent_per_month;  }
			if( isset($property->maintenance_include) && !empty($property->maintenance_include) )
			{  $property_data['maintenance_include'] = $property->maintenance_include;  }
			if( isset($property->parking) && !empty($property->parking) )
			{  $property_data['parking'] = $property->parking;  }
			if( isset($property->gym) && !empty($property->gym) )
			{  $property_data['gym'] = $property->gym;  }
			if( isset($property->water_supply) && !empty($property->water_supply) )
			{  $property_data['water_supply'] = $property->water_supply;  }
			if( isset($property->garden) && !empty($property->garden) )
			{  $property_data['garden'] = $property->garden;  }
			if( isset($property->others) && !empty($property->others) )
			{  $property_data['others'] = $property->others;  }
			if( isset($property->rera_number) && !empty($property->rera_number) )
			{  $property_data['rera_number'] = $property->rera_number;  }
			if( isset($property->property_status) && is_numeric($property->property_status) )
			{  $property_data['property_status'] = $property->property_status;  }
			$property_data['id'] = $id;
			$property_data['form_url'] = route('property.update', $id);
		}

		if( old('name') !== null )
		{  $property_data['name'] = old('name');  }
		if( old('property_type_id') !== null )
		{  $property_data['property_type_id'] = old('property_type_id');  }
		if( old('show_as') !== null )
		{  $property_data['show_as'] = old('show_as');  }
		if( old('address') !== null )
		{  $property_data['address'] = old('address');  }
		if( old('city_id') !== null )
		{  $property_data['city_id'] = old('city_id');  }
		if( old('state_id') !== null )
		{  $property_data['state_id'] = old('state_id');  }
		if( old('country_id') !== null )
		{  $property_data['country_id'] = old('country_id');  }
		if( old('landmark') !== null )
		{  $property_data['landmark'] = old('landmark');  }
		if( old('property_age') !== null )
		{  $property_data['property_age'] = old('property_age');  }
		if( old('total_floors') !== null )
		{  $property_data['total_floors'] = old('total_floors');  }
		if( old('floor_no') !== null )
		{  $property_data['floor_no'] = old('floor_no');  }
		if( old('per_square_feet') !== null )
		{  $property_data['per_square_feet'] = old('per_square_feet');  }
		if( old('total_square_feet') !== null )
		{  $property_data['total_square_feet'] = old('total_square_feet');  }
		if( old('carpet_area') !== null )
		{  $property_data['carpet_area'] = old('carpet_area');  }
		if( old('usable_area') !== null )
		{  $property_data['usable_area'] = old('usable_area');  }
		if( old('total_rate') !== null )
		{  $property_data['total_rate'] = old('total_rate');  }
		if( old('negotiable') !== null )
		{  $property_data['negotiable'] = old('negotiable');  }
		if( old('advance_deposite') !== null )
		{  $property_data['advance_deposite'] = old('advance_deposite');  }
		if( old('rent_per_month') !== null )
		{  $property_data['rent_per_month'] = old('rent_per_month');  }
		if( old('maintenance_include') !== null )
		{  $property_data['maintenance_include'] = old('maintenance_include');  }
		if( old('parking') !== null )
		{  $property_data['parking'] = old('parking');  }
		if( old('gym') !== null )
		{  $property_data['gym'] = old('gym');  }
		if( old('water_supply') !== null )
		{  $property_data['water_supply'] = old('water_supply');  }
		if( old('garden') !== null )
		{  $property_data['garden'] = old('garden');  }
		if( old('others') !== null )
		{  $property_data['others'] = old('others');  }
		if( old('rera_number') !== null )
		{  $property_data['rera_number'] = old('rera_number');  }
		if( old('property_status') !== null )
		{  $property_data['property_status'] = old('property_status');  }
		if( isset($property_data['property_status']) && !empty($property_data['property_status']) )
		{  $property_data['property_status_check'] = "checked";  }

		// retrieving country master details
		$country_arr = DB::table($this->countryTable)
					   ->where(array('country_status' => $this->recordStatus))
					   ->select(array('country_id', 'country_name'))
					   ->orderBy($this->countryTable .'.country_name', 'asc')->get();

	    // retrieving state master details
		$state_arr = DB::table($this->stateTable)
					 ->join($this->countryTable, $this->countryTable .'.country_code', '=', 'state_master.country_code')
					 ->where(array($this->stateTable .'.state_status' => $this->recordStatus, $this->countryTable .'.country_id' => $property_data['country_id']))
					 ->select(array($this->stateTable .'.state_id', $this->stateTable .'.state_name'))
					 ->orderBy($this->stateTable .'.state_name', 'asc')->get();

		// retrieving city master details
		$city_arr = DB::table($this->cityTable)
					->where(array('city_status' => $this->recordStatus, 'state_id' => $property_data['state_id']))
					->select(array('city_id', 'city_name'))
					->orderBy($this->cityTable .'.city_name', 'asc')->get();
		$property_data = array_merge($property_data, array('country_arr' => $country_arr, 'state_arr' => $state_arr, 'city_arr' => $city_arr));
		return view('property.addedit', ['property' => $property_data]);
	}

	// save data for property
	public function savedata($id = null, Request $request){
		// get post data
		$postData = $request->all();
		$max_floor_no = (int) ( isset($request->total_floors) ? $request->total_floors : 0 );
		$max_carpet_area = (int) ( isset($request->total_square_feet) ? $request->total_square_feet : 0 );
		$max_usable_area = (int) ( isset($request->carpet_area) ? $request->carpet_area : 0 );

    	// validate post data
    	$this->validate($request, [
    		'name' => 'required|max:100|unique:property_master,NULL,'. $id .',id',
    		'property_type_id' => 'required',
    		'show_as' => 'required|max:100',
    		'address' => 'required',
    		'city_id' => 'required',
    		'state_id' => 'required',
    		'country_id' => 'required',
    		'landmark' => 'required|max:191',
    		'property_age' => 'required|integer|min:0',
    		'total_floors' => 'required|integer|min:0',
    		'floor_no' => 'required|integer|min:0|max:'. $max_floor_no,
    		'per_square_feet' => 'required|integer|min:0',
    		'total_square_feet' => 'required|integer|min:0',
    		'carpet_area' => 'required|integer|min:0|max:'. $max_carpet_area,
    		'usable_area' => 'required|integer|min:0|max:'. $max_usable_area,
    		'total_rate' => 'required|integer|min:0',
    		'negotiable' => 'required',
    		'advance_deposite' => 'required|integer|min:0',
    		'rent_per_month' => 'required|integer|min:0',
    		'maintenance_include' => 'required',
    		'parking' => 'required',
    		'gym' => 'required',
    		'water_supply' => 'required',
    		'garden' => 'required',
    		'others' => 'required|max:191'
		]);
		
		if( !isset($postData['property_status']) || empty($postData['property_status']) || !is_numeric($postData['property_status']) )
		{  $postData['property_status'] = 0;  }

		$msgText = "Property details added successfully!";
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			// update data
			Property::find($id)->update($postData);
			$msgText = "Property details updated successfully!";
		}
		else
		{
			// insert data
			Property::create($postData);
		}

		// store status message
		Session::flash('success_msg', $msgText);
		return redirect()->route('property.index');
	}

	// delete data for property
	public function delete($id){
		// updating property_status to inactive as 0, and updated_at as current datetime
		DB::table('property_master')->where('id', $id)->update(array('property_status' => 0, 'updated_at' => date('Y-m-d H:i:s')));

		// store status message
		Session::flash('success_msg', 'Property details deleted successfully!');
		return redirect()->route('property.index');
	}
}
