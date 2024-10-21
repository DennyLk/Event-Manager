<?php

class Model {

    // Sanitize
    protected function sanitize($data) {
        $cleanData = trim($data);
        $cleanData = strip_tags($cleanData);
        $cleanData = htmlspecialchars($cleanData, ENT_QUOTES, 'UTF-8');

        return $cleanData;
    }

    public function sanitizeInput($data) {
        return $this->sanitize($data);
    }

    // Validation
    protected function validate($data, array $rules): bool {
        foreach ($rules as $rule => $ruleSet) {


            //minimum length
            if (isset($ruleSet['min_length']) && strlen($data[$rule]) < $ruleSet['min_length']) {
                return false; // Value is shorter than the minimum length
            }

            //maximum length
            if (isset($ruleSet['max_length']) && strlen($data[$rule]) > $ruleSet['max_length']) {
                return false; // Value is longer than the maximum length
            }

            //numeric
            if (!empty($ruleSet['numeric']) && !is_numeric($data[$rule])) {
                return false; // Value is expected to be numeric but is not
            }

            //pattern
            if (isset($ruleSet['regex']) && !preg_match($ruleSet['regex'], $data[$rule])) {
                return false; // Value does not match the regular expression pattern
            }
        }

        return true;
    }

    protected $pdo;

    public function __construct() {
        // Use constants defined in the config.php file for the database connection
        require_once 'app/config.php';
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
    
        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    

}
