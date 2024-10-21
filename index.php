<?php
require_once 'app/config.php';

final class Index {

    public static function run() {
        self::init();
        self::handle();
    }

    private static function init() {
        // Set error reporting to show all errors

        
        // Register autoload function to load classes automatically
        spl_autoload_register(['Index', 'loadClass']);
        
        // Define constants for project root directory and URL
        define('PROJECT_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');
        define('PROJECT_URL', 'http://localhost/LulakDP');
        define('TITLE', 'MVC with OO PHP');
    }

    private static function handle() {
        // Route directly, allowing Router to handle URL parsing
        try {
            $router = new Router();
            $router->dispatch();
        } catch (Exception $e) {
            // Handle any exceptions, like missing controller/action
            echo "Error: " . $e->getMessage();
        }
    }

    private static function loadClass($class_name) {
        // Define an array of directories where classes might be located
        $dirs = [
            'app/',
            'app/router/',
            'app/model/',
            'app/view/',
            'app/controller/',
            'app/db/'
        ];

        // Iterate over directories to find and require the class file
        foreach ($dirs as $dir) {
            if (file_exists($dir . $class_name . '.php')) {
                require_once($dir . $class_name . '.php');
                return true;
            }
        }
        return false;
    }
}

// Run the application
Index::run();
