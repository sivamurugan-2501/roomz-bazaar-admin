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
        $generalinfo->name = $request->input('name');
        $generalinfo->property_type = $request->input('property_type');
        $generalinfo->show_as = $request->input('show_as');
        
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


        //$generalinfo->address = $request->input('address');
       // $generalinfo->state = $request->input('state');
        //$generalinfo->city = $request->input('city');
        //$generalinfo->landmark = $request->input('landmark');

         $generalinfo->per_square_feet =0;
        $generalinfo->tota_square_feet = 0;
        $generalinfo->carpet_area = 0;
        $generalinfo->usable_area = 0;
        $generalinfo->total_rate = 0;
        $generalinfo->negotiable = 0;

        $generalinfo->advance_deposite = 0;
        $generalinfo->rent_per_month = 0;
        $generalinfo->maintenance_include = 0;

        $generalinfo->parking = 0;
        $generalinfo->gym = 0;
        $generalinfo->furnishes = 0;
        $generalinfo->garden = 0;
        $generalinfo->others = "null";
        $generalinfo->water_supply = "null";

        $generalinfo->save();
        $id = $generalinfo->id;
        return redirect()->route('add-edit-property',['id' =>$id, 'step'=> 1]);
        /*if($id !=''){
            return redirect('online-property?section=1&id='.$id);
        }else{
            return redirect('online-property');
        }*/
        
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
        $generalinfo->advance_deposite = $request->input('advance_deposit');
        $generalinfo->rent_per_month = $request->input('rent_per_month');
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
}
