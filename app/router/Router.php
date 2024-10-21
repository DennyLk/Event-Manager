<?php

final class Router {

    private $controller = "UserController";
    private $action = "login";
    private $params = [];

    public function dispatch() {
        // Automatically detect the base path and trim it from the request URI
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']); // This gives the directory path like '/~dal4933/ISTE-341/project-1'
        // Trim the base path from the URI
        $uri = str_replace($scriptDir, '', $_SERVER['REQUEST_URI']);

        // Remove leading/trailing slashes and split the remaining path into parts
        $uriParts = explode('/', trim($uri, '/'));

        // Remove empty elements
        $uriParts = array_values(array_filter($uriParts));

        // Assuming the first part after base path is the controller, and the second is the action
        if (isset($uriParts[0])) {
            $this->controller = ucfirst($uriParts[0]) . 'Controller';
        }
        if (isset($uriParts[1])) {
            $this->action = $uriParts[1];
        }
        


        // Optionally capture parameters from URL
        if (isset($_GET['id'])) {
            $this->params[] = (int) $_GET['id'];
        }

        // Debug output to confirm routing
        // Check if controller exists and dispatch the request
        if (class_exists($this->controller)) {
            $controllerObj = new $this->controller();

            if (is_callable([$controllerObj, $this->action])) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controllerObj->{$this->action}($_POST);
                } else {
                    $controllerObj->{$this->action}($this->params);
                }
            } else {
                throw new Exception("Method '$this->action' in controller '$this->controller' not found");
            }
        } else {
            throw new Exception("Controller class '$this->controller' not found");
        }
    }

}
