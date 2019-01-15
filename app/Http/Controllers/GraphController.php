<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Auth;

class GraphController extends Controller
{
    private $api;
    #public function __construct(Facebook $fb)
    #{
     #   $fb = new Facebook([
      #      'app_id' => '356321788489607',
       #     'app_secret' => '70d8add9f5005fd814ece322955dd159',
        #    'default_graph_version' => 'v3.2'
         #   ]);
       # $this->middleware(function ($request, $next) use ($fb) {
        #    $fb->setDefaultAccessToken(Auth::user()->token);
        #   $this->api = $fb;
        #    return $next($request);
        #});
    #}

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

	public function getPagePosts(){

        $result = "";
        try {

            $fb = new Facebook([
            'app_id' => '356321788489607',
            'app_secret' => '70d8add9f5005fd814ece322955dd159',
            'default_graph_version' => 'v3.2'
            ]);

            $access_token = 'EAAFEEqGg74cBAG4ilZCbNfsOwBU5gKrPU3naCigjhsmcb9DVnoMAHEbk1CZAy4PC2pseGPb18ZCZBKACHnptpivZBk9oo2whDD3ZAHizB2Wh1ovG1ez2HJZAumTHrJ7hGPNaeJjq6HCebAttfJEj08x0do8ludRJHwFeZB4jZBhQsOEZBaVOKPiTPRUw1svjhDNMt0Rzft3cFJygZDZD';
                // Returns a `FacebookFacebookResponse` object
            $response = $fb->get(
                '/1820791091575061/feed',
                'EAAFEEqGg74cBAG4ilZCbNfsOwBU5gKrPU3naCigjhsmcb9DVnoMAHEbk1CZAy4PC2pseGPb18ZCZBKACHnptpivZBk9oo2whDD3ZAHizB2Wh1ovG1ez2HJZAumTHrJ7hGPNaeJjq6HCebAttfJEj08x0do8ludRJHwFeZB4jZBhQsOEZBaVOKPiTPRUw1svjhDNMt0Rzft3cFJygZDZD'
                );

            $json = json_decode($request->getBody(),true);

            $result = $json;

        } catch(FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        //$graphNode = $response->getGraphNode();
        return $result;
    }
}
