<?php

namespace App\Factories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
* 
*/
class FacebookFactory 
{
	private $app_id;
	private $app_secret;
	private $url_padrao = "https://graph.facebook.com/v3.2/";

	function __construct(){

	}
	

	public function getPageAccessToken($page_id){

		$client = new \GuzzleHttp\Client();
		$request = $client->request('GET', 'https://graph.facebook.com/v3.2/'.$page_id.'?fields=access_token&access_token='.Auth::user()->token);
		$json = json_decode($request->getBody(), true);

		$accessToken = $json['access_token'];
		return $accessToken;
	}

}