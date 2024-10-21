<?php

class VenueController extends Controller {

    public function addVenue($postData) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Instantiate the Model to access sanitizeInput
            $model = new Model();

            // Use sanitizeInput to clean input data
            $venueName = $model->sanitizeInput($postData['name']);
            $capacity = $model->sanitizeInput($postData['capacity']);

            // Add the new venue to the database
            $venueModel = new VenueModel();
            $venueModel->createVenue($venueName, $capacity);

            // Redirect back to the dashboard to refresh the page
            header("Location: " . PROJECT_URL . "/user/dashboard");
            exit();
        }
    }

    public function updateVenue($postData) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Model(); // Ensure sanitizeInput is available
            $venueId = $model->sanitizeInput($postData['venue_id']);
            $venueName = $model->sanitizeInput($postData['name']);
            $capacity = $model->sanitizeInput($postData['capacity']);

            $venueModel = new VenueModel();
            $venueModel->updateVenue($venueId, $venueName, $capacity);

            header("Location: " . PROJECT_URL . "/user/dashboard");
            exit();
        }
    }

    public function deleteVenue($postData) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $venueId = $postData['venue_id'];
            $venueModel = new VenueModel();
            $venueModel->deleteVenue($venueId);
            header("Location: " . PROJECT_URL . "/user/dashboard");
            exit();
        }
    }

}

?>
