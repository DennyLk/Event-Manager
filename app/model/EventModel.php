<?php

class EventModel extends Model {

    public function getAllEventsWithUserStatus($userId = null) {
        // Query to fetch event data along with venue name, capacity, and user registration status
        $sql = "
            SELECT 
                e.event_id, 
                e.name AS event_name, 
                e.start_date, 
                e.end_date, 
                e.allowed_number, 
                v.name AS venue_name, 
                v.capacity, 
                COUNT(ae.attendee_id) AS registered_attendees,
                CASE 
                    WHEN EXISTS (
                        SELECT 1 
                        FROM attendee_event ae_user
                        WHERE ae_user.event_id = e.event_id 
                        AND ae_user.attendee_id = :user_id
                    ) THEN 1
                    ELSE 0
                END AS is_registered
            FROM event e
            LEFT JOIN venue v ON e.venue_id = v.venue_id
            LEFT JOIN attendee_event ae ON e.event_id = ae.event_id
            GROUP BY e.event_id
        ";

        // Prepare and execute the query with the user ID parameter
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        // Fetch the result as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEvent($name, $startDate, $endDate, $allowedNumber, $venueId) {
        $sql = "INSERT INTO event (name, start_date, end_date, allowed_number, venue_id) 
            VALUES (:name, :start_date, :end_date, :allowed_number, :venue_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':allowed_number' => $allowedNumber,
            ':venue_id' => $venueId
        ]);
    }

    public function getEventById($eventId) {
        $sql = "SELECT * FROM event WHERE event_id = :event_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':event_id' => $eventId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEvent($eventId, $name, $startDate, $endDate, $allowedNumber, $venueId) {
        $sql = "UPDATE event SET name = :name, start_date = :start_date, end_date = :end_date, 
                allowed_number = :allowed_number, venue_id = :venue_id WHERE event_id = :event_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':allowed_number' => $allowedNumber,
            ':venue_id' => $venueId,
            ':event_id' => $eventId
        ]);
    }

    public function deleteEvent($eventId) {
        $sql = "DELETE FROM event WHERE event_id = :event_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':event_id' => $eventId]);
    }

}

?>
