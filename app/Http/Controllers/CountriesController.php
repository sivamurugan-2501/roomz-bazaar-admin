<?php

namespace App\Http\Controllers;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
class CountriesController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	// display list of countries
	public function index(){
		// pass countries data to view and load list view
		return view('countries.index', ['countries' => array()]);
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

        $Country = Country::select($tempFieldList['normal']);
        if( isset($tempFieldList['raw']) && is_array($tempFieldList['raw']) && !empty($tempFieldList['raw']) )
        {  $Country = $Country->addSelect(DB::raw(implode(',', $tempFieldList['raw'])));  }
        if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
        {  $Country = $Country->where($tempSearchFlds);  }
        if( isset($tempOrderList) && is_array($tempOrderList) && count($tempOrderList) > 0 )
        {
            foreach( $tempOrderList as $tempKey => $tempField )
            {  $Country = $Country->orderBy($tempKey, $tempField);  }
            unset($tempKey, $tempField);
        }
        $Country = $Country->offset($start)->limit($length);
        $Country = $Country->get();

        if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
        {  $noOfRecords = Country::where($tempSearchFlds)->count();  }
        else{  $noOfRecords = Country::count();  }

        foreach($Country as $_key => $_value)
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
                        $tempAction = '<a class="btn btn-info btn-xs" href="'. route('countries.edit', $temp_rowID) .'" title="Edit Record"><i class="fa fa-pencil"></i>&nbsp;Edit</a>&nbsp;' . $tempAction;
                        $tempDataArray = array_merge( $tempDataArray, array( $tempField['data'] => $tempAction ) );
                    }
                    elseif( strpos($tempField['data'], 'status') !== FALSE )
                    {
                        $tempStatus = '<span class="btn btn-warning btn-xs">Inactive</span>';
                        if( isset($_value[$tempField['data']]) && !empty($_value[$tempField['data']]) )
                        {
                            $tempStatus = '<span class="btn btn-success btn-xs">Active&nbsp;&nbsp;&nbsp;</span>';
                            $tempAction .= '<a class="btn btn-danger btn-xs" href="'. route('countries.delete', $temp_rowID) .'" onclick="return confirm(\'Are you sure to delete?\')" title="Delete Record"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>';
                            $tempAction .= '<a class="btn btn-primary btn-xs" href="'. route('states.index', $_value['country_code']) .'" title="View States"><i class="fa fa-sitemap"></i>&nbsp;States</a>';
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

	// add form for countries
	public function addedit($id = null){
		$country_data = array('country_name' => '', 'country_code' => '', 'country_status' => 1, 'country_status_check' => '', 
							  'country_id' => 0, 'form_url' => route('countries.insert'));
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			$countries = Country::find($id);
			if( isset($countries->country_name) && !empty($countries->country_name) )
			{  $country_data['country_name'] = $countries->country_name;  }
			if( isset($countries->country_code) && !empty($countries->country_code) )
			{  $country_data['country_code'] = $countries->country_code;  }
			if( isset($countries->country_status) && is_numeric($countries->country_status) )
			{  $country_data['country_status'] = $countries->country_status;  }
			$country_data['country_id'] = $id;
			$country_data['form_url'] = route('countries.update', $id);
		}

		if( old('country_name') !== null )
		{  $country_data['country_name'] = old('country_name');  }
		if( old('country_code') !== null )
		{  $country_data['country_code'] = old('country_code');  }
		if( old('country_status') !== null )
		{  $country_data['country_status'] = old('country_status');  }
		if( isset($country_data['country_status']) && !empty($country_data['country_status']) )
		{  $country_data['country_status_check'] = "checked";  }
		return view('countries.addedit', ['countries' => $country_data]);
	}

	// save data for countries
	public function savedata($id = null, Request $request){
    	// validate post data
    	$this->validate($request, [
    		'country_name' => 'required|unique:country_master,NULL,'. $id .',country_id',
    		'country_code' => 'required|unique:country_master,NULL,'. $id .',country_id'
		]);
		// get post data
		$postData = $request->all();
		if( !isset($postData['country_status']) || empty($postData['country_status']) || !is_numeric($postData['country_status']) )
		{  $postData['country_status'] = 0;  }

		$msgText = "Country details added successfully!";
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			// update data
			Country::find($id)->update($postData);
			$msgText = "Country details updated successfully!";
		}
		else
		{
			// insert data
			Country::create($postData);
		}

		// store status message
		Session::flash('success_msg', $msgText);
		return redirect()->route('countries.index');
	}

	// delete data for countries
	public function delete($id){
		// updating country_status to inactive as 0, and deleted_at as current datetime
		DB::table('country_master')->where('country_id', $id)->update(array('country_status' => 0, 'deleted_at' => date('Y-m-d H:i:s')));

		// store status message
		Session::flash('success_msg', 'Country details deleted successfully!');
		return redirect()->route('countries.index');
	}
}