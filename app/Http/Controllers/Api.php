<?php
namespace App\Http\Controllers;
use GuzzleHttp\Client;

class Api extends Controller{

    public static function Get($uri, $token='', $id=null, $body = null){

        $uri = $id == '' || $id == null?$uri:$uri."/".$id;
        $url = env('API_URL').$uri;
        $headers = [
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'Authorization'  => 'Bearer '.$token
        ];
        $client = new Client();
        $res = null;
        if($body == null)
            $res = $client->get($url, ['headers' => $headers]);
        else
            $res = $client->get($url, ['headers' => $headers, 'json' => $body]);
        $response =json_decode($res->getBody(), true);
        return $response;
    }

    public static function Post($uri, $token='', $body){

        $url = env('API_URL').$uri;

        $headers = [
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'Authorization'  => 'Bearer '.$token
        ];

        $client = new Client();

        $res = $client->post($url, [
            'headers' => $headers,
            'json' => $body
        ]);

        $response =json_decode($res->getBody(), true);
        return $response;
    }

    public static function Put($uri,$token='', $body){

        $url = env('API_URL').$uri."/".$body['id'];

        $headers = [
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'Authorization'  => 'Bearer '.$token
        ];
        $client = new Client();
        $res = $client->put($url, [
            'headers' => $headers,
            'json' => $body
        ]);

        $response =json_decode($res->getBody(), true);

        return $response;
    }

    public static function Delete($uri, $id, $token=''){

        $url = env('API_URL')."/".$uri."/".$id;

        $headers = [
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'Authorization'  => 'Bearer '.$token
        ];

        $client = new Client();
        $res = $client->delete($url, [
            'headers' => $headers
        ]);

        $response =json_decode($res->getBody(), true);

        return $response;

    }

}
?>
