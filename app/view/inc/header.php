<?php

// Add headers to prevent caching after logout
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo TITLE; ?></title>
        <link rel="stylesheet" href="<?php echo PROJECT_URL . '/public/css/style.css'; ?>">
        </head>
    <body>

        <?php if (isset($_SESSION['username'])): ?>
            <nav>
                <ul>
                    <li><a href="<?php echo PROJECT_URL . '/user/eventslist'; ?>">View Events</a></li>

                    <?php if ($_SESSION['user_role'] == 1): // If Admin ?>
                        <li><a href="<?php echo PROJECT_URL . '/user/dashboard'; ?>">Admin Dashboard</a></li>
                    <?php endif; ?>

                    <li><a href="<?php echo PROJECT_URL . '/user/logout'; ?>">Logout</a></li>
                </ul>
            </nav>
        <?php endif; ?>

    </body>
</html>
