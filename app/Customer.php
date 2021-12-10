<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
	use SoftDeletes;


    protected $fillable =['customer_id','password','name', 'contact_name', 'phone','id_plan','id_distpoint','id_status','id_distrouter','email','address','npwp','tax','coordinate','note' ,'created_by','updated_by','created_at','update_at','deleted_at'];

    public function plan_name()
    {
        return $this->belongsTo('\App\Plan', 'id_plan')->withTrashed();
    }

    public function distpoint_name()
    {
        return $this->belongsTo('\App\Distpoint', 'id_distpoint')->withTrashed();
    }
    public function status_name()
    {
        return $this->belongsTo('\App\Statuscustomer', 'id_status')->withTrashed();
    }
    public function invoice()
    {

        return $this->hasMany('\App\invoice', 'id_customer');
    }
    public function device()
    {

        return $this->hasMany('\App\device', 'id_customer');
    }
     public function file()
    {

        return $this->hasMany('\App\file', 'id_customer');
    }
    public function distrouter()
    {
        return $this->belongsTo('\App\Distrouter', 'id_distrouter');
    }
  
}
