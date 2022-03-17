<?php
    class Projects {
        private $conn;
        private $title;
        private $url;
        private $description;

        // constructor
        public function __construct($db){
            $this->conn = $db;
        }

        // hämta alla projekt
        public function getProjects() {
            $sql = $this->conn->prepare("SELECT * FROM projects ORDER BY ID DESC");
            $sql->execute();

            // hämtar alla rader från db
            return $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        // hämta specifikt projekt
        public function getProjectById(int $id) {
            $sql = $this->conn->prepare("SELECT * FROM projects WHERE id=$id");
            $sql->execute();

            // hämtar rad med motsvarande id från db
            return $result = $sql->fetch(PDO::FETCH_ASSOC);
        }

        // lägg till ny projekt
        public function addProject(string $title, string $url, string $description) {
            // skriver till databasen med värden
            $sql = "INSERT INTO projects (title, url, description) VALUES ('$title', '$url', '$description')";
            
            // exec för att inget returneras
            $this->conn->exec($sql);
        }

        // uppdatera existerande projekt
        public function updateProject(int $id, string $title, string $url, string $description) {
            // uppdaterar databasen med nya värden till ett existerande id
            $sql = "UPDATE projects SET title = '$title', url = '$url', description = '$description' WHERE id=$id";
            
            // exec för att inget returneras
            $this->conn->exec($sql);
        }

        // ta bort projekt
        public function deleteProject(int $id) {
            // radera från databasen med motsvarande id
            $sql = "DELETE FROM projects WHERE id=$id;";
            
            // exec för att inget returneras
            $this->conn->exec($sql);
        }
    }