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

        die($cssHelper::compileCss(dirname(__DIR__) . '/vendor/twbs/bootstrap/scss/bootstrap.scss'));
    });
    
});