<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factories\FacebookFactory;

class PostsController extends Controller
{
	public $url_padrao = 'https://graph.facebook.com/v3.2/';
	public $page_id = '1820791091575061';
	public $access_token = '';
    public function postagem(){

      try {
        $client = new \GuzzleHttp\Client();
        $fc = new FacebookFactory();



        $access_token = 'EAAFEEqGg74cBAGlKiHCRWLYgZB4L20rqlXJF95L6MunB0mtc3ZBCAHnQU2nRW8zsKpDfcd9BhMxUpivnbqGdEPJZA5Re9LKA2tzYS7sdYcwToCpO74ZBsDrE6lO2zMI9ZBXuUuVce0SvQdPx0XSZBSxFA9nZCcnm8AZD';
        $request = $client->request('GET', 'https://graph.facebook.com/v3.2/1820791091575061/feed?access_token='.$access_token);

        $json = json_decode($request->getBody(),true);

        

        
        
        
        //$id = $dados['id'];
        //var_dump($array_ids);
        
        return $json;
      } catch (Exception $e) {
        
      }
    }
}