<?php

use App\Models\AdminLog;
use App\Models\Room;
use App\Models\SocialMedia;
use App\Models\StorePurchaseHistory;
use App\Models\UserConversationNotification;
use App\Models\UserLog;
use App\Models\UserLoginHistory;
use App\Models\WalletHistory;
use App\User;
use Carbon\Carbon;
use League\ISO3166\ISO3166;
//use Vinkla\Hashids\Facades\Hashids;
use Hashids\Hashids;
use GuzzleHttp\Client as HttpClient;
use kornrunner\Blurhash\Blurhash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Http;

function sendToToken($token , $data) {
	
    $url = "https://fcm.googleapis.com/fcm/send";
        $fields = array (
            'to'            => $token,
            'notification'  => array (
              'title'       => $data['title'],
              'body'        => $data['body'],
              'icon'        => "new",
              'sound'       => "default"
            ),
            'data' => $data['data'],
            'apns' => 
            array (
              'payload' => 
              array (
                'aps' => 
                array (
                  'contentAvailable' => true,
                ),
              ),
              'headers' => 
              array (
                'apns-push-type' => 'background',
                'apns-priority' => '5',
                'apns-topic' => 'io.flutter.plugins.firebase.messaging',
              ),
            ),
        );

        $header = array(
            "Authorization:key=AAAApmfO__Y:APA91bECdaGX-K8bkktZR8hPZ7qscOZHQnWz5nZE0v67iP80e9A3exywAASJW9Ep_qCAsBa1vQ8iDsFVwcQBmp1PFO58vGiep_xTX3eTeWB8B2H5ZZBNID6FZj2AbrL5jVH9VxQSaAT-",
            'Content-Type:application/json'
        );


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        $result = curl_exec($ch);

		if ($result === false)
        {
            return 0;
        }

        curl_close($ch);

        return 1;
	}
function sendToTokenArray($tokens , $data) {
    foreach($tokens as $token ){
            $url = "https://fcm.googleapis.com/fcm/send";
            $fields = array (
                'to'            => $token,
                'notification'  => array (
                'title'       => $data['title'],
                'body'        => $data['body'],
                'icon'        => "new",
                'sound'       => "default"
                ),
                'data' => $data['data'],
                'apns' => 
                array (
                'payload' => 
                array (
                    'aps' => 
                    array (
                    'contentAvailable' => true,
                    ),
                ),
                'headers' => 
                array (
                    'apns-push-type' => 'background',
                    'apns-priority' => '5',
                    'apns-topic' => 'io.flutter.plugins.firebase.messaging',
                ),
                ),
            );

            $header = array(
                "Authorization:key=AAAApmfO__Y:APA91bECdaGX-K8bkktZR8hPZ7qscOZHQnWz5nZE0v67iP80e9A3exywAASJW9Ep_qCAsBa1vQ8iDsFVwcQBmp1PFO58vGiep_xTX3eTeWB8B2H5ZZBNID6FZj2AbrL5jVH9VxQSaAT-",
                'Content-Type:application/json'
            );


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            
            $result = curl_exec($ch);

            if ($result === false)
            {
                
            }

            curl_close($ch);

        }
        
      
}
