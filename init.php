<?php
use Pixie\Connection;
use Pixie\QueryBuilder\QueryBuilderHandler;
use watrlabs\authentication;

global $db;
global $twig;
global $currentuser;

function handleFatalError($message){
    header("content-type: text/plain; charset=utf-8");
    http_response_code(500);
    die($message);
}

spl_autoload_register(function ($class_name) {
    $directory = '../classes/';
    $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
    $file = $directory . $class_name . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
    else {
        throw new ErrorException("Failed to include class $class_name");
    }
});

// I wonder if i should put all of this in a class 

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

register_shutdown_function(function () {
    $error = error_get_last();

    if ($error !== null) {
        header("content-type: text/plain; charset=utf-8");
        if(isset($_ENV)){
            if($_ENV["APP_ENV"] == "production"){
                handleFatalError("Something went wrong and your request was not processed. Please try again later.");
            } else {
                echo "Error: " . $error['message'] . " in " . $error['file'] . " on line " . $error['line'];
                die();
            }
        } else {
            handleFatalError("Something went wrong and your request was not processed. Please try again later.");
        }
    }
});


require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {

    $config = [
        'driver'    => 'mysql',
        'host'      => $_ENV["DB_HOST"],
        'database'  => $_ENV["DB_NAME"],
        'username'  => $_ENV["DB_USER"],
        'password'  => $_ENV["DB_PASS"],
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '', // if you have a prefix for all your tables.
    ];

    $connection = new Connection('mysql', $config);
    $db = $connection->getQueryBuilder(); 
    
} catch (PDOException $e){
    handleFatalError("Something went wrong and your request was not processed. Please try again later.");
}

$auth = new authentication();

if($auth->hasaccount()){
    $currentuser = $auth->getuserinfo($_COOKIE["_ROBLOSECURITY"]);
} else {
    $currentuser = null;
}

$loader = new \Twig\Loader\FilesystemLoader('../views');

$twig = new \Twig\Environment($loader, [
    'cache' => '../storage/cache',
    'auto_reload' => true // should disable this in production 
]);

// makes it so you can do {{ env('KEY') }} in twig to get env variables
$twig->addFunction(new \Twig\TwigFunction('env', function ($key) {
    return $_ENV[$key];
}));


// adds localization & eotd stuff
$twig->addExtension(new app\twig\twigLocalization());
$twig->addExtension(new app\twig\eotdHelper());

// this defines all the current info for the user
$twig->addGlobal('currentuser', $currentuser);
