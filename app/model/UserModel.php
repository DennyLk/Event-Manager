<?php

class UserModel extends Model {

    private $validationRules = [
        'username' => [
            'required' => true,
            'min_length' => 2,
            'max_length' => 20,
            'regex' => "/^[a-zA-Z0-9_]+$/"
        ],
        'password' => [
            'required' => true,
            'min_length' => 4,
            'max_length' => 8
        ],
        'email' => [
            'required' => true
        ]
    ];
    private $registeredUsers = [
        'kmarasovic' => [
            'email' => 'kmarasovic@example.com',
            'password' => '1234',
            'user_role' => 1  // Admin
        ],
        'jane' => [
            'email' => 'jane@example.com',
            'password' => '4321',
            'user_role' => 2  // Regular user
        ],
    ];

    /**
     * Retrieves the user information after sanitizing and validating the input.
     *
     * @return array|null|bool Returns an array with `username` and `email` if 
     * credentials are correct, `false` if validation fails, or `null` if the 
     * credentials do not match.
     */
    public function getViewModel() {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        return false; // Validation fails if fields are missing
    }

    $username = $this->sanitize($_POST['username']);
    $password = $_POST['password'];  // Use raw password for comparison

    $sql = "SELECT attendee_id AS user_id, username, password, email, role_id FROM attendee WHERE username = :username";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['password'] === $password) {
        return [
            'user_id' => $user['user_id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'user_role' => $user['role_id']
        ];
    } else {
        echo "Invalid username or password.";
        return null;
    }
}


    public function registerUser($firstName, $lastName, $email, $username, $password, $role) {
        try {
            $sql = "INSERT INTO attendee (first_name, last_name, email, username, password, role_id) 
                VALUES (:first_name, :last_name, :email, :username, :password, :role_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':first_name' => $firstName,
                ':last_name' => $lastName,
                ':email' => $email,
                ':username' => $username,
                ':password' => $password, // Consider hashing
                ':role_id' => $role
            ]);
            echo "User registered successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Output error message
        }
    }

}
