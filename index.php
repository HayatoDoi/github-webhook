<?php
require_once "config.php";
$repo_name = ltrim($_SERVER["REQUEST_URI"],"/");
$postdata = file_get_contents("php://input");
try{
    if(!array_key_exists($repo_name, $REPO)){
        throw new Exception("Can not found repo name.");
    }
    $header = getallheaders();
    $hmac = hash_hmac("sha1", $postdata, $REPO[$repo_name]["secret_key"]);
    $keycheck = isset($header["X-Hub-Signature"]) && $header["X-Hub-Signature"] === "sha1=".$hmac;
    if(!$keycheck){
        throw new Exception("Secret key is incorrect.");
    }
    if($header["Content-Type"] == "application/json"){
        $request = json_decode($postdata, true);
    } else if($header["Content-Type"] == "application/x-www-form-urlencoded"){
        $request = json_decode($_POST["payload"], true);
    } else{
        throw new Exception("Content-Type is incorrect.");
    }

    if($request["ref"] == "refs/heads/".$REPO[$repo_name]["branch"]){
        if(!chdir($REPO[$repo_name]["path"])){
            throw new Exception("Con not change dir.");
        }
        if(!exec($REPO[$repo_name]["exec"])){
            throw new Exception("command error.");
        }
        echo "Successful.\n";
    }
} catch(Exception $e){
    http_response_code(401);
    echo "401 Unauthorized.\n";
    echo $e->getMessage();
}
