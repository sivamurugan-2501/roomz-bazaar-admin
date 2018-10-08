<?php

namespace App\Http\Controllers;
use App\PropertyTypeMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
class PropertyTypeMasterController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	// display list of property type master
	public function index(){
		// pass property type master data to view and load list view
		return view('propertytypemaster.index', ['property_type_master' => array()]);
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

        $PropertyTypeMaster = PropertyTypeMaster::select($tempFieldList['normal']);
        if( isset($tempFieldList['raw']) && is_array($tempFieldList['raw']) && !empty($tempFieldList['raw']) )
        {  $PropertyTypeMaster = $PropertyTypeMaster->addSelect(DB::raw(implode(',', $tempFieldList['raw'])));  }
        if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
        {  $PropertyTypeMaster = $PropertyTypeMaster->where($tempSearchFlds);  }
        if( isset($tempOrderList) && is_array($tempOrderList) && count($tempOrderList) > 0 )
        {
            foreach( $tempOrderList as $tempKey => $tempField )
            {  $PropertyTypeMaster = $PropertyTypeMaster->orderBy($tempKey, $tempField);  }
            unset($tempKey, $tempField);
        }
        $PropertyTypeMaster = $PropertyTypeMaster->offset($start)->limit($length);
        $PropertyTypeMaster = $PropertyTypeMaster->get();

        if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
        {  $noOfRecords = PropertyTypeMaster::where($tempSearchFlds)->count();  }
        else{  $noOfRecords = PropertyTypeMaster::count();  }

        foreach($PropertyTypeMaster as $_key => $_value)
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
                        $tempAction = '<a class="btn btn-info btn-xs" href="'. route('propertytypemaster.edit', $temp_rowID) .'" title="Edit Record"><i class="fa fa-pencil"></i>&nbsp;Edit</a>&nbsp;' . $tempAction;
                        $tempDataArray = array_merge( $tempDataArray, array( $tempField['data'] => $tempAction ) );
                    }
                    elseif( strpos($tempField['data'], 'status') !== FALSE )
                    {
                        $tempStatus = '<span class="btn btn-warning btn-xs">Inactive</span>';
                        if( isset($_value[$tempField['data']]) && !empty($_value[$tempField['data']]) )
                        {
                            $tempStatus = '<span class="btn btn-success btn-xs">Active&nbsp;&nbsp;&nbsp;</span>';
                            $tempAction .= '<a class="btn btn-danger btn-xs" href="'. route('propertytypemaster.delete', $temp_rowID) .'" onclick="return confirm(\'Are you sure to delete?\')" title="Delete Record"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>';
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

	// add form for property type master
	public function addedit($id = null){
		$property_type_data = array('type_name' => '', 'type_status' => 1, 'type_status_check' => '', 
							  'type_id' => 0, 'form_url' => route('propertytypemaster.insert'));
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			$property_types = PropertyTypeMaster::find($id);
			if( isset($property_types->type_name) && !empty($property_types->type_name) )
			{  $property_type_data['type_name'] = $property_types->type_name;  }
			if( isset($property_types->type_status) && is_numeric($property_types->type_status) )
			{  $property_type_data['type_status'] = $property_types->type_status;  }
			$property_type_data['type_id'] = $id;
			$property_type_data['form_url'] = route('propertytypemaster.update', $id);
		}

		if( old('type_name') !== null )
		{  $property_type_data['type_name'] = old('type_name');  }
		if( old('type_status') !== null )
		{  $property_type_data['type_status'] = old('type_status');  }
		if( isset($property_type_data['type_status']) && !empty($property_type_data['type_status']) )
		{  $property_type_data['type_status_check'] = "checked";  }
		return view('propertytypemaster.addedit', ['propertytypemaster' => $property_type_data]);
	}

	// save data for propertytypemaster
	public function savedata($id = null, Request $request){
    	// validate post data
    	$this->validate($request, [
    		'type_name' => 'required|unique:property_type_master,NULL,'. $id .',type_id'
		]);
		// get post data
		$postData = $request->all();
		if( !isset($postData['type_status']) || empty($postData['type_status']) || !is_numeric($postData['type_status']) )
		{  $postData['type_status'] = 0;  }

		$msgText = "Property type details added successfully!";
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			// update data
			PropertyTypeMaster::find($id)->update($postData);
			$msgText = "Property type details updated successfully!";
		}
		else
		{
			// insert data
			PropertyTypeMaster::create($postData);
		}

		// store status message
		Session::flash('success_msg', $msgText);
		return redirect()->route('propertytypemaster.index');
	}

	// delete data for propertytypemaster
	public function delete($id){
		// updating type_status to inactive as 0, and deleted_at as current datetime
		DB::table('property_type_master')->where('type_id', $id)->update(array('type_status' => 0, 'deleted_at' => date('Y-m-d H:i:s')));

		// store status message
		Session::flash('success_msg', 'Property type details deleted successfully!');
		return redirect()->route('propertytypemaster.index');
	}
}
