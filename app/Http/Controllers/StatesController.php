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

    // display list of states based on country parameter passed
    public function index($country_code = null){
    	// fetch all states data
    	// $states = State::orderBy('state_name', 'asc')->get();
    	$states = DB::table($this->primaryTable)
					->join($this->secondaryTable, $this->primaryTable.'.country_code', '=', $this->secondaryTable.'.country_code')
					->where(array($this->secondaryTable .'.country_code' => $country_code, $this->secondaryTable .'.country_status' => $this->recordStatus))
					->select($this->primaryTable .'.*', $this->secondaryTable .'.country_name', $this->secondaryTable .'.country_id')
					->orderBy($this->primaryTable .'.state_name', 'asc')->get();

		// pass states data to view and load list view
		return view('states.index', ['states' => $states, 'country_code' => $country_code]);
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