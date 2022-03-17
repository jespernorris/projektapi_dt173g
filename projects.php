<?php
    include_once("config/config.php");
    include_once ("config/Database.php");

    $database = new Database();
    $db = $database->connect();

    $projects = new Projects($db);

    // lagrar metod som skickats i variabel
    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents('php://input'), true);

    // om ID skickas lagras den i variabel
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    // stoppar in värden i variabler
    if(isset($data)) {
        $title = $data["title"];
        $url = $data["url"];
        $description = $data["description"];
    }

    // switch med olika cases
    switch($method) {
        case "GET":
            if(isset($id)) {
                // skriver ut projekt med motsvarande ID
                $result = $projects->getProjectById($id);
            } else {
                // skriver ut alla projekt
                $result = $projects->getProjects();
            }

            if(sizeof($result) > 0) {
                http_response_code(200);
            } else {
                // inget projekt hittades
                http_response_code(404);
                $result = array("message" => "No projects found");
            }
            break;
        case "POST":
            // alla fält måste vara ifyllda
            if($title == "" || $url == "" || $description == "") {
                http_response_code(400);
                $result = array("message" => "Fill all fields!");
            } else {
                // projekt tillagt
                $projects->addProject($title, $url, $description);
                http_response_code(201);
                $result = array("message" => "Project added!");
            }
            break;
        case "PUT":
            // om ID ej är angivet
            if(!isset($id)) {
                http_response_code(400); 
                $result = array("message" => "No ID is sent"); 
            // om ID skickas - uppdatera projekt
            } else {
                // uppdatering lyckad
                $projects->updateProject($id, $title, $url, $description);
                http_response_code(200);
                $result = array("message" => "Project with id $id was updated!");
            }
            break;
        case "DELETE":
            // om id ej är angivet
            if(!isset($id)) {
                http_response_code(400);
                $result = array("message" => "No ID is sent");  
            // om ID skickas - radera projekt
            } else {
                // borttagning lyckad
                $projects->deleteProject($id);
                http_response_code(200);
                $result = array("message" => "Project with id $id was deleted!");    
            }
            break;
    }
    
    echo json_encode($result);
    $db = $database->close();