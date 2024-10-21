<form method="POST" action="<?php echo PROJECT_URL . '/user/register'; ?>">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" required>
    
    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="username">Username:</label>
    <input type="text" name="username" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <label for="role_id">Role:</label>
    <select name="role_id" required>
        <option value="1">Admin</option>
        <option value="2">Attendee</option>
    </select>

    <button type="submit">Register</button>
</form>
