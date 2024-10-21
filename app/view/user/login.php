<form method="POST" action="<?php echo PROJECT_URL . '/user/welcome'; ?>">

    <div class="imgcontainer">
        <img src="<?php echo PROJECT_URL . '/public/img/avatar.png'; ?>" alt="Avatar" class="avatar">
    </div>
    <div class="container">
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" required>

        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Password" name="password" required>

        <button type="submit">Login</button>


        <p>Don't have an account?<a href="<?php echo PROJECT_URL . '/user/register'; ?>">Register</a>
        </p>
    </div>
</form>
