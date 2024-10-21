<?php

class Controller {

    public function __construct() {
        // Initialize session
        Session::start();

        // Check if session has expired
        if (Session::isExpired()) {
            Session::destroy();
            // Redirect to the login page after session expiration
            header('Location: ' . PROJECT_URL . '/user/login');
            exit();
        }
    }

    public function model() {
        $model = str_replace("Controller", "Model", get_class($this));
        require_once 'app/model/' . $model . '.php';
        return new $model();
    }

    public function view($template, $data = []) {
        if (!file_exists('app/view/' . $template . '.php')) {
            throw new Exception("Template file " . $template . " doesn't exist.");
        }

        require 'app/view/inc/header.php';
        require 'app/view/' . $template . '.php';
        require 'app/view/inc/footer.php';
    }
}
