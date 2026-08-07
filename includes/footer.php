<?php
$address = getSetting('address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026');
$helpline = getSetting('helpline', '0755 - 4911204');
$email = getSetting('email', 'exam@srku.edu.in');
?>
    <!-- FOOTER -->
    <footer class="main-footer">
        <div class="footer-container">
            <div class="footer-col">
                <h4>Sarvepalli Radhakrishnan University</h4>
                <p style="font-size: 0.9rem; line-height: 1.7; margin-bottom: 20px; color: #94a3b8;">
                    SRK University Bhopal is a premier educational ecosystem delivering world-class technical, medical, management, and scientific education with state-of-the-art infrastructure.
                </p>
                <div style="display: flex; gap: 12px; font-size: 1.2rem; color: var(--accent-gold);">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>about.php">About SRKU</a></li>
                    <li><a href="<?php echo BASE_URL; ?>page.php?slug=why-srk">Why Choose SRKU</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php">Academic Programmes</a></li>
                    <li><a href="<?php echo BASE_URL; ?>page.php?slug=vision-mission">Vision & Mission</a></li>
                    <li><a href="<?php echo BASE_URL; ?>contact.php">Admissions 2026-27</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admin/login.php">Admin Panel</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Institutes & Faculties</h4>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>courses.php?dept=Engineering">Department of Engineering</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy">Sri Sai College of Pharmacy</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php?dept=Computer">Faculty of Computer Applications</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php?dept=Nursing">RKDF College of Nursing</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php?dept=Management">Department of Business Management</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Contact Campus</h4>
                <p style="font-size: 0.9rem; margin-bottom: 12px;"><i class="fas fa-map-marker-alt" style="color: var(--accent-gold); margin-right: 8px;"></i> <?php echo sanitize($address); ?></p>
                <p style="font-size: 0.9rem; margin-bottom: 12px;"><i class="fas fa-phone-alt" style="color: var(--accent-gold); margin-right: 8px;"></i> <?php echo sanitize($helpline); ?></p>
                <p style="font-size: 0.9rem; margin-bottom: 20px;"><i class="fas fa-envelope" style="color: var(--accent-gold); margin-right: 8px;"></i> <?php echo sanitize($email); ?></p>
                <div style="background: rgba(255,255,255,0.05); padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                    <small style="color: #cbd5e1; display: block; margin-bottom: 4px; font-weight: 600;">UGC & AICTE Approved</small>
                    <small style="color: #94a3b8;">Recognized under Section 2(f) of UGC Act 1956</small>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> Sarvepalli Radhakrishnan University (SRKU), Bhopal. All Rights Reserved. Designed & Maintained on PHP CMS.</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>
