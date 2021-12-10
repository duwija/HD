<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $fillable =['id_customer','name','path','created_at','deleted_at'];

	 public function customer()
    {
        return $this->belongsTo('\App\customer', 'id_customer');
    }
    //
}
