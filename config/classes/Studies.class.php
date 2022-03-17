<?php
    class Studies {
        private $conn;
        private $location;
        private $name;
        private $endDate;
        private $startDate;

        // constructor
        public function __construct($db){
            $this->conn = $db;
        }

        // hämta alla studier
        public function getStudies() {
            $sql = $this->conn->prepare("SELECT * FROM studies ORDER BY ID DESC");
            $sql->execute();

            // hämtar alla rader från db
            return $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        // hämta specifik studie
        public function getStudyById(int $id) {
            $sql = $this->conn->prepare("SELECT * FROM studies WHERE id=$id");
            $sql->execute();

            // hämtar rad med motsvarande id från db
            return $result = $sql->fetch(PDO::FETCH_ASSOC);
        }

        // lägg till ny studie
        public function addStudy(string $location, string $name, string $startDate, string $endDate) {
            // skriver till databasen med värden
            $sql = "INSERT INTO studies (location, name, startDate, endDate) VALUES ('$location', '$name', '$startDate', '$endDate')";

            // exec för att inget returneras
            $this->conn->exec($sql);
        }

        // uppdatera existerande studie
        public function updateStudy(int $id, string $location, string $name, string $startDate, string $endDate) {
            // uppdaterar databasen med nya värden till ett existerande id
            $sql = "UPDATE studies SET location = '$location', name = '$name', startDate = '$startDate', endDate = '$endDate' WHERE id=$id";
            
            // exec för att inget returneras
            $this->conn->exec($sql);
        }

        // ta bort studie
        public function deleteStudy(int $id) {
            // radera från databasen med motsvarande id
            $sql = "DELETE FROM studies WHERE id=$id;";
            
            // exec för att inget returneras
            $this->conn->exec($sql);
        }
    }