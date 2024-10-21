<?php

class AttendeeModel extends Model {

    // Other attendee-related methods...

    public function getAllAttendeesWithRegistrations() {
        $sql = "
            SELECT 
                a.username, 
                a.email, 
                e.name AS event_name,
                ae.paid
            FROM attendee a
            LEFT JOIN attendee_event ae ON a.attendee_id = ae.attendee_id
            LEFT JOIN event e ON ae.event_id = e.event_id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Organize data by attendee
        $attendees = [];
        foreach ($results as $row) {
            $attendeeKey = $row['username'];
            if (!isset($attendees[$attendeeKey])) {
                $attendees[$attendeeKey] = [
                    'username' => $row['username'],
                    'email' => $row['email'],
                    'events' => []
                ];
            }
            if ($row['event_name']) { // Only add events if there is a registration
                $attendees[$attendeeKey]['events'][] = [
                    'event_name' => $row['event_name'],
                    'paid' => $row['paid']
                ];
            }
        }

        return array_values($attendees); // Return indexed array for easier iteration in the view
    }
}

?>
