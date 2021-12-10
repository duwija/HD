<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class Statuscustomer extends Model
{
    //
    use softDeletes;
    protected $fillable =['id','name','color','deleted_at'];

public function site_name()
    {
        return $this->belongsTo('\App\Site', 'id_site');
    }



    public function status($id)
    {
    	   $status = $this->where('id', $id)
           ->first();
           return $status;
         
    }
    
    

 }