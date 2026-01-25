<?php
use watrlabs\router\Routing;
use watrlabs\watrkit\sanitize;
use watrlabs\encryption;

global $router; // IMPORTANT: KEEP THIS HERE!
global $pagebuilder;

$router->get("/randTest", function(){
    header("Content-type: text/plain");
    $encryption = new encryption();
    echo $encryption->genRandString(10000000, true);

});

$router->get("/", function() {
    global $twig;
    global $currentuser;

    if($currentuser){
        header("Location: /home");
        die();
    }

    echo $twig->render('default.twig');
});

$router->set404(function(){
    global $twig;
    echo $twig->render('statusCodes/404.twig');
});

/*
$router->group('/group', function($router) {
    
    $router->get("/hi", function () {
        echo "test<br>";
    });
    
});
*/
