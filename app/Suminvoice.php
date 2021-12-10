<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Exception\GuzzleException;
Use GuzzleHttp\Clients;

use Xendit\Xendit;

class Suminvoice extends Model
{
    //
    //use softDeletes;
    protected $fillable =['id','id_customer','number','date','tax','verify','tempcode','payment_status','updated_by','created_at','deleted_at','file','total_amount','recieve_payment','payment_point','payment_id','note','payment_date'];
    public function countinv($id)
    {
    	//$mount = now()->format('mY');
        $count = $this->where('id_customer', $id)
    	   // ->where('periode', '=', $mount)
        ->where('payment_status', '=', 0)
        ->count();
        return $count;

    }
    public function customer()
    {
        return $this->belongsTo('\App\customer', 'id_customer')->withTrashed();
    }
    public function bank()
    {
        return $this->belongsTo('\App\Bank', 'id_customer')->withTrashed();
    }
 public function user()
    {
        return $this->belongsTo('\App\User', 'updated_by')->withTrashed();
    }


    public static function wa_payment($phone, $message)
    {

        $client = new Clients(); 
        $result = $client->post('https://wapisender.com/api/v1/send-message', [
            'form_params' => [
                'key' => env('WAPISENDER_KEY'),
                'device' => env('WAPISENDER_PAYMENT'),
        // 'group_id' => '3013',
                'destination' => $phone,
                'message' => $message,
            ]
        ]);

        echo $result->getStatusCode();
        // 200
       $result= $result->getBody();
         $array = json_decode($result, true);
        return ( $array['status'].' - '.$array['message']);
    }


    public static function xendit_create_invoice($id_customer, $cid, $email, $description, $amount)
    {


        Xendit::setApiKey(env('XENDIT_KEY'));

        $params = [
        'external_id' => $cid,
        'payer_email' => 'test@gmail.com',
        'description' => $description,
        'amount' => $amount
    ];
//dd ($params);
    $createInvoice = \Xendit\Invoice::create($params);
    $array = json_decode(json_encode($createInvoice, true));
    dd ($id_customer);
   \App\Suminvoice::where('id', $id_customer)
            ->update([
                
                'payment_id' => $array->id,
                
                   
            ]);


}
}

