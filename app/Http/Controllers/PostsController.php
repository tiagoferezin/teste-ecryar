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



        $access_token = $fc->getPageAccessToken('page_id');
        $request = $client->request('GET', $url_padrao.''.$page_id.'/feed?access_token='.$access_token);

        $json = json_decode($request->getBody(),true);

        

        $dados = $json["data"];
        $ids = "";

        for ($i=0; $i < count($dados); $i++) { 
          if($i=0){
            $ids = $dados[$i]["id"];
          }else {
            $ids = $ids. ", " .$dados[$i]["id"];
          }
        }
        
        
        //$id = $dados['id'];
        //var_dump($array_ids);
        
        return $ids;
      } catch (Exception $e) {
        
      }
    }
}