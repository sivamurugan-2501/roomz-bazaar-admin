<?php

namespace App\Http\Controllers;
use App\BackendUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
class BackendUsersController extends Controller
{
	private $recordStatus = 1;
	private $primaryTable = 'backend_users';
	public function __construct(){
		$this->middleware('auth');
	}

	// display list of available admin panel users
	public function index(){
		// pass backend users data to view and load list view
		return view('backendusers.index', ['backendUsers' => array()]);
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

		$backendusers = BackendUsers::select($tempFieldList['normal']);
		if( isset($tempFieldList['raw']) && is_array($tempFieldList['raw']) && !empty($tempFieldList['raw']) )
		{  $backendusers = $backendusers->addSelect(DB::raw(implode(',', $tempFieldList['raw'])));  }
		if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
		{  $backendusers = $backendusers->where($tempSearchFlds);  }
		if( isset($tempOrderList) && is_array($tempOrderList) && count($tempOrderList) > 0 )
		{
			foreach( $tempOrderList as $tempKey => $tempField )
			{  $backendusers = $backendusers->orderBy($tempKey, $tempField);  }
			unset($tempKey, $tempField);
		}
		$backendusers = $backendusers->offset($start)->limit($length);
		$backendusers = $backendusers->get();

        if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
        {  $noOfRecords = BackendUsers::where($tempSearchFlds)->count();  }
        else{  $noOfRecords = BackendUsers::count();  }

		foreach($backendusers as $_key => $_value)
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
						$tempAction = '<a class="btn btn-info btn-xs" href="'. route('backendusers.edit', $temp_rowID) .'" title="Edit Record"><i class="fa fa-pencil"></i>&nbsp;Edit</a>&nbsp;' . $tempAction;
						$tempDataArray = array_merge( $tempDataArray, array( $tempField['data'] => $tempAction ) );
					}
					elseif( strpos($tempField['data'], 'status') !== FALSE )
					{
						$tempStatus = '<span class="btn btn-warning btn-xs">Inactive</span>';
						if( isset($_value[$tempField['data']]) && !empty($_value[$tempField['data']]) )
						{
							$tempStatus = '<span class="btn btn-success btn-xs">Active&nbsp;&nbsp;&nbsp;</span>';
							$tempAction .= '<a class="btn btn-danger btn-xs" href="'. route('backendusers.delete', $temp_rowID) .'" onclick="return confirm(\'Are you sure to delete?\')" title="Delete Record"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>';
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

	// add form for backend(admin panel) users
	public function addedit($id = null){
		$backendusers_data = array('user_name' => '', 'user_email' => '', 'user_status' => 1, 'user_status_check' => '', 'user_id' => 0, 
								   'require_password_change' => 0, 'require_password_change_check' => '', 
								   'user_send_notification' => 0, 'user_send_notification_check' => '', 'form_url' => route('backendusers.insert'));
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			$backendusers = BackendUsers::find($id);
			if( isset($backendusers->user_name) && !empty($backendusers->user_name) )
			{  $backendusers_data['user_name'] = $backendusers->user_name;  }
			if( isset($backendusers->user_email) && !empty($backendusers->user_email) )
			{  $backendusers_data['user_email'] = $backendusers->user_email;  }
			if( isset($backendusers->user_status) )
			{  $backendusers_data['user_status'] = $backendusers->user_status;  }
			$backendusers_data['user_id'] = $id;
			$backendusers_data['form_url'] = route('backendusers.update', $id);
		}

		if( old('user_name') !== null )
		{  $backendusers_data['user_name'] = old('user_name');  }
		if( old('user_email') !== null )
		{  $backendusers_data['user_email'] = old('user_email');  }
		if( old('user_status') !== null )
		{  $backendusers_data['user_status'] = old('user_status');  }
		if( old('require_password_change') !== null )
		{  $backendusers_data['require_password_change'] = old('require_password_change');  }
		if( old('user_send_notification') !== null )
		{  $backendusers_data['user_send_notification'] = old('user_send_notification');  }

		if( isset($backendusers_data['user_status']) && !empty($backendusers_data['user_status']) )
		{  $backendusers_data['user_status_check'] = "checked";  }
		if( isset($backendusers_data['require_password_change']) && !empty($backendusers_data['require_password_change']) )
		{  $backendusers_data['require_password_change_check'] = "checked";  }
		if( isset($backendusers_data['user_send_notification']) && !empty($backendusers_data['user_send_notification']) )
		{  $backendusers_data['user_send_notification_check'] = "checked";  }
		return view('backendusers.addedit', ['backendusers' => $backendusers_data]);
	}

	// save data for backend(admin panel) users
	public function savedata($id = null, Request $request){
		$arrValidation = array('user_name' => 'required|string|max:255',
							   'user_email' => 'required|string|email|max:191|unique:'. $this->primaryTable .',NULL,'.$id.',user_id');
		if( !isset($id) || empty($id) || !is_numeric($id) )
		{
			$arrValidation = array_merge($arrValidation, array('user_password' => 'required|min:8'));
		}
		// validate post data
		$this->validate($request, $arrValidation);

		// get post data
		$postData = $request->all();
		if( !isset($postData['user_status']) || empty($postData['user_status']) || !is_numeric($postData['user_status']) )
		{  $postData['user_status'] = 0;  }
		if( !isset($postData['require_password_change']) || empty($postData['require_password_change']) || !is_numeric($postData['require_password_change']) )
		{  $postData['require_password_change'] = 0;  }
		if( isset($postData['user_password']) && !empty($postData['user_password']) )
		{  $postData['user_password'] = bcrypt($postData['user_password']);  }

		$msgText = "User details added successfully!";
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			// update data
			BackendUsers::find($id)->update($postData);
			$msgText = "User details updated successfully!";
		}
		else
		{
			// insert data
			BackendUsers::create($postData);
		}

		if( isset($postData['user_send_notification']) && !empty($postData['user_send_notification']) && is_numeric($postData['user_send_notification']) )
		{
			// Send email notification to user
			;
		}

		// store status message
		Session::flash('success_msg', $msgText);
		return redirect()->route('backendusers.index');
	}

    // delete data for backend users
    public function delete($id){
    	// updating user_status to inactive as 0, and deleted_at as current datetime
    	DB::table($this->primaryTable)->where('user_id', $id)->update(array('user_status' => 0, 'deleted_at' => date('Y-m-d H:i:s')));

    	// store status message
    	Session::flash('success_msg', 'User details deleted successfully!');
    	return redirect()->route('backendusers.index');
    }
}