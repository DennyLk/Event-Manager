<div class="event-details-container">
    <h2><?php echo $data['event']['name']; ?></h2>
    <p><strong>Venue:</strong> <?php echo $data['event']['venue']; ?></p>
    <p><strong>Date:</strong> <?php echo $data['event']['date']; ?></p>
    <p><strong>Description:</strong> <?php echo $data['event']['description']; ?></p>
    <p><strong>Seats Available:</strong> <?php echo $data['event']['seats']; ?></p>
    <a href="<?php echo PROJECT_URL ?>/index.php?controller=user&action=eventsList">Back to Events List</a>
</div>
