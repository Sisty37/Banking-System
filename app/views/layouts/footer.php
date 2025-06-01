    </div> <!-- End of main-content -->
    
    <?php
    // Check if current page is admin area
    $isAdminPage = strpos($_SERVER['REQUEST_URI'], '/admin') !== false;
    $isLoggedIn = isset($_SESSION['user_id']);
    
    // Only show footer on public pages (not admin area and not logged in)
    if (!$isAdminPage && !$isLoggedIn): 
    ?>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section about">
                    <h3 class="footer-title">Banking System V3</h3>
                    <p>A modern, secure, and user-friendly banking platform designed to make your financial journey seamless and efficient.</p>
                    <div class="contact">
                        <p><i class="fas fa-map-marker-alt"></i> 123 Banking Street, Finance City</p>
                        <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                        <p><i class="fas fa-envelope"></i> info@bankingsystemv3.com</p>
                    </div>
                    <div class="socials">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="footer-section links">
                    <h3 class="footer-title">Quick Links</h3>
                    <ul>
                        <li><a href="<?php echo APP_URL; ?>">Home</a></li>
                        <li><a href="<?php echo APP_URL; ?>/about-us">About Us</a></li>
                        <li><a href="<?php echo APP_URL; ?>/services">Services</a></li>
                        <li><a href="<?php echo APP_URL; ?>/contact-us">Contact</a></li>
                        <li><a href="<?php echo APP_URL; ?>/faqs">FAQs</a></li>
                    </ul>
                </div>
                
                <div class="footer-section services">
                    <h3 class="footer-title">Services</h3>
                    <ul>
                        <li><a href="<?php echo APP_URL; ?>/services#savings">Savings Accounts</a></li>
                        <li><a href="<?php echo APP_URL; ?>/services#checking">Checking Accounts</a></li>
                        <li><a href="<?php echo APP_URL; ?>/services#loans">Loans</a></li>
                        <li><a href="<?php echo APP_URL; ?>/services#investments">Investments</a></li>
                        <li><a href="<?php echo APP_URL; ?>/services#credit-cards">Credit Cards</a></li>
                    </ul>
                </div>
                
                <div class="footer-section newsletter">
                    <h3 class="footer-title">Newsletter</h3>
                    <p>Subscribe to our newsletter for updates on our services, financial tips, and special offers.</p>
                    <form action="<?php echo APP_URL; ?>/subscribe" method="post">
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <button type="submit" class="btn btn-primary btn-sm">Subscribe</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Banking System V3. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="<?php echo APP_URL; ?>/privacy-policy">Privacy Policy</a>
                    <a href="<?php echo APP_URL; ?>/terms-of-service">Terms of Service</a>
                    <a href="<?php echo APP_URL; ?>/cookie-policy">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>
    <?php endif; ?>
    
    <?php if ($isLoggedIn && !$isAdminPage): ?>
    <!-- User dashboard footer -->
    <footer class="dashboard-footer">
        <div class="container">
            <div class="footer-content">
                <p>&copy; <?php echo date('Y'); ?> Banking System V3. All rights reserved.</p>
                <div class="footer-links">
                    <a href="<?php echo APP_URL; ?>/privacy-policy">Privacy</a>
                    <a href="<?php echo APP_URL; ?>/terms-of-service">Terms</a>
                    <a href="<?php echo APP_URL; ?>/help">Help</a>
                </div>
            </div>
        </div>
    </footer>
    <?php endif; ?>
    
    <!-- Load necessary scripts -->
    <?php if (strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false): ?>
    <script src="<?php echo APP_URL; ?>/public/js/dashboard.js"></script>
    <?php endif; ?>
    
    <script src="<?php echo APP_URL; ?>/public/js/jquery.min.js"></script>
    <script src="<?php echo APP_URL; ?>/public/js/main.js"></script>
    
    <?php if ($isLoggedIn && !$isAdminPage): ?>
    <script>
        // Dashboard sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.dashboard-sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    document.body.classList.toggle('sidebar-open');
                });
                
                // Close sidebar when clicking outside
                document.addEventListener('click', function(event) {
                    if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target) && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        document.body.classList.remove('sidebar-open');
                    }
                });
            }
            
            // Handle responsive behavior
            function handleResize() {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                }
            }
            
            window.addEventListener('resize', handleResize);
        });
    </script>
    <?php endif; ?>
</body>
</html>

