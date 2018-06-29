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