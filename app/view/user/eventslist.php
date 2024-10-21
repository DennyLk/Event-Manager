
<h1>Event List</h1>

<div class="card-container">

<?php foreach ($data['events'] as $event): ?>
    <div class="event-card">
        <h3><?php echo htmlspecialchars($event['event_name']); ?></h3>
        <p>Start Date: <?php echo htmlspecialchars($event['start_date']); ?></p>
        <div class="details">
            <p>End Date: <?php echo htmlspecialchars($event['end_date']); ?></p>
            <p>Venue Name: <?php echo htmlspecialchars($event['venue_name']); ?></p>
            <p>Venue Capacity: <?php echo htmlspecialchars($event['capacity']); ?></p>
            <p>Registered Attendees: <a href="<?php echo PROJECT_URL . '/index.php?controller=user&action=attendeesList&id=' . $event['event_id']; ?>"><?php echo $event['registered_attendees']; ?></a></p>
            <p>Allowed Attendees: <?php echo htmlspecialchars($event['allowed_number']); ?></p>
        </div>
        <div>
            <?php if ($event['is_registered'] == 1): ?>
                <form action="<?php echo PROJECT_URL; ?>/event/unregisterFromEvent" method="POST" style="display:inline;">
                    <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                    <button type="submit">Unregister</button>
                </form>
            <?php else: ?>
                <form action="<?php echo PROJECT_URL; ?>/event/registerForEvent" method="POST" style="display:inline;">
                    <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                    <button type="submit">Register</button>
                </form>
            <?php endif; ?>
            <button onclick="toggleDetails(this)">Show Details</button>
        </div>
    </div>
<?php endforeach; ?>
</div>
<script>
    function toggleDetails(button) {
        // Find the closest .event-card and then select the .details element within it
        const card = button.closest('.event-card');
        const details = card.querySelector('.details');
        const isHidden = details.style.display === 'none';

        // Toggle visibility of the details
        details.style.display = isHidden ? 'block' : 'none';

        // Update button text
        button.textContent = isHidden ? 'Hide Details' : 'Show Details';
    }
</script>
