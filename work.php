<?php
    include_once("config/config.php");
    include_once ("config/Database.php");

    $database = new Database();
    $db = $database->connect();

    $work = new Work($db);

    // lagrar metod som skickats i variabel
    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents('php://input'), true);

    // om ID skickas lagras den i variabel
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    // stoppar in värden i variabler
    if(isset($data)) {
        $workplace = $data["workplace"];
        $title = $data["title"];
        $startDate = $data["startDate"];
        $endDate = $data["endDate"];
    }

    // switch med olika cases
    switch($method) {
        case "GET":
            if(isset($id)) {
                // skriver ut arbete med motsvarande ID
                $result = $work->getWorkById($id);
            } else {
                // skriver ut alla arbeten
                $result = $work->getWork();
            }

            if(sizeof($result) > 0) {
                http_response_code(200);
            } else {
                // inga arbeten hittades
                http_response_code(404);
                $result = array("message" => "No previous workplace found");
            }
            break;
        case "POST":
            // alla fält måste vara ifyllda
            if($workplace == "" || $title == "" || $startDate == "" || $endDate == "") {
                http_response_code(400);
                $result = array("message" => "Fill all fields!");
            } else {
                // arbete tillagt
                $work->addWork($workplace, $title, $startDate, $endDate);
                http_response_code(201);
                $result = array("message" => "Workplace added!");
            }
            break;
        case "PUT":
            // om ID ej är angivet
            if(!isset($id)) {
                http_response_code(400);
                $result = array("message" => "No id is sent");
            // om ID skickas - uppdatera arbete
            } else { 
                // uppdatering lyckad
                $work->updateWork($id, $workplace, $title, $startDate, $endDate);
                http_response_code(200);
                $result = array("message" => "Workplace was updated!");
            }
            break;
        case "DELETE":
            // om ID ej är angivet
            if(!isset($id)) {
                http_response_code(400);
                $result = array("message" => "No ID is sent");  
                // om ID skickas - radera arbetsplats
            } else {
                // borttagning lyckad
                $work->deleteWork($id);
                http_response_code(200); 
                $result = array("message" => "Workplace with id $id was deleted!");    
            }
            break;
    }
    echo json_encode($result);
    $db = $database->close();