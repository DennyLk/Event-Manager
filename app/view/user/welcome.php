<h2>Event Management System</h2>



<h1>WELCOME <?php echo $data['username']; ?>!</h1>
<h3>Your email is: <?php echo $data['email']; ?></h3>
<p>You are logged in as: 
    <?php
    if ($data['user_role'] == 1) {
        echo "Admin";
    } else {
        echo "User";
    }
    ?>
</p>

