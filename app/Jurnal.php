<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurnal extends Model
{
    //
       protected $fillable =['date','id_akun', 'kredit', 'debet','reff','type','description',"created_by"];
        public function akun_name()
    {
        return $this->belongsTo('\App\akun', 'id_akun');
    }
}
