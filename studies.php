<?php
    include_once("config/config.php");
    include_once ("config/Database.php");

    $database = new Database();
    $db = $database->connect();

    $studies = new Studies($db);

    // lagrar metod som skickats i variabel
    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents('php://input'), true);

    // om ID skickas lagras den i variabel
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    // stoppar in värden i variabler
    if(isset($data)) {
        $location = $data["location"];
        $name = $data["name"];
        $startDate = $data["startDate"];
        $endDate = $data["endDate"];
    }

    // switch med olika cases
    switch($method) {
        case "GET":
            if(isset($id)) {
                // skriver ut studie med motsvarande ID
                $result = $studies->getStudyById($id);
            } else {
                // skriver ut alla studier
                $result = $studies->getStudies();
            }

            if(sizeof($result) > 0) {
                http_response_code(200);
            } else {
                // inga studier hittades
                http_response_code(404);
                $result = array("message" => "No studies found");
            }
            break;
        case "POST":
            // alla fält måste vara ifyllda
            if($location == "" || $name == "" || $startDate == "" || $endDate == "") {
                http_response_code(400);
                $result = array("message" => "Fill all fields!");
            } else {
                // studie tillagd
                $studies->addStudy($location, $name, $startDate, $endDate);
                http_response_code(201);
                $result = array("message" => "Study added!");
            }
            break;
        case "PUT":
            // om ID ej är angivet
            if(!isset($id)) {
                http_response_code(400); 
                $result = array("message" => "No ID is sent");
            // om ID skickas - uppdatera studie 
            } else {
                // uppdatering lyckad
                $studies->updateStudy($id, $location, $name, $startDate, $endDate);
                http_response_code(200);
                $result = array("message" => "Study with id $id was updated!");
            }
            break;
        case "DELETE":
            // om ID ej är angivet
            if(!isset($id)) {
                http_response_code(400);
                $result = array("message" => "No ID is sent");  
            // om id skickas - radera studie
            } else {
                    // borttagning lyckad
                    $studies->deleteStudy($id);
                    http_response_code(200);
                    $result = array("message" => "Study with id $id was deleted!");    
            }
            break;
    }

    echo json_encode($result);
    $db = $database->close();