<?php

class EventController extends Controller {

    public function addEvent($postData) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Instantiate the Model to access sanitizeInput
            $model = new Model();

            // Use sanitizeInput through the model instance
            $eventName = $model->sanitizeInput($postData['name']);
            $startDate = $model->sanitizeInput($postData['start_date']);
            $endDate = $model->sanitizeInput($postData['end_date']);
            $venueId = $model->sanitizeInput($postData['venue_id']);

            // Fetch the venue's capacity based on selected venue_id
            $venueModel = new VenueModel();
            $venue = $venueModel->getVenueById($venueId);
            $allowedNumber = $venue['capacity'];

            // Insert event with capacity tied to venue capacity
            $eventModel = new EventModel();
            $eventModel->createEvent($eventName, $startDate, $endDate, $allowedNumber, $venueId);

            // Redirect back to the dashboard to refresh the page
            header("Location: " . PROJECT_URL . "/user/dashboard");
            exit();
        }
    }

    public function updateEvent($postData) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Model(); // Ensure sanitizeInput is available
            $eventId = $model->sanitizeInput($postData['event_id']);
            $eventName = $model->sanitizeInput($postData['event_name']);
            $startDate = $model->sanitizeInput($postData['start_date']);
            $endDate = $model->sanitizeInput($postData['end_date']);
            $allowedNumber = $model->sanitizeInput($postData['allowed_number']);
            $venueId = $model->sanitizeInput($postData['venue_id']);

            $eventModel = new EventModel();
            $eventModel->updateEvent($eventId, $eventName, $startDate, $endDate, $allowedNumber, $venueId);

            header("Location: " . PROJECT_URL . "/user/dashboard");
            exit();
        }
    }

    public function deleteEvent($postData) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventId = $postData['event_id'];
            echo "Delete Event Controller Method Called with event_id: " . $eventId; // Debug statement
            $eventModel = new EventModel();
            $eventModel->deleteEvent($eventId);
            header("Location: " . PROJECT_URL . "/user/dashboard");
            exit(); // Keep this only after the redirect to end the script properly
        }
    }

    public function events() {
        // Check if the user is logged in
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Instantiate the EventModel to get event data
        $eventModel = new EventModel();
        $data['events'] = $eventModel->getAllEventsWithUserStatus($userId);

        // Load the view with event data
        $this->view('user/eventslist', $data);
    }

    public function registerForEvent() {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $eventId = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

            if ($eventId > 0) {
                $attendeeEventModel = new AttendeeEventModel();
                $attendeeEventModel->registerAttendeeForEvent($userId, $eventId);
            }
        }

        // Redirect back to the events page
        header('Location: ' . PROJECT_URL . '/event/events');
        exit();
    }

    public function unregisterFromEvent() {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $eventId = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

            if ($eventId > 0) {
                $attendeeEventModel = new AttendeeEventModel();
                $attendeeEventModel->unregisterAttendeeFromEvent($userId, $eventId);
            }
        }

        // Redirect back to the events page
        header('Location: ' . PROJECT_URL . '/event/events');
        exit();
    }

}

?>
