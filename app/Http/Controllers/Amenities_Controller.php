<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Amenities;
use Illuminate\Http\Request;

class Amenities_Controller extends Controller{

	 public function __construct(){
        $this->middleware('auth');
    }

	public function show($mode = 0, $id=0){
		$param =  ($mode) ? ["mode" => $mode] : [];
		$param =  ($id) ? ["id" => $id] : $param;
		return view('portal.master.amenities',$param);
	}

	public function update_form($id){
		$param =  ($id) ? ["id" => $id] : [];
		return view('portal.master.amenities',$param);
	}

	public function add(Request $request){
		$validatedData = $this->validate($request,[
	        'name' => 'required|unique:master_amenities|min:2|max:255',
	        'icon_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    	]);

		$amenities = new Amenities;
		$amenities->name = $request->name;
		$file = $request->file('icon_path');
		if(isset($file) && $file!==null){
			 $destinationPath = 'public/portal/uploads/amenities';
			 $destinationPath = "uploads";
			 $fileType= explode("/",$file->getMimeType());
			 $desiredFilename = $request->name.".".$fileType[1];
     		 $file->move($destinationPath,$desiredFilename);
			 $amenities->icon_path = $destinationPath."/".$desiredFilename;
		}else{
			$amenities->icon_path = false;
		}
		$amenities->created_by =1;
		$amenities->save();

		$message = "New data saved successfully.";
		$action_message = [];
		$action_message["status"] = "OK";
		$action_message["message"] = $message;

		return redirect(route('master_amenities'))->with("action_message",json_encode($action_message));
    }

    public function update(Request $request){
    	$id = $request->id;
		if(isset($id) && $id>0 ){
			$amenities = new Amenities;
			$amenities = $amenities::find($id);
			$amenities->name = $request->name;
			$amenities->icon_path = $request->icon_path;
			$amenities->created_by =1;
			$amenities->save();

			$message = "New data saved successfully.";
			$action_message = [];
			$action_message["status"] = "OK";
			$action_message["message"] = $message;
		}else{
			$message = "Error";
			$action_message = [];
			$action_message["status"] = "ERR";
			$action_message["message"] = $message;
		}
		return redirect(route('master_amenities'))->with("action_message",json_encode($action_message));;
		// $validatedData = $request->validate([
	 //        'name' => 'required|unique:name|min:2|max:255',
	 //        'icon_path' => 'nullable|string'
  	//   	]);
    }
}