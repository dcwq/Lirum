<?php

if (!defined('ROOT_PATH'))
{
    define('ROOT_PATH', dirname(dirname(__FILE__)));
}

return new \Phalcon\Config(array(

    /* DATABASE */

    'database' => array(
        'adapter'           => 'Mysql',
        'host'              => 'localhost',
        'username'          => 'root',
        'password'          => '',
        'dbname'            => 'test',
    ),

    /* APPLICATION */

    'application' => array(

        'defaultModule'     => 'core',
        'baseUri'           => '/',

        'logger'            => array(
            'enabled' => true,
            'path' => ROOT_PATH . '/app/var/logs/',
            'format' => '[%date%][%type%] %message%',
        ),

        'annotations' =>
            array (
                'adapter' => 'Files',
                'annotationsDir' => ROOT_PATH . '/app/var/cache/annotations/',
            )
    ),

    /* VOLT TEMPLATES */

    'volt'=> array(
        'path'              =>  ROOT_PATH . '/app/var/cache/views/',
        'extension'         => '.compiled',
        'separator'         => '_',
        'stat'              => 1
    ),



));
