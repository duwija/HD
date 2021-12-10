<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Plan extends Model
{
    //
    use softDeletes;
    protected $fillable =['name','speed','price','description','deleted_at'];

    public function plan($id)
    {
    	   $plan = $this->where('id', $id)
           ->first();
           return $plan;
         
    }
}
