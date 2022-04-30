<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\vehicle;

use \Illuminate\Support\Carbon;

class images extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'reg_number', 'img_1', 'img_2', 'img_3', 'img_4', 'img_5', 'created_at', 'updated_at'];

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class,'reg','reg_number');
    }

    public function addImages($reg,$images){
        $vehicle_already_exist = static::where('reg_number',$reg)->first();

        // Assumption is each record has only 3 images
        // But if there are more than 3 images, 
        //first create a row with the reg id and then update the existing record with images while looping through the images
        if(!$vehicle_already_exist){
            $row = static::create([
                'reg_number'=>$reg, 
                'img_1'=>$images[0], 
                'img_2'=>$images[1], 
                'img_3'=>$images[2],
                'created_at'=>Carbon::now(), 
                'updated_at'=>Carbon::now()
            ]);
        }
        
    }

}

