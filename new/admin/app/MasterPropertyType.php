<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterPropertyType extends Model
{
    //
    protected $table = "master_property_type";
    public $timestamps = true;

    // Below function create a new property type record and save to database
    public static  function add($request){
    	$propertyType  = new MasterPropertyType;
    	$propertyType->name = $request->name;
    	$propertyType->is_parent = $request->is_parent;
    	if($request->is_parent ===1){
    		$propertyType->parent = 0;
    	}else{
            $propertyType->parent = $request->parent;
            $propertyType->is_parent = 0;
        }
    	$propertyType->created_by =1; // Auth::user()->id;

    	$propertyType->save();
    }

    public static function edit($request){
        if($request->id > 0){
            $id = $request->id;
            $instance = MasterPropertyType::find($id);
            $instance->name = $request->name;
            $instance->is_parent = $request->is_parent;
            if($request->is_parent ===1){
                $instance->parent = $request->parent;
            }else{
                $instance->is_parent = 0;
            }
            $instance->updated_by =1; // Auth::user()->id;
            $instance->save();
        }
    }

     # get ALL active property type
    public static function get($fields = ["name", ""]){
         $data_map = [];
         $typeList = MasterPropertyType::where("status",1)->orderBy("name","asc")->get();
         return $typeList;
    }

    # fetch ALL parent property type
    public static function onlyParents(){
         $data_map = [];
         $parentTypes = MasterPropertyType::where("is_parent",1)->orderBy("name","asc")->get();
         if(sizeof($parentTypes)>0){
            foreach($parentTypes as $each){
                $data_map[$each->id] = $each->name;
            }
         }
         return $data_map;
    }

    # fetch property type only non parent  with parent name
    public static function groupByType($fields = ["id","name"]){
        $data_map = [];

        $obj = new MasterPropertyType;

        //var_dump(expression)
        $data = \DB::table($obj->table." as a")
                            //->select("a.id","a.name as parent_name",\DB::raw("GROUP_CONCAT(b.name) as name") )
                            ->select("b.id","a.name as parent_name","b.name as name" )
                            ->where("a.status",1)
                            ->where("a.is_parent",1)
                            ->whereNotNull("b.name")
                            ->orderBy("a.name")
                             //->groupBy("a.name")
                            ->leftJoin($obj->table." as b",'a.id','=','b.parent')->get();
        //var_dump($data);
        return $data;
        
    }

   
}
