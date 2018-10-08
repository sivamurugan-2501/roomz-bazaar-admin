<?php

namespace App\Http\Controllers;
use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
class CitiesController extends Controller
{
	private $recordStatus = 1;
	private $primaryTable = 'city_master';
	private $secondaryTable = 'state_master';
	private $thirdTable = 'country_master';
	public function __construct(){
		$this->middleware('auth');
	}
	
	// display list of cities based on state & country parameter passed
	public function index($state_id = null){
		// fetch all cities data
		$cities = DB::table($this->primaryTable)
					->join($this->secondaryTable, $this->primaryTable.'.state_id', '=', $this->secondaryTable.'.state_id')
					->join($this->thirdTable, $this->secondaryTable.'.country_code', '=', $this->thirdTable.'.country_code')
					->where(array($this->secondaryTable .'.state_id' => $state_id, 
								  $this->secondaryTable .'.state_status' => $this->recordStatus,
								  $this->thirdTable .'.country_status' => $this->recordStatus))
					->select($this->primaryTable .'.*', $this->secondaryTable .'.state_name', $this->secondaryTable .'.state_id', 
							 $this->thirdTable .'.country_name', $this->secondaryTable.'.state_code', $this->thirdTable .'.country_code')
					->orderBy($this->primaryTable .'.city_name', 'asc')->get();
		$country_code = DB::table($this->secondaryTable)->where(array('state_id' => $state_id))->get()->first();
		if( isset($country_code->country_code) && !empty($country_code->country_code) )
		{  $country_code = $country_code->country_code;  }
		else{  $country_code = "";  }
		// pass cities data to view and load list view
		return view('cities.index', ['cities' => $cities, 'country_code' => $country_code, 'state_id' => $state_id]);
	}

	public function search(Request $request){
		// get post data
		$postData = $request->all();
		$state_id = null;
		if( isset($postData['extras']) && is_array($postData['extras']) && count($postData['extras']) > 0 )
		{
			foreach($postData['extras'] as $e_key => $e_value)
			{
				switch($e_value['name'])
				{
					case 'state_id':
						$state_id = $e_value['value'];
						break;
				}
			}
			unset($e_key, $e_value);
		}

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
		
		$tempColumns = array();		//Will try to retrieve data from POSTED Variables
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
						$tempFieldList['raw'][] = " DATE_FORMAT(`". $this->primaryTable ."`.`created_at`, '%d %M %Y') AS created_on ";
						break;
					case 'country_name':
					case 'country_code':
						$tempFieldList['normal'][] = $this->thirdTable .'.'. $tempField['data'];
						if( isset($tempSearchValue) )
						{
							if( !empty($tempSearchValue) )
							{  $tempSearchFlds[] = array($this->thirdTable .'.'. $tempField['data'], 'like', '%'. $tempSearchValue .'%');  }
						}
						break;
					case 'state_name':
					case 'state_code':
						$tempFieldList['normal'][] = $this->secondaryTable .'.'. $tempField['data'];
						if( strtolower($tempField['data']) == 'state_code' )
						{  $tempFieldList['normal'][] = $this->secondaryTable .'.state_id';  }
						if( isset($tempSearchValue) )
						{
							if( !empty($tempSearchValue) )
							{  $tempSearchFlds[] = array($this->secondaryTable .'.'. $tempField['data'], 'like', '%'. $tempSearchValue .'%');  }
						}
						break;
					default:
						$tempFieldList['normal'][] = $this->primaryTable .'.'. $tempField['data'];
						if( isset($tempSearchValue) )
						{
							if( strpos($tempField['data'], 'status') !== FALSE && is_numeric($tempSearchValue) )
							{  $tempSearchFlds[] = array($this->primaryTable .'.'. $tempField['data'], '=', $tempSearchValue);  }
							elseif( !empty($tempSearchValue) )
							{  $tempSearchFlds[] = array($this->primaryTable .'.'. $tempField['data'], 'like', '%'. $tempSearchValue .'%');  }
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
						case 'state_name':
						case 'state_code':
							$tempOrderList[$tempColumns[$this->secondaryTable .'.'.$tempField['column']]['data']] = $tempField['dir'];
							break;
						case 'country_name':
						case 'country_code':
							$tempOrderList[$tempColumns[$this->thirdTable .'.'.$tempField['column']]['data']] = $tempField['dir'];
							break;
						default:
							$tempOrderList[$tempColumns[$tempField['column']]['data']] = $tempField['dir'];
					}
				}
			}
			unset($tempField);
		}
		$cities = DB::table($this->primaryTable)
					->join($this->secondaryTable, $this->primaryTable.'.state_id', '=', $this->secondaryTable.'.state_id')
					->join($this->thirdTable, $this->secondaryTable.'.country_code', '=', $this->thirdTable.'.country_code')
					->where(array($this->secondaryTable .'.state_id' => $state_id, 
								  $this->secondaryTable .'.state_status' => $this->recordStatus,
								  $this->thirdTable .'.country_status' => $this->recordStatus))
					->select($tempFieldList['normal']);
		if( isset($tempFieldList['raw']) && is_array($tempFieldList['raw']) && !empty($tempFieldList['raw']) )
		{  $cities = $cities->addSelect(DB::raw(implode(',', $tempFieldList['raw'])));  }
		if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
		{  $cities = $cities->where($tempSearchFlds);  }
		if( isset($tempOrderList) && is_array($tempOrderList) && count($tempOrderList) > 0 )
		{
			foreach( $tempOrderList as $tempKey => $tempField )
			{  $cities = $cities->orderBy($tempKey, $tempField);  }
			unset($tempKey, $tempField);
		}
		$noOfRecords = $cities->count();
		$cities = $cities->offset($start)->limit($length);
		$cities = $cities->get();

		foreach($cities as $_key => $_value)
		{
			$_value = (array) $_value;
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
						$tempAction = '<a class="btn btn-info btn-xs" href="'. route('cities.edit', array($_value['state_id'], $temp_rowID)) .'" title="Edit Record"><i class="fa fa-pencil"></i>&nbsp;Edit</a>&nbsp;' . $tempAction;
						$tempDataArray = array_merge( $tempDataArray, array( $tempField['data'] => $tempAction ) );
					}
					elseif( strpos($tempField['data'], 'status') !== FALSE )
					{
						$tempStatus = '<span class="btn btn-warning btn-xs">Inactive</span>';
						if( isset($_value[$tempField['data']]) && !empty($_value[$tempField['data']]) )
						{
							$tempStatus = '<span class="btn btn-success btn-xs">Active&nbsp;&nbsp;&nbsp;</span>';
							$tempAction .= '<a class="btn btn-danger btn-xs" href="'. route('cities.delete', array($_value['state_id'], $temp_rowID)) .'" onclick="return confirm(\'Are you sure to delete?\')" title="Delete Record"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>';
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

	// add form for cities
	public function addedit($state_id = null, $id = null){
		$city_data = array('city_name' => '', 'state_id' => '', 'city_status' => $this->recordStatus, 
							'city_status_check' => '', 'city_id' => 0, 'form_url' => route('cities.insert'));
		$states_list = DB::table($this->secondaryTable)
							->join($this->thirdTable, $this->secondaryTable.'.country_code', '=', $this->thirdTable.'.country_code')
							->where(array($this->secondaryTable .'.state_id' => $state_id, 
										  $this->secondaryTable .'.state_status' => $this->recordStatus,
										  $this->thirdTable .'.country_status' => $this->recordStatus))
							->select($this->secondaryTable.'.state_id', $this->secondaryTable.'.state_name', $this->thirdTable.'.country_name')
							->orderBy($this->secondaryTable .'.state_name', 'asc')->get();
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			$cities = City::find($id);
			if( isset($cities->city_name) && !empty($cities->city_name) )
			{  $city_data['city_name'] = $cities->city_name;  }
			if( isset($cities->state_id) && !empty($cities->state_id) )
			{  $city_data['state_id'] = $cities->state_id;  }
			if( isset($cities->city_status) && is_numeric($cities->city_status) )
			{  $city_data['city_status'] = $cities->city_status;  }
			$city_data['city_id'] = $id;
			$city_data['form_url'] = route('cities.update', $id);
		}

		if( old('city_name') !== null )
		{  $city_data['city_name'] = old('city_name');  }
		if( old('state_id') !== null )
		{  $city_data['state_id'] = old('state_id');  }
		if( old('city_status') !== null )
		{  $city_data['city_status'] = old('city_status');  }
		if( isset($city_data['city_status']) && !empty($city_data['city_status']) )
		{  $city_data['city_status_check'] = "checked";  }
		return view('cities.addedit', ['cities' => $city_data, 'states_list' => $states_list, 'entry_state_id' => $state_id]);
	}

	// save data for cities
	public function savedata($id = null, Request $request){
		// validate post data
		$this->validate($request, [
			'city_name' => 'required|unique:'. $this->primaryTable .',NULL,'. $id .',city_id,state_id,'. $request['state_id'],
			'state_id' => 'required'
		]);
		// get post data
		$postData = $request->all();
		if( !isset($postData['city_status']) || empty($postData['city_status']) || !is_numeric($postData['city_status']) )
		{  $postData['city_status'] = 0;  }
		
		$msgText = "City details added successfully!";
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			// update data
			City::find($id)->update($postData);
			$msgText = "City details updated successfully!";
		}
		else
		{
			// insert data
			City::create($postData);
		}

		// store status message
		Session::flash('success_msg', $msgText);
		return redirect()->route('cities.index', array($postData['state_id']));
	}

	// delete data for states
	public function delete($state_id = null, $id = null){
		// updating city_status to inactive as 0, and deleted_at as current datetime
		DB::table($this->primaryTable)->where('city_id', $id)->update(array('city_status' => 0, 'deleted_at' => date('Y-m-d H:i:s')));

		// store status message
		Session::flash('success_msg', 'City details deleted successfully!');
		return redirect()->route('cities.index', $state_id);
	}

	//  clone of index function to send response for ajax request of cities
	public function ajaxCall($state_id = null){
		// fetch all cities data
		$cities = DB::table($this->primaryTable)
					->join($this->secondaryTable, $this->primaryTable.'.state_id', '=', $this->secondaryTable.'.state_id')
					->join($this->thirdTable, $this->secondaryTable.'.country_code', '=', $this->thirdTable.'.country_code')
					->where(array($this->secondaryTable .'.state_id' => $state_id, 
								  $this->secondaryTable .'.state_status' => $this->recordStatus,
								  $this->thirdTable .'.country_status' => $this->recordStatus))
					->select($this->primaryTable .'.*', $this->secondaryTable .'.state_name', $this->secondaryTable .'.state_id', 
							 $this->thirdTable .'.country_name', $this->secondaryTable.'.state_code', $this->thirdTable .'.country_code')
					->orderBy($this->primaryTable .'.city_name', 'asc')->get();
		$country_code = DB::table($this->secondaryTable)->where(array('state_id' => $state_id))->get()->first();
		if( isset($country_code->country_code) && !empty($country_code->country_code) )
		{  $country_code = $country_code->country_code;  }
		else{  $country_code = "";  }
		// pass cities data to view and load list view
		echo $cities;

		//return view('cities.index', ['cities' => $cities, 'country_code' => $country_code, 'state_id' => $state_id]);
	}
}