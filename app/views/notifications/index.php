<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<section class="notifications">
    <div class="container">
        <div class="section-header">
            <h1>Notifications</h1>
            <div class="header-actions">
                <?php if (isset($unread_count) && $unread_count > 0): ?>
                    <a href="/notifications/mark-all-read" class="btn btn-outline" onclick="return confirm('Mark all notifications as read?');">
                        <i class="fas fa-check-double"></i> Mark All as Read
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="notifications-filter">
            <div class="filter-tabs">
                <a href="/notifications" class="tab <?php echo !isset($_GET['filter']) || $_GET['filter'] === 'all' ? 'active' : ''; ?>">
                    All <span class="count"><?php echo isset($total_count) ? $total_count : 0; ?></span>
                </a>
                <a href="/notifications?filter=unread" class="tab <?php echo isset($_GET['filter']) && $_GET['filter'] === 'unread' ? 'active' : ''; ?>">
                    Unread <span class="count"><?php echo isset($unread_count) ? $unread_count : 0; ?></span>
                </a>
            </div>
        </div>
        
        <?php if (isset($notifications) && !empty($notifications)): ?>
            <div class="notifications-list">
                <?php foreach ($notifications as $notification): ?>
                    <div class="notification-item <?php echo $notification->is_read ? 'read' : 'unread'; ?>" data-id="<?php echo $notification->id; ?>">
                        <div class="notification-icon">
                            <?php if ($notification->type === 'transaction'): ?>
                                <i class="fas fa-exchange-alt"></i>
                            <?php elseif ($notification->type === 'bill'): ?>
                                <i class="fas fa-file-invoice-dollar"></i>
                            <?php elseif ($notification->type === 'account'): ?>
                                <i class="fas fa-university"></i>
                            <?php elseif ($notification->type === 'security'): ?>
                                <i class="fas fa-shield-alt"></i>
                            <?php elseif ($notification->type === 'system'): ?>
                                <i class="fas fa-cogs"></i>
                            <?php else: ?>
                                <i class="fas fa-bell"></i>
                            <?php endif; ?>
                        </div>
                        
                        <div class="notification-content">
                            <div class="notification-header">
                                <h3><?php echo htmlspecialchars($notification->title); ?></h3>
                                <span class="notification-time"><?php echo date('M j, Y', strtotime($notification->created_at)); ?></span>
                            </div>
                            <div class="notification-message">
                                <p><?php echo htmlspecialchars($notification->message); ?></p>
                            </div>
                            
                            <?php if (!empty($notification->action_url)): ?>
                                <div class="notification-action">
                                    <a href="<?php echo htmlspecialchars($notification->action_url); ?>" class="btn btn-sm btn-primary">
                                        <?php echo !empty($notification->action_text) ? htmlspecialchars($notification->action_text) : 'View Details'; ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="notification-actions">
                            <?php if (!$notification->is_read): ?>
                                <a href="/notifications/mark-read/<?php echo $notification->id; ?>" class="action-link" title="Mark as Read">
                                    <i class="fas fa-check"></i>
                                </a>
                            <?php endif; ?>
                            <a href="/notifications/delete/<?php echo $notification->id; ?>" class="action-link" title="Delete" onclick="return confirm('Delete this notification?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-notifications">
                <div class="empty-state">
                    <i class="fas fa-bell-slash empty-icon"></i>
                    <h2>No Notifications</h2>
                    <p>You don't have any notifications at the moment.</p>
                    <a href="/dashboard" class="btn btn-primary">Back to Dashboard</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?> 