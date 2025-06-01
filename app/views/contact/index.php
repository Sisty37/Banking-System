<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<section class="contact-page">
    <div class="container">
        <div class="section-header">
            <h1>Contact Us</h1>
            <p class="lead">Have questions or need assistance? We're here to help!</p>
        </div>
         
            
            <div class="contact-form-container">
                <h2>Send Us a Message</h2>
                
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <p><?php echo htmlspecialchars($success); ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form action="<?php echo APP_URL; ?>/contact-us/submit" method="POST" class="contact-form">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required value="<?php echo isset($old_input['name']) ? htmlspecialchars($old_input['name']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required value="<?php echo isset($old_input['email']) ? htmlspecialchars($old_input['email']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number (Optional)</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo isset($old_input['phone']) ? htmlspecialchars($old_input['phone']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a Subject</option>
                            <option value="General Inquiry" <?php echo (isset($old_input['subject']) && $old_input['subject'] === 'General Inquiry') ? 'selected' : ''; ?>>General Inquiry</option>
                            <option value="Account Support" <?php echo (isset($old_input['subject']) && $old_input['subject'] === 'Account Support') ? 'selected' : ''; ?>>Account Support</option>
                            <option value="Technical Issue" <?php echo (isset($old_input['subject']) && $old_input['subject'] === 'Technical Issue') ? 'selected' : ''; ?>>Technical Issue</option>
                            <option value="Billing Question" <?php echo (isset($old_input['subject']) && $old_input['subject'] === 'Billing Question') ? 'selected' : ''; ?>>Billing Question</option>
                            <option value="Feature Request" <?php echo (isset($old_input['subject']) && $old_input['subject'] === 'Feature Request') ? 'selected' : ''; ?>>Feature Request</option>
                            <option value="Other" <?php echo (isset($old_input['subject']) && $old_input['subject'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" required><?php echo isset($old_input['message']) ? htmlspecialchars($old_input['message']) : ''; ?></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Submit Message</button>
                    </div>
                </form>
            </div>
        </div>
        

<script> 
        // Form validation
        const contactForm = document.querySelector('.contact-form');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                let isValid = true;
                
                const emailInput = document.getElementById('email');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (!emailPattern.test(emailInput.value)) {
                    alert('Please enter a valid email address.');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
        }
    });
</script>

 