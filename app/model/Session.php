<?php

final class Session {

    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function destroy() {
        $_SESSION = [];

        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]);
        }

        header("Location: " . PROJECT_URL . "/user/login");
        exit();
    }

    public static function isExpired() {
        // Make sure the $config array is available in this function
        global $config;
       

        // Ensure session timeout is set in the config
        if (!isset($config['session']['session_timeout'])) {
            throw new Exception("Session timeout configuration is missing.");
        }

        // Get session timeout value
        $timeout = $config['session']['session_timeout'];

        // Check if last activity time is set
        if (isset($_SESSION['last_activity_time'])) {
            $elapsedTime = time() - $_SESSION['last_activity_time'];

            // If the elapsed time exceeds the session timeout, return true
            if ($elapsedTime > $timeout) {
                return true;
            }
        } else {
            // If last activity time is not set, set it now
            $_SESSION['last_activity_time'] = time();
        }

        // Update last activity time
        $_SESSION['last_activity_time'] = time();

        return false;
    }
}
