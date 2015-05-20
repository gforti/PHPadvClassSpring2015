<?php
/*
 * This file allows you auto load classes
 * without having to include them on the page. 
 */
function load_lib($class) {
    include 'lib/'.$class . '.php';
};
spl_autoload_register('load_lib');

session_start();
session_regenerate_id(TRUE);

$dbConfig = array(
        "DB_DNS"=>'mysql:host=localhost;port=3306;dbname=PHPadvClassSpring2015',
        "DB_USER"=>'root',
        "DB_PASSWORD"=>''
    );
            
   
if ( null !== filter_input(INPUT_GET, 'logout') ) {
    session_destroy();
    header("Location: login.php");
    die();
}