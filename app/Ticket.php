<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Auth;

class Ticket extends Model
{
    //
    protected $fillable = ['id_customer', 'called_by','phone', 'status','id_categori','tittle','description','assign_to','member','date','time','create_by','created_at','deleted_at'];




    public function user()
    {
        return $this->belongsTo('\App\user', 'assign_to');
    }
public function customer()
    {
        return $this->belongsTo('\App\customer', 'id_customer')->withTrashed();
    }
    public function ticketdetail()
    {

        return $this->hasMany('\App\Ticketdetail', 'id_ticket');
    }

    
public function status()
    {

        return $this->hasMany('\App\Ticketdetail', 'id_ticket');
    }
public function my_ticket()
    {
        $id = Auth::user()->id;

        $my_ticket = $this->where('assign_to' , '=', $id)
        ->where('status','!=','Close')
           ->count();
           return $my_ticket;
    }



}
