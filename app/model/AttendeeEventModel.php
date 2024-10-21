<?php

class AttendeeEventModel extends Model {

    public function registerAttendeeForEvent($userId, $eventId, $paid = 0) {
        // Check if the user is already registered for the event
        $sql = "SELECT * FROM attendee_event WHERE attendee_id = :user_id AND event_id = :event_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':event_id' => $eventId]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existing) {
            // Only insert if no existing registration
            $sqlInsert = "INSERT INTO attendee_event (attendee_id, event_id, paid) VALUES (:user_id, :event_id, :paid)";
            $stmtInsert = $this->pdo->prepare($sqlInsert);
            $stmtInsert->execute([
                ':user_id' => $userId,
                ':event_id' => $eventId,
                ':paid' => $paid
            ]);
        }
    }

    public function unregisterAttendeeFromEvent($userId, $eventId) {
        $sql = "DELETE FROM attendee_event WHERE attendee_id = :user_id AND event_id = :event_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
    }

    public function getRegisteredEvents($userId) {
        $sql = "SELECT event_id FROM attendee_event WHERE attendee_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        // Fetch as an array of event IDs
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch only the event IDs as an array
    }

}
