<?php
use watrlabs\router\Routing;
use watrlabs\watrkit\sanitize;
use watrlabs\encryption;
use app\cssHelper;


global $router; // IMPORTANT: KEEP THIS HERE!
global $pagebuilder;

$router->group('/api/v1/css', function($router) {
    
    $router->get("/fetchCSS", function () {

        $cssHelper = new cssHelper;

        header("Content-type: text/css");
        $expires = 3600000; 
        header("Pragma: public", true); // For backward compatibility
        header("Cache-Control: public, max-age=$expires, no-transform", true);
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT', true);

        if(isset($_GET["Name"])){
            $name = $_GET["Name"];

            $cssFiles = [
                "bootstrap"=>dirname(__DIR__) . "/vendor/twbs/bootstrap/scss/bootstrap.scss",
                "custom"=>dirname(__DIR__) . '/storage/public/css/watrbx/custom.scss',
                "index"=>dirname(__DIR__) . '/storage/public/css/watrbx/index.scss'
            ];

            if(isset($cssFiles[$name])){
                return $cssHelper::serveCSS($cssFiles[$name]);
            } else {
                http_response_code(404);
            }

        }
    });
    
});