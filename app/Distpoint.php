<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;


class Distpoint extends Model
{
 
 use softDeletes;
    protected $fillable =['name','id_site', 'ip', 'security','parrent','coordinate','created_at','monitoring','status','description','deleted_at'];
    public function distpoint_name()
    {
        return $this->belongsTo('\App\Distpoint', 'parrent');
    }

    public function site_name()
    {
        return $this->belongsTo('\App\Site', 'id_site');
    }
public function customer()
    {
        return $this->hasmany('\App\Customer', 'id_distpoint') ;
    }
    public function distpoint($id)
    {
    	   $distpoint = $this->where('id', $id)
           ->first();
           return $distpoint;
         
    }
}
