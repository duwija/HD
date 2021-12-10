<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accounting extends Model
{
	use SoftDeletes;
    //
    protected $fillable =['date','id_category','income','expense','account_payable','account_recievable','amount','note','created_by','updated_at'];
     public function category()
    {
        return $this->belongsTo('\App\Accountingcategorie', 'id_category')->withTrashed();
    }
}
