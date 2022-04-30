<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\vehicle_category;
use App\Models\images;

use \Illuminate\Support\Carbon;

class vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['cat_id', 'reg', 'colour', 'milage', 'price', 'vat',  'date_at_forecourt', 'available', 'created_at', 'updated_at'];

    protected $cat_id;
    protected $reg;
    protected $colour;
    protected $milage;
    protected $price;
    protected $vat;
    protected $derivative;
    protected $date_at_forecourt;
    protected $available;
    protected $created_at;
    protected $updated_at;

    // Each vehicle belongs to One vehicle category
    public function vehicle_category(){

        return $this->belongsTo(vehicle_category::class,'cat_id','id');
    }


    public function images(){
        return $this->hasMany(images::class,'reg_number','reg');
    }

    public static function getById(){
        return static::all();
    }

    // Part of TASK 01
    public function addNewVehicle($cat_id, $record){

        $vehicle_already_exist = static::where('reg',$record["REG"])->first();

        if(!$vehicle_already_exist){

            $available=1;
            $date=$record["DATE_ON_FORECOURT"];
            // $price = calculate price
            $price = floatval(str_replace(",","",$record["PRICE_INC_VAT"]))/100*80;    
            // $vat = calculate vat
            $vat = floatval(str_replace(",","",$record["PRICE_INC_VAT"]))/100*20;
            // currently I did not do the calculations.
            if($record["DATE_ON_FORECOURT"] > Carbon::now() || $record["DATE_ON_FORECOURT"] == '0000-00-00'){
                $available = 0; 
                $date=NULL;

            }

            $row = static::create([
                'cat_id'=>$cat_id, 
                'reg'=>$record["REG"], 
                'colour'=>$record["COLOUR"],
                'milage'=>$record["MILEAGE"],
                'price'=>str_replace(",","",$price),
                'vat'=>str_replace(",","",$vat),
                'date_at_forecourt'=>$date==NULL?NULL :$record["DATE_ON_FORECOURT"], 
                'available'=>$available, 
                'created_at'=>Carbon::now(), 
                'updated_at'=>Carbon::now()
            ])->toSql();
            
            return $row;
        }else{
            return $vehicle_already_exist;
        }
    }

    public function getcat_id(){
        return $this->cat_id;
    }
}
