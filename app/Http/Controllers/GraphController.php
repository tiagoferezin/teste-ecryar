<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Auth;

class GraphController extends Controller
{
    private $api;
    public function __construct(Facebook $fb)
    {
        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()->token);
            $this->api = $fb;
            return $next($request);
        });
    }

    public function retornaUserProfile(){
    	try {
 
            $params = "first_name,last_name,age_range,gender";
 
            $user = $this->api->get('/me?fields='.$params)->getGraphUser();
 
            dd($user);
 
        } catch (FacebookSDKException $e) {
        	echo "Graph SDK error return: " . $e->getMessage();
 
        }
    }

    public function getPageAccessToken($page_id){
    try {
         // Get the \Facebook\GraphNodes\GraphUser object for the current user.
         // If you provided a 'default_access_token', the '{access-token}' is optional.
         $response = $this->api->get('/me/accounts', Auth::user()->token);
    } catch(FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    try {
        $pages = $response->getGraphEdge()->asArray();
        foreach ($pages as $key) {
            if ($key['id'] == $page_id) {
                return $key['access_token'];
            }
        }
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
	}

	//public function retornaPostFB($post_id){
	//	try{
			//$response = $this->api->get('')
	//	}
	//}

	//public function listaPostsFB(){
		
	//}
}
