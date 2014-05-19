<?php

//APP STAGE
DEFINE('APPLICATION_STAGE_DEVELOPMENT', 'development');
DEFINE('APPLICATION_STAGE_PRODUCTION', 'production');

DEFINE('APPLICATION_STAGE', APPLICATION_STAGE_DEVELOPMENT);
//DEFINE('APPLICATION_STAGE', APPLICATION_STAGE_PRODUCTION);

//STAGE ERRORS
if (APPLICATION_STAGE == APPLICATION_STAGE_DEVELOPMENT)
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
else
{
    ini_set('display_errors', 0);
    error_reporting(0);
}

//ROOT_PATH
if (!defined('ROOT_PATH'))
{
    define('ROOT_PATH', dirname(dirname(__FILE__)));
}

require ROOT_PATH . "/app/engine/Exception.php";
require ROOT_PATH . "/app/engine/Application.php";

$application = new \Engine\Application();
$application->run();

echo $application->getOutput();
