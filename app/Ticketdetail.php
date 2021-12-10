<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticketdetail extends Model
{


	 protected $fillable = ['id', 'id_ticket','description', 'updated_by','created_at','updated_at'];
    //
	 public function ticket()
    {
        return $this->belongsTo('\App\ticket', 'id_ticket');
    }
}
