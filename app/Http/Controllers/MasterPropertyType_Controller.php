<?php

namespace App\Http\Controllers;

use App\MasterPropertyType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterPropertyType_Controller extends Controller{
	
	public function __construct(){
		$this->middleware("auth");
	}

	/*
	-	This controller handles the add request
	-	$request contains all the form data and the query parameters if any
	*/
	public function add(Request $request){
		//$masterPropertyType = new MasterPropertyType;
		/*$request->validate([
		    'name' => 'required|unique:posts|max:255',
		    'author.name' => 'required',
		    'author.description' => 'required',
		]);*/
		//  below function is defined in model - MasterPropertyType.php
		$message = "New data saved successfully.";
		$action_message = [];
		$action_message["status"] = "OK";
		$action_message["message"] = $message;

		MasterPropertyType::add($request);
		return redirect(route('manage-property-type'))->with("action_message",json_encode($action_message));;
	}

	/*
	-	This controller handles the edit request
	-	$request contains all the form data and the query parameters if any
	*/
	public static function update(Request $request){
		 $message = "Something went wrong.";
		 $action_message = [];
		 $action_message["status"] = "ERR";
		 if(isset($request->id) && $request->id>0 && is_numeric($request->id)){
		 	MasterPropertyType::edit($request);
		 	 $action_message["status"] = "OK";
		 	$message = "Data modified successfully.";
		 }
		 // once action is performed, it will be redirected to the view page
		 $action_message["message"] = $message;
		 return redirect(route('manage-property-type'))->with("action_message",json_encode($action_message));
	}
}