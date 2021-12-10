<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accountingcategorie extends Model
{
	use SoftDeletes;
    //
    protected $fillable =['name','created_at','updated_at','deleted_at'];
    public function accounting()
    {
        return $this->hasmany('\App\accounting', 'id_category') ;
    }
}
