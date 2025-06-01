<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<section class="profile-edit">
    <div class="container">
        <div class="section-header">
            <h1>Edit Profile</h1>
            <div class="actions">
                <a href="<?php echo APP_URL; ?>/profile" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Profile</a>
            </div>
        </div>
        
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['flash_message']['type']; ?>">
                <?php echo htmlspecialchars($_SESSION['flash_message']['message']); ?>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
        
        <div class="profile-form-container">
            <form action="<?php echo APP_URL; ?>/profile/update" method="POST" class="profile-form">
                <div class="form-section">
                    <h2>Personal Details</h2>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo isset($user) ? htmlspecialchars($user['first_name']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo isset($user) ? htmlspecialchars($user['last_name']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo isset($user) ? htmlspecialchars($user['email']) : ''; ?>" readonly>
                            <small class="form-text">Email cannot be changed. Contact support for assistance.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo isset($user) ? htmlspecialchars($user['phone']) : ''; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h2>Address Information</h2>
                    
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="address_line1">Address Line 1</label>
                            <input type="text" id="address_line1" name="address_line1" value="<?php 
                                if (isset($user) && !empty($user['address'])) {
                                    $address_lines = explode("\n", $user['address']);
                                    echo htmlspecialchars($address_lines[0] ?? '');
                                } else {
                                    echo '';
                                }
                            ?>">
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="address_line2">Address Line 2 (Optional)</label>
                            <input type="text" id="address_line2" name="address_line2" value="<?php 
                                if (isset($user) && !empty($user['address'])) {
                                    $address_lines = explode("\n", $user['address']);
                                    echo htmlspecialchars($address_lines[1] ?? '');
                                } else {
                                    echo '';
                                }
                            ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="<?php 
                                if (isset($user) && !empty($user['address'])) {
                                    $address_lines = explode("\n", $user['address']);
                                    $city_state_zip = isset($address_lines[2]) ? explode(',', $address_lines[2]) : [''];
                                    echo htmlspecialchars(trim($city_state_zip[0] ?? ''));
                                } else {
                                    echo '';
                                }
                            ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="state">State/Province</label>
                            <input type="text" id="state" name="state" value="<?php 
                                if (isset($user) && !empty($user['address'])) {
                                    $address_lines = explode("\n", $user['address']);
                                    $city_state_zip = isset($address_lines[2]) ? explode(',', $address_lines[2]) : ['', ''];
                                    if (isset($city_state_zip[1])) {
                                        $state_zip = explode(' ', trim($city_state_zip[1]));
                                        echo htmlspecialchars($state_zip[0] ?? '');
                                    }
                                } else {
                                    echo '';
                                }
                            ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="postal_code">Postal/ZIP Code</label>
                            <input type="text" id="postal_code" name="postal_code" value="<?php 
                                if (isset($user) && !empty($user['address'])) {
                                    $address_lines = explode("\n", $user['address']);
                                    $city_state_zip = isset($address_lines[2]) ? explode(',', $address_lines[2]) : ['', ''];
                                    if (isset($city_state_zip[1])) {
                                        $state_zip = explode(' ', trim($city_state_zip[1]));
                                        echo htmlspecialchars($state_zip[1] ?? '');
                                    }
                                } else {
                                    echo '';
                                }
                            ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" id="country" name="country" value="<?php 
                                if (isset($user) && !empty($user['address'])) {
                                    $address_lines = explode("\n", $user['address']);
                                    echo htmlspecialchars($address_lines[3] ?? '');
                                } else {
                                    echo '';
                                }
                            ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="<?php echo APP_URL; ?>/profile" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
