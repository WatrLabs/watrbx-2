<?php

use watrlabs\routing;
use watrlabs\authentication;
use watrlabs\users\getuserinfo;
use watrlabs\sitefunctions;
use watrlabs\errors;

require_once '../init.php';

$errors = new \watrlabs\errors;

try {

    try {

        global $db;
        global $router;

        if(isset($_ENV["APP_DEBUG"])){
            if($_ENV["APP_DEBUG"] !== "true"){
                error_reporting(0);
            }
        }

        ob_start();

        $auth = new authentication();
        $router = new routing();

        $routers = [
            "web",
            "css"
        ];

        foreach ($routers as $r) {
            $router->addrouter($r);
        }

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = strtolower($uri);
        $method = $_SERVER['REQUEST_METHOD'];
        $response = $router->dispatch($uri, $method);

        ob_end_flush();

    } catch(PDOException $e){
        if($_ENV["APP_DEBUG"] == "true"){
            $errors::handleDebugError($e);
        } else {
            $errors::showFriendlyError($e);
        }
    }

    
} catch(ErrorException $e){
    if($_ENV["APP_DEBUG"] == "true"){
        $errors::handleDebugError($e);
    } else {
        $errors::showFriendlyError($e);
    }
}



// aaaaaaaaaaaaaaaa my brain hurts 