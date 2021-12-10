<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use \RouterOS\Client;
use \RouterOS\Query;
use Exception;

class Distrouter extends Model
{
	 use softDeletes;
    //
	public function customer()
	{
		return $this->hasmany('\App\Customer', 'id_distrouter');
	}

public static function mikrotik_connection ($host,$user,$pass,$port)
{
	 try {

        $client = new Client([
            //to login to api
            'host' => $host,
            'user' => $user,
            'pass' => $pass,
            'port' => $port,
            //data
            

        ]);
    }
    catch (Exception $e)
    {
    	 return false;
    }
    finally {
    	return true;
    }
}

   public static function mikrotik_addsecreate($host,$user,$pass,$port,$cid,$cidpass,$profile,$comment)
     
    {

       try {

        $client = new Client([
            //to login to api
            'host' => $host,
            'user' => $user,
            'pass' => $pass,
            'port' => $port,
            //data
            

        ]);
        




// check user exist 
        $query_check =

        (new Query('/ppp/secret/print'))

        ->where('name',$cid);

        $users = $client->query($query_check)->read();


//var_dump($users);
            // if user exist
        if (!empty($users[0]['.id'])) {
            // set the user enable
         foreach ($users as $user) {

    // enable
            $query_enable = (new Query('/ppp/secret/set'))
            ->equal('.id', $user['.id'])
            ->equal('disabled', 'false');
           


            $result = $client->query($query_enable)->read();

// echo $result;

        }
    }

    else
    {

        $query_add =

        (new Query('/ppp/secret/add '))
        ->equal('name', $cid)
        ->equal('password', $cidpass)
        ->equal('comment', $comment)
        ->equal('profile', $profile);


        $response = $client->query($query_add)->read();

    }

} catch (Exception $ex) {
    return('field connecting to router');
}
}


     public static function mikrotik_addprofile($host,$user,$pass,$port,$name,$limit,$comment)
    {

       try {

        $client = new Client([
            //to login to api
            'host' => $host,
            'user' => $user,
            'pass' => $pass,
            'port' => $port,
            //data
            

        ]);
        $name      = $name;
        $limit   = $limit;
        $comment   = $comment;
       




// check user exist 
        $query_check =

        (new Query('/ppp/profile/print'))

        ->where('name',$name);

        $profiles = $client->query($query_check)->read();




//var_dump($users);
            // if user exist
        if (!empty($profiles[0]['.id'])) {
            // set the user enable
         foreach ($profiles as $profile) {

    // enable
            $query_enable = (new Query('/ppp/profile/set'))
            ->equal('.id', $profile['.id'])
            ->equal('disabled', 'false');


            $result = $client->query($query_enable)->read();
           

// echo $result;

        }
    }

    else
    {

        $query_add =

        (new Query('/ppp/profile/add '))
        ->equal('name',$name)
        ->equal('rate-limit', $limit)
        ->equal('comment', $comment);


        $response = $client->query($query_add)->read();
        

    }


       

} catch (Exception $ex) {
    return "field connecting to router";
}


}








	public static function mikrotik_enable($ip,$user,$pass,$port,$cid)
	{

		try {

			$client = new Client([


				'host' => $ip,
				'user' => $user,
				'pass' => $pass,
				'port' => $port
			]);



			$query =

			(new Query('/ppp/secret/print'))

			->where('name', $cid);


			$secrets = $client->query($query)->read();


			echo "Before update" . PHP_EOL;


			foreach ($secrets as $secret) {

    // enable
				$query = (new Query('/ppp/secret/set'))
				->equal('.id', $secret['.id'])
				->equal('disabled', 'false');
				// ->equal('comment', 'enable by');

    // Update query ordinary have no return
				$client->query($query)->read();
				
    //print_r($secret['disabled']);



			}


		} catch (Exception $ex) {
			abort(404, 'Github Repository not found');
		}

	}



	public static function mikrotik_disable($ip,$user,$pass,$port,$cid)
	{

		try {

			$client = new Client([


				'host' => $ip,
				'user' => $user,
				'pass' => $pass,
				'port' => $port
			]);



			$query =

			(new Query('/ppp/secret/print'))

			->where('name', $cid);


			$secrets = $client->query($query)->read();


			echo "Before update" . PHP_EOL;


			foreach ($secrets as $secret) {

    // enable
				$query = (new Query('/ppp/secret/set'))
				->equal('.id', $secret['.id'])
				->equal('disabled', 'true');
				// ->equal('comment', 'enable by');

    // Update query ordinary have no return
				$client->query($query)->read();
				
    //print_r($secret['disabled']);




				$query_status =
			(new Query('/ppp/active/print'))
			->where('name', $cid);

			$response_status = $client->query($query_status)->read();
			if (!empty($response_status ))
			{


			foreach ($response_status as $response_status) {
				$query = (new Query('/ppp/active/remove'))
				->equal('.id', $response_status['.id']);
				$client->query($query)->read();
				
			}
		}
	}
		




			


		} catch (Exception $ex) {
			abort(404, 'Github Repository not found');
		}

	}


	public static function mikrotik_remove($ip,$user,$pass,$port,$cid)
	{

		try {

			$client = new Client([


				'host' => $ip,
				'user' => $user,
				'pass' => $pass,
				'port' => $port
			]);



			$query =

			(new Query('/ppp/secret/print'))

			->where('name', $cid);


			$secrets = $client->query($query)->read();


			echo "Before update" . PHP_EOL;


			foreach ($secrets as $secret) {

    // enable
				$query = (new Query('/ppp/secret/remove'))
				->equal('.id', $secret['.id']);
				
				
				// ->equal('comment', 'enable by');

    // Update query ordinary have no return
				$client->query($query)->read();
				
    //print_r($secret['disabled']);



			}


		} catch (Exception $ex) {
			abort(404, 'Github Repository not found');
		}

	}


	public function mikrotik_status($ip,$user,$pass,$port,$cid)
	{
		$result = 'unknow';

		$status['online']= 'Unknow';
				$status['ip'] = 'Unknow';
				$status['uptime']  = 'Unknow';
				$status['user']  = 'User not Found';

				
			

		try {

			$client = new Client([
				'host' => $ip,
				'user' => $user,
				'pass' => $pass,
				'port' => $port
			]);

			$query =
			(new Query('/ppp/secret/print'))
			->where('name', $cid);


			$response = $client->query($query)->read();
			if (!empty($response)){

			foreach ($response as $response) {
				$result = $response['disabled'];
			}


if ($result == 'true')
		{
			$status['user'] = 'Disable';
		}
		else if ($result =='false')
		{
			$status['user'] = 'Enable';
		}
		else
		{
			$status['user'] = 'Unknow';
		}

		


			$query_status =
			(new Query('/ppp/active/print'))
			->where('name', $cid);

			$response_status = $client->query($query_status)->read();
			if (!empty($response_status ))
			{
				$status['online']= 'Online';
				foreach ($response_status as $response_ip) {
				$status['ip'] = ($response_ip['address']);
				$status['uptime']  = ($response_ip['uptime']);
			}

			}
			else
			{
				$status['online']= 'Offline';
				$status['ip'] = 'Unknow';
				$status['uptime']  = 'Unknow';
			}



}


		} catch (Exception $ex) {
			$result = 'Unknow';
		}



return $status;
		

	}






}
