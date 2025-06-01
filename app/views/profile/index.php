<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<section class="page-container">
    <div class="page-header">
        <div class="page-title">My Profile</div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="tabs mb-4">
                <div class="tab active" data-tab="personal-info">Personal Information</div>
                <div class="tab" data-tab="security">Security</div>
            </div>
            
            <div class="tab-content">
                <div class="tab-pane active" id="personal-info">
                    <form action="<?php echo APP_URL; ?>/profile/update" method="POST" class="profile-form">
                        <h3 class="mb-4">Personal Details</h3>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo isset($user) ? htmlspecialchars($user['first_name']) : ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo isset($user) ? htmlspecialchars($user['last_name']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($user) ? htmlspecialchars($user['email']) : ''; ?>" readonly>
                                    <div class="form-text">Email cannot be changed. Contact support for assistance.</div>
                                </div>
                            </div>
                            
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo isset($user) ? htmlspecialchars($user['phone']) : ''; ?>">
                                </div>
                            </div>
                        </div>
                         
                        
                        <div class="form-group mb-0 mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
                
                <div class="tab-pane" id="security">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="card-title">Change Password</div>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo APP_URL; ?>/profile/change-password" method="POST" class="profile-form">
                                <div class="form-group">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                                    <div class="form-text">Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                                </div>
                                
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    
                </div>
                
                 
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab navigation
        const tabs = document.querySelectorAll('.tab');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Remove active class from all tabs and panes
                tabs.forEach(t => t.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));
                
                // Add active class to current tab and pane
                this.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>
 