<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Github;
use App\Models\Repos;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

require_once 'Config.php';
require_once 'Github.php';

Class GitController{

    public function authURL(){
        $gitClient = new GithubInterface(array( 
            'client_id' => CLIENT_ID, 
            'client_secret' => CLIENT_SECRET, 
            'redirect_uri' => REDIRECT_URL 
        )); 
    
        if(!is_null(session()->get('access_token'))){ 
            $accessToken = session()->get('access_token'); 
        }
    
        $state = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']); 
        
        $authUrl = $gitClient->getAuthorizeURL($state); 
        
        $output = $authUrl; 

        return view('welcome', ['output' => $output]);
    }

    public function getRepos(Request $request){
        $gitClient = new GithubInterface(array( 
            'client_id' => CLIENT_ID, 
            'client_secret' => CLIENT_SECRET, 
            'redirect_uri' => REDIRECT_URL 
        )); 
        
        $accessToken = $gitClient->getAccessToken($_GET['state'], $_GET['code']); 

        $gitUser = $gitClient->curl('GET', 'php', 'https://api.github.com/user/repos', $accessToken); 
     
        foreach($gitUser as $value){
            $nomes = $value->name;
            $login = $value->owner->login;
            $commit = 5;

            self::store($nomes, $login, $commit);
        }

        $dados = Repos::all();
     
        return view('gitGraphicsPage', ['dados' => $dados], ['nomeLogin' => $login]);
    }

    public function store($name, $nameLogin, $commit) {
        $repos = new Repos;
        
        $repos->name = $name;
        $repos->commit = $commit;
        $repos->nameLogin = $nameLogin;
        $repos->save();

        return redirect('gitGraphicsPage');
    }
            
}

?>