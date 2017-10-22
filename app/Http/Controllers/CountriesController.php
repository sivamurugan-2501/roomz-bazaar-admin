<?php

namespace App\Http\Controllers;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
class CountriesController extends Controller
{
	// display list of countries
	public function index(){
		// fetch all countries data
		$countries = Country::orderBy('country_name', 'asc')->get();

		// pass countries data to view and load list view
		return view('countries.index', ['countries' => $countries]);
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