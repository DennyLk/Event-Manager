<?php

class UserController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $_SESSION['last_activity_time'] = time();

        $this->view("user/login");
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header("Location: " . PROJECT_URL . "/user/login");
        exit();
    }

    public function welcome() {
        $data = $this->model()->getViewModel();

        if ($data !== false && $data !== null) {
            $_SESSION['user_id'] = $data['user_id'];  // Set user ID in session
            $_SESSION['username'] = $data['username'];
            $_SESSION['user_role'] = $data['user_role']; // Set user role (1 for admin, 2 for user)

            $this->view("user/welcome", $data);
        } else {
            echo "Incorrect username or password.";
        }
    }

    // Admin dashboard view
    // Sample controller function to fetch attendees and their registered events
    public function dashboard() {
        // Instantiate the models
        $eventModel = new EventModel();
        $venueModel = new VenueModel();
        $attendeeModel = new AttendeeModel(); // Create this if you haven't already
        // Fetch data for events, venues, and attendees with registrations
        $events = $eventModel->getAllEventsWithUserStatus($_SESSION['user_id'] ?? null);
        $venues = $venueModel->getAllVenues();
        $attendees = $attendeeModel->getAllAttendeesWithRegistrations();

        // Pass data to the view
        $this->view("user/dashboard", [
            'events' => $events,
            'venues' => $venues,
            'attendees' => $attendees
        ]);
    }

    // Method to render the register page
    public function register() {
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "Form Submitted"; // Debugging line

            $model = new UserModel();

            // Sanitize input data
            $firstName = $model->sanitizeInput($_POST['first_name']);
            $lastName = $model->sanitizeInput($_POST['last_name']);
            $email = $model->sanitizeInput($_POST['email']);
            $username = $model->sanitizeInput($_POST['username']);
            $password = $model->sanitizeInput($_POST['password']);
            $role = $model->sanitizeInput($_POST['role_id']); // Admin (1) or Attendee (2)
            // Register the user using the UserModel
            $model->registerUser($firstName, $lastName, $email, $username, $password, $role);

            // Redirect to login page after registration
            header("Location: " . PROJECT_URL . "/user/login");
            exit();
        } else {
            // Load the registration form
            $this->view("user/register");
        }
    }

    // Method to view specific event details
    public function viewEventDetails() {
        // Add logic to display specific event details
    }

    // Method to display list of events for admins
    public function eventsList() {
        $eventModel = new EventModel();
        $events = $eventModel->getAllEventsWithUserStatus(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);

        // Render the events list view
        $this->view("user/eventslist", ['events' => $events]);
    }

}

?>
