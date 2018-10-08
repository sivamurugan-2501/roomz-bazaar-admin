<?php

namespace App\Http\Controllers;
use App\Roles;
use App\BackendPermissions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
class RolesController extends Controller
{
    private $recordStatus = 1;
    private $primaryTableName = 'backend_roles';
    public function __construct(){
        $this->middleware('auth');
    }
    
    // display list of roles
    public function index(){
    	// pass roles data to view and load list view
    	return view('roles.index', ['roles' => array()]);
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

        $Roles = Roles::select($tempFieldList['normal']);
        if( isset($tempFieldList['raw']) && is_array($tempFieldList['raw']) && !empty($tempFieldList['raw']) )
        {  $Roles = $Roles->addSelect(DB::raw(implode(',', $tempFieldList['raw'])));  }
        if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
        {  $Roles = $Roles->where($tempSearchFlds);  }
        if( isset($tempOrderList) && is_array($tempOrderList) && count($tempOrderList) > 0 )
        {
            foreach( $tempOrderList as $tempKey => $tempField )
            {  $Roles = $Roles->orderBy($tempKey, $tempField);  }
            unset($tempKey, $tempField);
        }
        $Roles = $Roles->offset($start)->limit($length);
        $Roles = $Roles->get();

        if( isset($tempSearchFlds) && is_array($tempSearchFlds) && count($tempSearchFlds) > 0 )
        {  $noOfRecords = Roles::where($tempSearchFlds)->count();  }
        else{  $noOfRecords = Roles::count();  }

        foreach($Roles as $_key => $_value)
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
                        $tempAction = '<a class="btn btn-info btn-xs" href="'. route('roles.edit', $temp_rowID) .'" title="Edit Record"><i class="fa fa-pencil"></i>&nbsp;Edit</a>&nbsp;' . $tempAction;
                        $tempDataArray = array_merge( $tempDataArray, array( $tempField['data'] => $tempAction ) );
                    }
                    elseif( strpos($tempField['data'], 'status') !== FALSE )
                    {
                        $tempStatus = '<span class="btn btn-warning btn-xs">Inactive</span>';
                        if( isset($_value[$tempField['data']]) && !empty($_value[$tempField['data']]) )
                        {
                            $tempStatus = '<span class="btn btn-success btn-xs">Active&nbsp;&nbsp;&nbsp;</span>';
                            $tempAction .= '<a class="btn btn-danger btn-xs" href="'. route('roles.delete', $temp_rowID) .'" onclick="return confirm(\'Are you sure to delete?\')" title="Delete Record"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>';
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

    // add form for roles
    public function addedit($id = null){
        /*$permissions = BackendPermissions::where('permission_status', '=', '1')
                                        ->orderBy('module_id', 'asc')
                                        ->orderBy('permission_label', 'asc')->get();*/
        $permissions = DB::table('backend_permissions')
                            ->join('backend_permission_module', 'backend_permissions.module_id', '=', 'backend_permission_module.module_id')
                            ->leftjoin('backend_role_permission', function($join) use ($id){
                                $join->on('backend_permissions.permission_key', '=', 'backend_role_permission.permission_key')
                                     ->on('backend_role_permission.role_id', '=', DB::raw((int) $id));
                            })
                            ->select('backend_permissions.*', 'backend_permission_module.module_name', DB::raw(' CASE WHEN backend_role_permission.role_permission_status = 1 THEN "checked" ELSE "" END AS `role_permission_id`'))
                            ->where('backend_permissions.permission_status', '=', 1)
                            ->where('backend_permission_module.module_status', '=', 1)
                            ->get();
    	$roles_data = array('role_name' => '', 'role_status' => 1, 'role_status_check' => '', 'role_id' => 0, 'form_url' => route('roles.insert'), 'permissions' => $permissions);
    	if( isset($id) && !empty($id) && is_numeric($id) )
    	{
    		$roles = Roles::find($id);
    		if( isset($roles->role_name) && !empty($roles->role_name) )
			{  $roles_data['role_name'] = $roles->role_name;  }
			if( isset($roles->role_status) )
			{  $roles_data['role_status'] = $roles->role_status;  }
			$roles_data['role_id'] = $id;
			$roles_data['form_url'] = route('roles.update', $id);
    	}

    	if( old('role_name') !== null )
		{  $roles_data['role_name'] = old('role_name');  }
		if( old('role_status') !== null )
		{  $roles_data['role_status'] = old('role_status');  }
		if( isset($roles_data['role_status']) && !empty($roles_data['role_status']) )
		{  $roles_data['role_status_check'] = "checked";  }
		return view('roles.addedit', ['roles' => $roles_data]);
    }

    // save data for roles
    public function savedata($id = null, Request $request){
    	// validate post data
    	$this->validate($request, [
    		'role_name' => 'required|unique:'.$this->primaryTableName.',NULL,'.$id.',role_id',
		]);
		// get post data
		$postData = $request->all();
		if( !isset($postData['role_status']) || empty($postData['role_status']) || !is_numeric($postData['role_status']) )
		{  $postData['role_status'] = 0;  }
        // echo '<br>post data=<pre>'. print_r($postData, true) .'</pre><br>';
        
		$msgText = "Role details added successfully!";
		if( isset($id) && !empty($id) && is_numeric($id) )
		{
			// update data
			Roles::find($id)->update($postData);
            $role_id = $id;
			$msgText = "Role details updated successfully!";
		}
		else
		{
			// insert data
			$role_id = Roles::create($postData)->role_id;
		}
        
        if( isset($role_id) && !empty($role_id) && is_numeric($role_id) && isset($postData['permissions']) && is_array($postData['permissions']) && count($postData['permissions']) > 0 )
        {
            $postData['permissions'] = array_unique($postData['permissions']);

            // adding or update permissions against inserted, updated role id
            if( !isset($postData['permissions']) || !is_array($postData['permissions']) || count($postData['permissions']) == 0 )
            {  $postData['permissions'] = array('-1');  }

            // Step 1: Updating permissions as inactive, which are currently not present in an array permissions
            DB::table('backend_role_permission')
                        ->where('role_id', $role_id)
                        ->whereNotIn('permission_key', $postData['permissions'])
                        ->update(['role_permission_status' => 0]);
            
            // Step 2: Updating permissions as active, which are currently present in an array permissions
            DB::table('backend_role_permission')
                        ->where('role_id', $role_id)
                        ->whereIn('permission_key', $postData['permissions'])
                        ->update(['role_permission_status' => 1]);
            $result_known_permissions = DB::table('backend_role_permission')
                                        ->where('role_id', $role_id)
                                        ->whereIn('permission_key', $postData['permissions'])
                                        ->select('permission_key')->get();
            $known_permissions = array();
            if( isset($result_known_permissions) && count($result_known_permissions) > 0 )
            {
                foreach($result_known_permissions as $_value)
                {  $known_permissions[] = $_value->permission_key;  }
                unset($_value, $result_known_permissions);
            }
            
            // Step 3: Extra array new_permissions will have difference of elements which are not present DB & current array elements from permissions
            $new_permissions = array_diff($postData['permissions'], $known_permissions);
            if( is_array($new_permissions) && count($new_permissions) > 0 )
            {
                foreach($new_permissions as $_key => $_value)
                {
                    $new_permissions[$_key] = array('role_id' => $role_id, 'permission_key' => $_value);
                }
                unset($_key, $_value);
                DB::table('backend_role_permission')
                            ->insert($new_permissions);
            }
            unset($new_permissions);
        }

		// store status message
		Session::flash('success_msg', $msgText);
		return redirect()->route('roles.index');
    }

    // delete data for roles
    public function delete($id){
    	// updating role_status to inactive as 0, and deleted_at as current datetime
    	DB::table($this->primaryTableName)->where('role_id', $id)->update(array('role_status' => 0, 'deleted_at' => date('Y-m-d H:i:s')));

    	// store status message
    	Session::flash('success_msg', 'Role details deleted successfully!');
    	return redirect()->route('roles.index');
    }
}