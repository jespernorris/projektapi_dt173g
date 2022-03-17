<?php
    // felrapportering
    error_reporting(-1);
    ini_set("display_errors", 1);

    session_start();
    
    // gör att webbtjänsten går att komma åt från alla domäner
    header('Access-Control-Allow-Origin: *');

    // talar om att webbtjänsten skickar data i JSON-format
    header('Content-Type: application/json; charset=UTF-8');

    // vilka metoder som webbtjänsten accepterar
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

    // vilka headers som är tillåtna vid anrop från klient-sidan
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // autoload för klasser
    spl_autoload_register(function ($class_name) {
        include "classes/". $class_name . ".class.php";
    });
