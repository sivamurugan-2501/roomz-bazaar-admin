<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralInfo;
class GeneralInfoController extends Controller
{
    //

    public function index(){
    	
    }

    public function addForm()
    {
    	return view('add-property');
    }

    public function addInsert(Request $request){
    	
        $generalinfo = new GeneralInfo;

        $step = $request->input("step");

        #find step number
        try{
            $step = (int)$step;
        }catch(Exception $e){}
        
        #Get id if set
        $id = $request->input("id");

        #if id is set, then get the data
        if(isset($id) && $id>0){
            $generalinfo = GeneralInfo::find($id);
            //var_dump($generalinfo);
        }else{
            $step =0;
        }

        $message = "";
        
        if($step == 0){
            $generalinfo->name = $request->input('name');
            $generalinfo->property_type = $request->input('property_type');
            $generalinfo->show_as = $request->input('show_as');

            if(strtolower($request->input('show_as')) == "pg"){
                $generalinfo->for_gender = $request->input("for_gender");
            }
            
            $generalinfo->total_floors = $request->input('total_floors');
            $generalinfo->floor_no = $request->input('floor_no');
            $transaction_type =  (int)$request->input('transaction_type');
            $generalinfo->transaction_type = $request->input('transaction_type');

            if($transaction_type === 1){
                    $possession_type = (int)$request->input("possession_type");
                    $generalinfo->possession_type = $possession_type;
                    if($possession_type===1){
                        $generalinfo->possession_year = $request->input('possession_year'); 
                    }
            }elseif($transaction_type===2){
                $generalinfo->age = $request->input('age');
            }

            $generalinfo->no_of_bedroom = $request->input('no_of_bedrooms');
            $generalinfo->no_of_bathroom = $request->input('no_of_bathrooms');
            $generalinfo->no_of_balcony = $request->input('no_of_balaconies');

            $step = 0;
            if($id>0){
                $message =  __("property.update.success",["name" => $generalinfo->name ]);
            }else{
                $message =  __("property.add.success",["name" => $generalinfo->name ]);
            }
        }elseif($step === 1){
           // die("else step : ".$step);
            $generalinfo->address = $request->input('address');
            $generalinfo->state = $request->input('state');
            $generalinfo->city = $request->input('city');
            $generalinfo->landmark = $request->input('landmark');
            $step =1;
            $message =  __("property.update.success",["name" => $generalinfo->name ]);
        }elseif($step === 2){
           // die("else step : ".$step);

            if(strtolower($generalinfo->show_as) == "sales"){
                //die("carpt area : ".$request->input('expected_price'));
                $generalinfo->carpet_area = $request->input('area_carpet');
                $generalinfo->usable_area = $request->input('area_builtUp');
                $generalinfo->includes_stamp_paper_charge = ($request->input('include_stampduty_charge')!==null && $request->input('include_stampduty_charge')!=="") ? $request->input('include_stampduty_charge') : 0; 

                $generalinfo->negotiable = ($request->input('negotiable')!==null && $request->input('negotiable')!=="") ? $request->input('negotiable') : 0;
                $generalinfo->total_rate = $request->input('expected_price');
                $generalinfo->other_charges = ($request->input('other_charges')!==null && $request->input('other_charges')!=="") ? $request->input('other_charges') : 0;
                //$step =2;
                $message =   __("property.update.success",["name" => $generalinfo->name ]);
            }elseif(strtolower($generalinfo->show_as) == "pg" || strtolower($generalinfo->show_as) == "rent" ){
                //die("carpt area : ".$request->input('expected_price'));
                $generalinfo->carpet_area = $request->input('area_carpet');
                $generalinfo->usable_area = $request->input('area_builtUp');
                $generalinfo->includes_maintenance = ($request->input('includes_maintenance')!==null && $request->input('includes_maintenance')!=="") ? $request->input('includes_maintenance') : 0; 
                if($generalinfo->includes_maintenance === 0){
                   $generalinfo->maintenance_charge =  ($request->input('maintenance_charge')!==null && $request->input('maintenance_charge')!=="") ? $request->input('maintenance_charge') : 0;
                }
                $generalinfo->negotiable = ($request->input('negotiable')!==null && $request->input('negotiable')!=="") ? $request->input('negotiable') : 0;

                $generalinfo->advance_deposit = ($request->input('advance_deposit')!==null) ? $request->input('advance_deposit') : 0;
                $generalinfo->rent = ($request->input('rent')!==null) ? $request->input('rent') : 0;
                $generalinfo->maintenance_charge = ($request->input('maintenance_charge')!==null) ? $request->input('maintenance_charge') : 0;
                $message =   __("property.update.success",["name" => $generalinfo->name ]);
            }
            //die("here..".$generalinfo->show_as);
           
        }elseif($step === 3){
            $validatedData = $this->validate($request,[
                "amenities" => "required"
            ]);
            $amenities = $request->input("amenities");
            if(sizeof($amenities)>0){
                $amenities = json_encode($amenities);
                $generalinfo->amenities = $amenities;
            }
            
        }

        $action_message = [];
        $action_message["status"] = __("status.success");
        $action_message["message"] = $message;
        

        //$generalinfo->address = $request->input('address');
       // $generalinfo->state = $request->input('state');
        //$generalinfo->city = $request->input('city');
        //$generalinfo->landmark = $request->input('landmark');

         $generalinfo->per_square_feet =0;
        $generalinfo->tota_square_feet = 0;
       
       /* $generalinfo->carpet_area = 0;
        $generalinfo->usable_area = 0;
        $generalinfo->total_rate = 0;
        $generalinfo->negotiable = 0;

        $generalinfo->advance_deposit = 0;
        $generalinfo->rent = 0;
        $generalinfo->includes_maintenance = 0;*/

        $generalinfo->parking = 0;
        $generalinfo->gym = 0;
        $generalinfo->furnishes = 0;
        $generalinfo->garden = 0;
        $generalinfo->others = "null";
        $generalinfo->water_supply = "null";

        $generalinfo->save();
        //die("step : ".$step);
        $id = $generalinfo->id;
        return redirect()->route('add-edit-property',[ 'id' =>$id, 'step'=> $step ])->with("action_message" , json_encode($action_message) );
	}

    public function addInsert1(Request $request,$id){
        $generalinfo = GeneralInfo::find($id);
        $generalinfo->per_square_feet = $request->input('per_square_feet');
        $generalinfo->tota_square_feet = $request->input('total_square_feet');
        $generalinfo->carpet_area = $request->input('carpet_area');
        $generalinfo->usable_area = $request->input('usable_area');
        $generalinfo->total_rate = $request->input('total_rate');
        $generalinfo->negotiable = $request->input('negotiable');
        $generalinfo->save();
        if($id !=''){
            return redirect('online-property?section=2&id='.$id);
        }else{
            return redirect('online-property');
        }

    }

    public function addInsert2(Request $request,$id){
        $generalinfo = GeneralInfo::find($id);
        $generalinfo->advance_deposit = $request->input('advance_deposit');
        $generalinfo->rent = $request->input('rent_per_month');
        $generalinfo->maintenance_include = $request->input('maintenance');
        $generalinfo->save();
        if($id !=''){
            return redirect('online-property?section=3&id='.$id);
        }else{
            return redirect('online-property');
        }
    }

    public function addInsert3(Request $request,$id){
        $generalinfo = GeneralInfo::find($id);
        $generalinfo->parking = $request->input('parking');
        $generalinfo->gym = $request->input('gym');
        $generalinfo->furnishes = $request->input('furnishes');
        $generalinfo->garden = $request->input('garden');
        $generalinfo->others = $request->input('other');
        $generalinfo->save();
        if($id !=''){
            return redirect('list_view/'.$id);
        }else{
            return redirect('online-property');
        }
    }

	public function listView($id){
		$data = GeneralInfo::find($id);

		return view('property-view')->with('data',$data);
	}

    public function editUpdate($id){
       $edata = GeneralInfo::find($id);
       return view('edit-view')->with('edata',$edata);
    }

    public function addUpdate(Request $request,$id){
      /*$this->validate($request, [
            'name' => 'required',
            'property_type'=>'required',
            'show_as' => 'required',
            'address'=>'required',
            'state'=>'required',
            'city'=>'required',
            'landmark'=>'required',
            'age'=>'required',
            'totalfloor'=>'required',
            'floorno'=>'required',
        ]);*/

        
        $generalinfo = GeneralInfo::find($id);
        $generalinfo->name = $request->input('name');
        $generalinfo->property_type = $request->input('property_type');
        $generalinfo->show_as = $request->input('show_as');
        $generalinfo->address = $request->input('address');
        $generalinfo->state = $request->input('state');
        $generalinfo->city = $request->input('city');
        $generalinfo->landmark = $request->input('landmark');
        $generalinfo->age = $request->input('age');
        $generalinfo->total_floors = $request->input('total_floors');
        $generalinfo->floor_no = $request->input('floor_no');
        $generalinfo->save();
        $id = $generalinfo->id;

        if($id!=''){
            return redirect('/edit/'.$id.'?section=1');
        }else{
            return redirect('/edit/'.$id);
        }
       
    }
    public function addUpdate2(Request $request,$id)
    {
        $generalinfo = GeneralInfo::find($id);
        $generalinfo->per_square_feet = $request->input('per_square_feet');
        $generalinfo->tota_square_feet = $request->input('total_square_feet');
        $generalinfo->carpet_area = $request->input('carpet_area');
        $generalinfo->usable_area = $request->input('usable_area');
        $generalinfo->total_rate = $request->input('total_rate');
        $generalinfo->negotiable = $request->input('negotiable');
        $generalinfo->save();
        if($id!=''){
            return redirect('/edit/'.$id.'?section=2');
        }else{
            return redirect('/edit/'.$id);
        }
    }

    public function addUpdate3(Request $request,$id)
    {
        $generalinfo = GeneralInfo::find($id);
        $generalinfo->advance_deposite = $request->input('advance_deposit');
        $generalinfo->rent_per_month = $request->input('rent_per_month');
        $generalinfo->maintenance_include = $request->input('maintenance');
        $generalinfo->save();

        if($id!=''){
            return redirect('/edit/'.$id.'?section=3');
        }else{
            return redirect('/edit/'.$id);
        }
    }

    public function addUpdate4(Request $request,$id)
    {

        $generalinfo = GeneralInfo::find($id);
        $generalinfo->parking = $request->input('parking');
        $generalinfo->gym = $request->input('gym');
        $generalinfo->furnishes = $request->input('furnishes');
        $generalinfo->garden = $request->input('garden');
        $generalinfo->others = $request->input('other');
        $generalinfo->save();
        if($id !=''){
            return redirect('list_view/'.$id);
        }else{
            return redirect('/edit/'.$id);
        }
    }

    public function addDelete($id){
        
        GeneralInfo::newDelete($id);
        return redirect('online-property');
    }

    public function listProperty(){
        $list_properties = GeneralInfo::where("status",1)->get();
        return view("property-view")->with("list_properties",$list_properties);
    }
}
