<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\vehicle;

use \Illuminate\Support\Carbon;

class vehicle_category extends Model
{
    use HasFactory;

    protected $fillable=['id', 'make', 'range', 'model', 'vehicle_type','derivative', 'created_at', 'updated_at'];

    // One vehicle category has many vehicles
    public function vehicle(){
        return $this->hasMany(vehicle::class,'id','cat_id');
    }

    public function getId(){
        return $this->id;
    }

    public function getById($id){
        return static::all();
    }

    public function checkCategoryExistance($make,$range,$model){
      
        $row = static::where('make',$make)
                    ->where('range',$range)
                    ->where('model',$model)
                    ->get();
        
       return count($row) >0 ?$row :null ;
    }

    // Part of TASK 01
    public function addNewCategory($record){

        $exist = false;
        $row = $this->checkCategoryExistance($record["MAKE"],$record["RANGE"],$record["MODEL"]);
        $id='';

        if(!empty($row)){
            $exist=true;
            return $id=$row[0]->id;

        }else{
            $row = static::create([
                "make"=>$record["MAKE"],
                "range"=>$record["RANGE"],
                "model"=>$record["MODEL"],
                "vehicle_type"=>$record["VEHICLE_TYPE"],
                'derivative'=>$record["DERIVATIVE"],
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
            ]);

            return $id=$row->id;
        }

        
    }
}
