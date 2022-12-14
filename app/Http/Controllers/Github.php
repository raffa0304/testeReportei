<?php 

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class GithubInterface extends Controller
{
    public $authorizeURL = "https://github.com/login/oauth/authorize"; 
    public $tokenURL = "https://github.com/login/oauth/access_token"; 
    public $apiURLBase = "https://api.github.com"; 
    public $clientID; 
    public $clientSecret; 
    public $redirectUri; 

    public function __construct(array $config = []){ 
        $this->clientID = $config['client_id']; 
        $this->clientSecret = $config['client_secret']; 
        $this->redirectUri = $config['redirect_uri'];         
    } 
         
    public function getAuthorizeURL($state){ 
        return urldecode($this->authorizeURL . '?' . http_build_query([ 
            'client_id' => $this->clientID, 
            'redirect_uri' => $this->redirectUri, 
            'state' => $state, 
            'scope' => 'user:email' 
        ])); 
    } 
     
    public function getAccessToken($state, $oauth_code){ 
        $token = self::apiRequest($this->tokenURL . '?' . http_build_query([ 
            'client_id' => $this->clientID, 
            'client_secret' => $this->clientSecret, 
            'state' => $state, 
            'code' => $oauth_code 
        ])); 
        
        return $token->access_token; 
    }  
 
    public function curl($customrequest, $useragent, $url, $access_token){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/vnd.github+json', 'Authorization: token '. $access_token)); 
        curl_setopt($ch, CURLOPT_USERAGENT, 'php'); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
        
        $api_response = curl_exec($ch); 
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);          
       
        return json_decode($api_response);       
    }

    public function apiRequest($access_token_url){ 
        $apiURL = filter_var($access_token_url, FILTER_VALIDATE_URL)?$access_token_url:$this->apiURLBase.'user?access_token='.$access_token_url; 
        $context  = stream_context_create([ 
          'http' => [ 
            'user_agent' => 'php', 
            'header' => 'Accept: application/json' 
          ] 
        ]); 
        $response = file_get_contents($apiURL, false, $context); 
         
        return $response ? json_decode($response) : $response; 
    }
}