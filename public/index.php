<?php

use watrlabs\routing;
use watrlabs\authentication;
use watrlabs\users\getuserinfo;
use watrlabs\sitefunctions;

require_once '../init.php';

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
            "web"
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
        handle_error($e);
    }

    
} catch(ErrorException $e){
    handle_error($e);
}

function handle_error($e){
    try {
        ob_clean();

        file_put_contents("../storage/errorlog.log", $e . "\n\n", FILE_APPEND);
        http_response_code(500);

        global $twig;
        echo $twig->render('statusCodes/500.twig');

    } catch(ErrorException $e){
        ob_clean();

        http_response_code(500);
        echo $e;

        file_put_contents("../storage/errorlog.log", $e . "\n\n", FILE_APPEND);
        die("watrbx couldn't proccess your request. please try again later.");
    }
}

// aaaaaaaaaaaaaaaa my brain hurts 