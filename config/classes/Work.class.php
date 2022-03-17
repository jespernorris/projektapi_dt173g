<?php
    class Work {
        private $conn;
        private $workplace;
        private $title;
        private $endDate;
        private $startDate;

        // constructor
        public function __construct($db){
            $this->conn = $db;
        }

        // hämta alla kurser
        public function getWork() {
            $sql = $this->conn->prepare("SELECT * FROM work ORDER BY ID DESC");
            $sql->execute();

            // hämtar alla rader från db
            return $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        // hämta specifik kurs
        public function getWorkById(int $id) {
            $sql = $this->conn->prepare("SELECT * FROM work WHERE id=$id");
            $sql->execute();

            // hämtar rad med motsvarande id från db
            return $result = $sql->fetch(PDO::FETCH_ASSOC);
        }

        // lägg till ny kurs
        public function addWork(string $workplace, string $title, string $startDate, string $endDate) {
            // skriver till databasen med värden
            $sql = "INSERT INTO work (workplace, title, startDate, endDate) VALUES ('$workplace', '$title', '$startDate', '$endDate')";

            // exec för att inget returneras
            $this->conn->exec($sql);
        }

        // uppdatera existerande kurs
        public function updateWork(int $id, string $workplace, string $title, string $startDate, string $endDate) {
            // uppdaterar databasen med nya värden till ett existerande id
            $sql = "UPDATE work SET workplace = '$workplace', title = '$title', startDate = '$startDate', endDate = '$endDate' WHERE id=$id;";

            // exec för att inget returneras
            $this->conn->exec($sql);
        }

        // ta bort kurs
        public function deleteWork(int $id) {
            // radera från databasen med motsvarande id
            $sql = "DELETE FROM work WHERE id=$id";

            // exec för att inget returneras
            $this->conn->exec($sql);
        }
    }