<?php
require_once __DIR__ . '/header.php';

$pdo = getDBConnection();

$totalPages = $pdo->query("SELECT COUNT(*) FROM pages")->fetchColumn();
$totalCourses = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$totalNews = $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
$totalEnquiries = $pdo->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();

$recentEnquiries = $pdo->query("SELECT * FROM enquiries ORDER BY id DESC LIMIT 5")->fetchAll();
?>

<div class="grid-4" style="margin-bottom: 40px;">
    <div class="card" style="border-left: 4px solid var(--primary-maroon);">
        <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Total Pages</div>
        <div style="font-size: 2.2rem; font-weight: 800; color: var(--dark-navy); margin: 8px 0;"><?php echo $totalPages; ?></div>
        <a href="manage_pages.php" style="font-size: 0.85rem; color: var(--primary-maroon); font-weight: 600;">Manage Pages &rarr;</a>
    </div>

    <div class="card" style="border-left: 4px solid var(--accent-gold);">
        <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Active Courses</div>
        <div style="font-size: 2.2rem; font-weight: 800; color: var(--dark-navy); margin: 8px 0;"><?php echo $totalCourses; ?></div>
        <a href="manage_courses.php" style="font-size: 0.85rem; color: var(--primary-maroon); font-weight: 600;">Manage Courses &rarr;</a>
    </div>

    <div class="card" style="border-left: 4px solid #0284c7;">
        <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">News & Notices</div>
        <div style="font-size: 2.2rem; font-weight: 800; color: var(--dark-navy); margin: 8px 0;"><?php echo $totalNews; ?></div>
        <a href="manage_news.php" style="font-size: 0.85rem; color: var(--primary-maroon); font-weight: 600;">Manage News &rarr;</a>
    </div>

    <div class="card" style="border-left: 4px solid #16a34a;">
        <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Admission Leads</div>
        <div style="font-size: 2.2rem; font-weight: 800; color: var(--dark-navy); margin: 8px 0;"><?php echo $totalEnquiries; ?></div>
        <a href="manage_enquiries.php" style="font-size: 0.85rem; color: var(--primary-maroon); font-weight: 600;">View Leads &rarr;</a>
    </div>
</div>

<div style="background: #ffffff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
    <h3 style="font-family: var(--font-heading); color: var(--dark-navy); margin-bottom: 20px;">Recent Admission Enquiries</h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($recentEnquiries)): ?>
                <?php foreach ($recentEnquiries as $eq): ?>
                    <tr>
                        <td>#<?php echo $eq['id']; ?></td>
                        <td><strong><?php echo sanitize($eq['name']); ?></strong></td>
                        <td><?php echo sanitize($eq['email']); ?></td>
                        <td><?php echo sanitize($eq['phone']); ?></td>
                        <td><span style="background: var(--light-bg); padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;"><?php echo sanitize($eq['course']); ?></span></td>
                        <td><small><?php echo sanitize($eq['created_at']); ?></small></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted);">No admission enquiries received yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
