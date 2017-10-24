<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class GeneralInfo extends Model
{
    //
    protected $table='property';
    protected $token ='_token';
    public $def_limit = 20;

    static function newCreate($request)
    {
    	$generalinfo = new GeneralInfo;
    	$generalinfo->name = $request['name'];
    	$generalinfo->prperty_type = $request['property_type'];
    	$generalinfo->show_as = $request['show_as'];
    	$generalinfo->address = $request['address'];
    	$generalinfo->state = $request['state'];
    	$generalinfo->city = $request['city'];
    	$generalinfo->landmark = $request['landmark'];
    	$generalinfo->age = $request['age'];
    	$generalinfo->total_floors = $request['totalfloor'];
    	$generalinfo->floor_no = $request['floorno'];
    	$generalinfo->per_square_feet = $request['per_squar_feet'];
    	$generalinfo->tota_square_feet = $request['total_square_feet'];
    	$generalinfo->carpet_area = $request['carpet_area'];
    	$generalinfo->usable_area = $request['usable_area'];
    	$generalinfo->negotiable = $request['negotiable'];
    	$generalinfo->total_rate = $request['total_rate'];
    	$generalinfo->advance_deposite = $request['addvance_deposite'];
    	$generalinfo->rent_per_month = $request['rent_per_month'];
    	$generalinfo->maintenance_include = $request['maintanence'];
    	$generalinfo->parking = $request['parking'];
    	$generalinfo->gym = $request['gym'];
    	$generalinfo->furnishes = $request['furnishes'];
    	$generalinfo->garden = $request['garden'];
    	$generalinfo->water_supply = $request['water_supply'];
    	$generalinfo->others = $request['other'];
    	$generalinfo->save();
    }

    static function newUpdate($request ,$id)
    {
        $propinfo = GeneralInfo::find($id);
        $propinfo->name = $request['name'];
        $propinfo->prperty_type = $request['property_type'];
        $propinfo->show_as = $request['show_as'];
        $propinfo->address = $request['address'];
        $propinfo->state = $request['state'];
        $propinfo->city = $request['city'];
        $propinfo->landmark = $request['landmark'];
        $propinfo->age = $request['age'];
        $propinfo->total_floors = $request['totalfloor'];
        $propinfo->floor_no = $request['floorno'];
        $propinfo->per_square_feet = $request['per_squar_feet'];
        $propinfo->tota_square_feet = $request['total_square_feet'];
        $propinfo->carpet_area = $request['carpet_area'];
        $propinfo->usable_area = $request['usable_area'];
        $propinfo->negotiable = $request['negotiable'];
        $propinfo->total_rate = $request['total_rate'];
        $propinfo->advance_deposite = $request['addvance_deposite'];
        $propinfo->rent_per_month = $request['rent_per_month'];
        $propinfo->maintenance_include = $request['maintanence'];
        $propinfo->parking = $request['parking'];
        $propinfo->gym = $request['gym'];
        $propinfo->furnishes = $request['furnishes'];
        $propinfo->garden = $request['garden'];
        $propinfo->water_supply = $request['water_supply'];
        $propinfo->others = $request['other'];
        $propinfo->save();
    }

    static function newDelete($id){
        DB::table('general_info')->delete($id);
    }

    /*
    * if $id = -1 then get all data else if > 0 fetch record with that id
    * default records limit will be set in def_limit 
   */
    public static function get($id=0, $limit =0){
        $data= false;
        $_this = new GeneralInfo;
        if(is_numeric($id)  && $id >0 ){
            /*$data=  App\GeneralInfo::where([ 
                                       // ["status","=","1"],
                                        ["id","=",$id]
                                   ])->get();*/
          $data=  GeneralInfo::find($id);    
        }elseif($id==-1){
            if(is_numeric($limit) && $limit >0 ){
                $limit = $_this->def_limit;
            }
            $data = GeneralInfo::where([ 
                                      //  ["status","=","1"]
                                   ])->take($limit)->get();  
        }
        return $data;
        
    }
}
