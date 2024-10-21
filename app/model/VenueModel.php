<?php

class VenueModel extends Model {

    public function createVenue($name, $capacity) {
        $sql = "INSERT INTO venue (name, capacity) VALUES (:name, :capacity)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':capacity' => $capacity
        ]);
    }

    public function getAllVenues() {
        $sql = "SELECT venue_id, name, capacity FROM venue";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVenueById($venueId) {
        $sql = "SELECT * FROM venue WHERE venue_id = :venue_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':venue_id' => $venueId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateVenue($venueId, $name, $capacity) {
        $sql = "UPDATE venue SET name = :name, capacity = :capacity WHERE venue_id = :venue_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':capacity' => $capacity,
            ':venue_id' => $venueId
        ]);
    }

    public function deleteVenue($venueId) {
        $sql = "DELETE FROM venue WHERE venue_id = :venue_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':venue_id' => $venueId]);
    }

}
