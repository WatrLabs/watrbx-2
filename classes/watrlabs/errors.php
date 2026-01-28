<?php

namespace watrlabs;

class errors {

    // this is for working on the site. i wanna do something fancy like laravel but I have no idea how they do it
    // just stops execution and shows the raw error
    static function handleDebugError($e){
        // I'll probably do something better than this
        header("Content-type: text/plain");
        die($e);
    }


    // shows 500 page and if it can't just breaks it to the user we're prob down
    static function showFriendlyError($e){
        try {
            ob_clean();

            file_put_contents("../storage/errorlog.log", $e . "\n\n", FILE_APPEND);
            http_response_code(500);

            global $twig;
            header("Content-type: text/html");
            echo $twig->render('statusCodes/500.twig');

        } catch(ErrorException $e){
            ob_clean();

            http_response_code(500);
            echo $e;

            file_put_contents("../storage/errorlog.log", $e . "\n\n", FILE_APPEND);

            header("Content-type: text/plain");
            die("watrbx couldn't proccess your request. please try again later.");
        }
    }
}