<?php

namespace App\Http\Controllers;
use App\State;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
class StatesController extends Controller
{
	private $recordStatus = 1;
	private $primaryTable = 'state_master';
	private $secondaryTable = 'country_master';
	public function __construct(){
		$this->middleware('auth');
	}
	
    // display list of states based on country parameter passed
    public function index($country_code = null){
		// pass states data to view and load list view
		return view('states.index', ['states' => array(), 'country_code' => $country_code]);
    }
    
    public function searchcities(Request $request){
        $err_flag = 0;
        $err_msg = array();

        // get post data
        $postData = $request->all();
        $arrCities = array();

        if( !isset($postData['state_id']) || empty($postData['state_id']) || !is_numeric($postData['state_id']) ) {
            $err_flag = 1;
            $err_msg[] = 'State details not found';
        }

        if( $err_flag == 0 ) {
            $cities_arr = DB::table('city_master')
                         ->join('state_master', 'state_master.state_id', '=', 'city_master.state_id')
                         ->where(array('state_master.state_id' => $postData['state_id']))
                         ->select(array('city_master.city_id', 'city_master.city_name'))
                         ->orderBy('city_master.city_name', 'asc')->get();
            if( $cities_arr ) {
                foreach($cities_arr as $city_key => $city_value) {
                    $arrCities[] = (array) $city_value;
                }
                unset($city_key, $city_value);
            }
            unset($cities_arr);
        }
        echo json_encode(array('err_flag' => $err_flag, 'err_msg' => $err_msg, 'states' => $arrCities));
    }

	public function search(Request $request){
		// get post data
		$postData = $request->all();
		$country_code = null;
		if( isset($postData['extras']) && is_array($postData['extras']) && count($postData['extras']) > 0 )
		{
			foreach($postData['extras'] as $e_key => $e_value)
			{
				switch($e_value['name'])
				{
					case 'country_code':
						$country_code = $e_value['value'];
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
						$tempFieldList['raw'][] = " DATE_FORMAT(created_at, '%d %M %Y') AS created_on ";
						break;
					case 'country_name':
						$tempFieldList['normal'][] = $this->secondaryTable .'.'. $tempField['data'];
						$tempFieldList['normal'][] = $this->secondaryTable .'.country_id';
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
						case 'country_name':
							$tempOrderList[$tempColumns[$this->secondaryTable .'.'.$tempField['column']]['data']] = $tempField['dir'];
							break;
						default:
							$tempOrderList[$tempColumns[$tempField['column']]['data']] = $tempField['dir'];
					}
				}
			}
			unset($tempField);
		}
    	$states = DB::table($this->primaryTable)
					->join($this->secondaryTable, $this->primaryTable.'.country_code', '=', $this->secondaryTable.'.country_code')
					->where(array($this->secondaryTable .'.country_code' => $country_code, $this->secondaryTable .'.country_status' => $this->recordStatus))
					->select($tempFieldList['normal']);
		if( isset($tempFieldList['raw']) && is_array($tempFieldList['raw']) && !empty($tempFieldList['raw']) )
		{  $states = $states->addSelect(DB::raw(implode(',', $tempFieldList['raw'])));  }
		if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
		{  $states = $states->where($tempSearchFlds);  }
		if( isset($tempOrderList) && is_array($tempOrderList) && count($tempOrderList) > 0 )
		{
			foreach( $tempOrderList as $tempKey => $tempField )
			{  $states = $states->orderBy($tempKey, $tempField);  }
			unset($tempKey, $tempField);
		}
		$noOfRecords = $states->count();
		$states = $states->offset($start)->limit($length);
		$states = $states->get();

		foreach($states as $_key => $_value)
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
						$tempAction = '<a class="btn btn-info btn-xs" href="'. route('states.edit', array($_value['country_code'], $temp_rowID)) .'" title="Edit Record"><i class="fa fa-pencil"></i>&nbsp;Edit</a>&nbsp;' . $tempAction;
						$tempDataArray = array_merge( $tempDataArray, array( $tempField['data'] => $tempAction ) );
					}
					elseif( strpos($tempField['data'], 'status') !== FALSE )
					{
						$tempStatus = '<span class="btn btn-warning btn-xs">Inactive</span>';
						if( isset($_value[$tempField['data']]) && !empty($_value[$tempField['data']]) )
						{
							$tempStatus = '<span class="btn btn-success btn-xs">Active&nbsp;&nbsp;&nbsp;</span>';
							$tempAction .= '<a class="btn btn-danger btn-xs" href="'. route('states.delete', array($_value['country_code'], $temp_rowID)) .'" onclick="return confirm(\'Are you sure to delete?\')" title="Delete Record"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>';
							$tempAction .= '<a class="btn btn-primary btn-xs" href="'. route('cities.index', array($temp_rowID)) .'" title="View Cities"><i class="fa fa-sitemap"></i>&nbsp;Cities</a>';
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

	// add form for states
	public function addedit($country_code = null, $id = null){
		$state_data = array('state_name' => '', 'state_code' => '', 'country_code' => $country_code, 'state_status' => $this->recordStatus, 
							'state_status_check' => '', 'state_id' => 0, 'form_url' => route('states.insert'));
		$country_list = DB::table($this->secondaryTable)
							->where(array('country_code' => $country_code, 'country_status' => $this->recordStatus))
							->select($this->secondaryTable.'.country_code', $this->secondaryTable.'.country_name')
							->orderBy($this->secondaryTable .'.country_name', 'asc')->get();
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			$states = State::find($id);
			if( isset($states->state_name) && !empty($states->state_name) )
			{  $state_data['state_name'] = $states->state_name;  }
			if( isset($states->state_code) && !empty($states->state_code) )
			{  $state_data['state_code'] = $states->state_code;  }
			if( isset($states->country_code) && !empty($states->country_code) )
			{  $state_data['country_code'] = $states->country_code;  }
			if( isset($states->state_status) && is_numeric($states->state_status) )
			{  $state_data['state_status'] = $states->state_status;  }
			$state_data['state_id'] = $id;
			$state_data['form_url'] = route('states.update', $id);
		}

		if( old('state_name') !== null )
		{  $state_data['state_name'] = old('state_name');  }
		if( old('state_code') !== null )
		{  $state_data['state_code'] = old('state_code');  }
		if( old('country_code') !== null )
		{  $state_data['country_code'] = old('country_code');  }
		if( old('state_status') !== null )
		{  $state_data['state_status'] = old('state_status');  }
		if( isset($state_data['state_status']) && !empty($state_data['state_status']) )
		{  $state_data['state_status_check'] = "checked";  }
		return view('states.addedit', ['states' => $state_data, 'country_list' => $country_list, 'entry_country_code' => $country_code]);
	}

	// save data for states
	public function savedata($id = null, Request $request){
    	// validate post data
    	$this->validate($request, [
    		'state_name' => 'required|unique:'. $this->primaryTable .',NULL,'. $id .',state_id,country_code,'. $request['country_code'],
    		'state_code' => 'required|unique:'. $this->primaryTable .',NULL,'. $id .',state_id,country_code,'. $request['country_code'],
    		'country_code' => 'required'
		]);
		// get post data
		$postData = $request->all();
		if( !isset($postData['state_status']) || empty($postData['state_status']) || !is_numeric($postData['state_status']) )
		{  $postData['state_status'] = 0;  }

		$msgText = "State details added successfully!";
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			// update data
			State::find($id)->update($postData);
			$msgText = "State details updated successfully!";
		}
		else
		{
			// insert data
			State::create($postData);
		}

		// store status message
		Session::flash('success_msg', $msgText);
		return redirect()->route('states.index', $postData['country_code']);
	}

	// delete data for states
	public function delete($country_code = null, $id = null){
		// updating state_status to inactive as 0, and deleted_at as current datetime
		DB::table($this->primaryTable)->where('state_id', $id)->update(array('state_status' => 0, 'deleted_at' => date('Y-m-d H:i:s')));

		// store status message
		Session::flash('success_msg', 'State details deleted successfully!');
		return redirect()->route('states.index', $country_code);
	}
}