<?php
/**
 * Admin Dashboard View
 */
?>

<section class="section admin-dashboard">
    <div class="container">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            <a href="/admin/logout" class="btn btn-secondary">Logout</a>
        </div>

        <div class="admin-stats">
            <div class="stat-card">
                <h3>Total Tours</h3>
                <p class="stat-number"><?php echo htmlspecialchars($toursCount ?? 0); ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Bookings</h3>
                <p class="stat-number"><?php echo htmlspecialchars($bookingsCount ?? 0); ?></p>
            </div>
        </div>

        <div class="admin-section">
            <h2>Recent Bookings</h2>
            <?php if (empty($bookings)): ?>
            <p>No bookings yet.</p>
            <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Tour</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['id'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($booking['name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($booking['email'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($booking['tour_title'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($booking['date'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($booking['status'] ?? 'pending'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <div class="admin-actions">
            <a href="/admin/tours" class="btn btn-primary">Manage Tours</a>
        </div>
    </div>
</section>

