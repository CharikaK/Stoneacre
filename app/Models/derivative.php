<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\vehicle;

class derivative extends Model
{
    use HasFactory;
    protected $fillable = ['reg_number','description','date_at_forecourt'];
    
    /** Relationship */
    public function vehicle(){
        return $this->belongsTo(vehicle::class,'reg','reg_number');
    }


    public function getId(){
        return $this->id;
    }

    /**
     * Get the value of date_at_forecourt
     */ 
    public function getDate_at_forecourt()
    {
        return $this->date_at_forecourt;
    }

    /**
     * Set the value of date_at_forecourt
     *
     * @return  self
     */ 
    public function setDate_at_forecourt($date_at_forecourt)
    {
        $this->date_at_forecourt = $date_at_forecourt;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of reg_number
     */ 
    public function getReg_number()
    {
        return $this->reg_number;
    }

    /**
     * Set the value of reg_number
     *
     * @return  self
     */ 
    public function setReg_number($reg_number)
    {
        $this->reg_number = $reg_number;

        return $this;
    }
}