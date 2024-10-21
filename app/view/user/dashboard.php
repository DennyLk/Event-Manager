<div class="admin-dashboard">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION['username']; ?> (Admin)</p>

    <h3>Manage Events</h3>
    <!-- Add Event Form -->
    <form method="POST" action="<?php echo PROJECT_URL; ?>/event/addEvent">
        <h4>Add New Event</h4>
        <input type="text" name="name" placeholder="Event Name" required>
        <input type="date" name="start_date" required>
        <input type="date" name="end_date" required>

        <label for="venue_id">Select Venue:</label>
        <select name="venue_id" required>
            <?php foreach ($data['venues'] as $venue): ?>
                <option value="<?php echo $venue['venue_id']; ?>">
                    <?php echo "{$venue['name']} (Capacity: {$venue['capacity']})"; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Add Event</button>
    </form>

    <!-- Display All Events -->
    <table class="styled-table">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Venue</th>
                <th>Allowed Attendees</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['events'] as $event): ?>
                <tr>
                    <!-- Update Event Form -->
            <form method="POST" action="<?php echo PROJECT_URL; ?>/event/updateEvent">
                <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                <td><input type="text" name="event_name" value="<?php echo htmlspecialchars($event['event_name']); ?>" readonly></td>
                <td><input type="date" name="start_date" value="<?php echo date('Y-m-d', strtotime($event['start_date'])); ?>" readonly></td>
                <td><input type="date" name="end_date" value="<?php echo date('Y-m-d', strtotime($event['end_date'])); ?>" readonly></td>
                <td>
                    <select name="venue_id" disabled>
                        <?php foreach ($data['venues'] as $venue): ?>
                            <option value="<?php echo $venue['venue_id']; ?>" <?php echo ($event['venue_name'] == $venue['name']) ? 'selected' : ''; ?>>
                                <?php echo $venue['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" name="allowed_number" value="<?php echo htmlspecialchars($event['allowed_number']); ?>" readonly></td>
                <td>
                    <button type="button" onclick="makeEditable(this)">Edit</button>
                    <button type="submit" style="display:none;">Save</button>
                </td>
            </form>

            <!-- Delete Event Form (Separate Form) -->
            <td>
                <form method="POST" action="<?php echo PROJECT_URL; ?>/event/deleteEvent" style="display:inline;">
                    <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                    <button type="submit">Delete Event</button>
                </form>
            </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>

    <h3>Manage Venues</h3>
    <!-- Add Venue Form -->
    <form method="POST" action="<?php echo PROJECT_URL; ?>/venue/addVenue">
        <h4>Add New Venue</h4>
        <input type="text" name="name" placeholder="Venue Name" required>
        <input type="number" name="capacity" placeholder="Capacity" required>
        <button type="submit">Add Venue</button>
    </form>

    <!-- Display All Venues -->
    <table class="styled-table">
        <thead>
            <tr>
                <th>Venue Name</th>
                <th>Capacity</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['venues'] as $venue): ?>
                <tr>
            <form method="POST" action="<?php echo PROJECT_URL; ?>/venue/updateVenue">
                <input type="hidden" name="venue_id" value="<?php echo $venue['venue_id']; ?>">
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($venue['name']); ?>" readonly></td>
                <td><input type="number" name="capacity" value="<?php echo htmlspecialchars($venue['capacity']); ?>" readonly></td>
                <td>
                    <button type="button" onclick="makeEditable(this)">Edit</button>
                    <button type="submit" style="display:none;">Save</button>
                </td>

            </form>
            <td>
                <form method="POST" action="<?php echo PROJECT_URL; ?>/venue/deleteVenue">
                    <input type="hidden" name="venue_id" value="<?php echo $venue['venue_id']; ?>">
                    <button type="submit">Delete Venue</button>
                </form>
            </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    
    <h3>Manage Attendees and Event Registrations</h3>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Event Name</th>
                <th>Paid</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['attendees'] as $attendee): ?>
                <tr>
                    <td><?php echo htmlspecialchars($attendee['username']); ?></td>
                    <td><?php echo htmlspecialchars($attendee['email']); ?></td>
                    <td>
                        <?php if (!empty($attendee['events'])): ?>
                            <ul>
                                <?php foreach ($attendee['events'] as $event): ?>
                                    <li><?php echo htmlspecialchars($event['event_name']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            No registrations
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($attendee['events'])): ?>
                            <ul>
                                <?php foreach ($attendee['events'] as $event): ?>
                                    <li><?php echo $event['paid'] ? 'Yes' : 'No'; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function makeEditable(button) {
        const row = button.closest('tr');
        const inputs = row.querySelectorAll('input, select');

        // Enable editing for all inputs in the row
        inputs.forEach(input => {
            input.removeAttribute('readonly');
            input.removeAttribute('disabled');
        });

        // Toggle visibility of the Edit and Save buttons
        button.style.display = 'none';
        row.querySelector('button[type="submit"]').style.display = 'inline';
    }
</script>
