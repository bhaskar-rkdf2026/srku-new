<?php
$address = getSetting('address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026');
$helpline = getSetting('helpline', '0755 - 4911204');
$email = getSetting('email', 'exam@srku.edu.in');
?>
<!-- ═══════════════════════════════════════════════════════
     FOOTER SECTION (Bootstrap 5.3 Responsive Grid)
═══════════════════════════════════════════════════════ -->
<footer class="srku-footer pt-5">
    <div class="container-xl pb-4">
        <div class="row g-4">
            
            <!-- Col 1: About -->
            <div class="col-12 col-md-6 col-lg-4 footer-col">
                <h5>Sarvepalli Radhakrishnan University</h5>
                <p class="mb-3">
                    SRK University Bhopal is a premier educational ecosystem delivering world-class technical, medical, management, and scientific education with state-of-the-art infrastructure.
                </p>
                <div class="footer-social d-flex gap-2">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="col-12 col-md-6 col-lg-2 footer-col">
                <h5>Quick Links</h5>
                <ul class="list-unstyled mb-0">
                    <li><a href="<?php echo BASE_URL; ?>about.php">About SRKU</a></li>
                    <li><a href="<?php echo BASE_URL; ?>page.php?slug=why-srk">Why Choose SRKU</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php">Academic Programmes</a></li>
                    <li><a href="<?php echo BASE_URL; ?>page.php?slug=vision-mission">Vision &amp; Mission</a></li>
                    <li><a href="<?php echo BASE_URL; ?>contact.php">Admissions 2026-27</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admin/login.php">Admin Panel</a></li>
                </ul>
            </div>

            <!-- Col 3: Institutes -->
            <div class="col-12 col-md-6 col-lg-3 footer-col">
                <h5>Institutes &amp; Faculties</h5>
                <ul class="list-unstyled mb-0">
                    <li><a href="<?php echo BASE_URL; ?>courses.php?dept=Engineering">Department of Engineering</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy">Sri Sai College of Pharmacy</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php?dept=Computer">Faculty of Computer Applications</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php?dept=Nursing">RKDF College of Nursing</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php?dept=Management">Department of Business Management</a></li>
                </ul>
            </div>

            <!-- Col 4: Contact -->
            <div class="col-12 col-md-6 col-lg-3 footer-col">
                <h5>Contact Campus</h5>
                <p class="mb-2"><i class="fas fa-map-marker-alt text-warning me-2"></i><?php echo sanitize($address); ?></p>
                <p class="mb-2"><i class="fas fa-phone-alt text-warning me-2"></i><?php echo sanitize($helpline); ?></p>
                <p class="mb-3"><i class="fas fa-envelope text-warning me-2"></i><?php echo sanitize($email); ?></p>
                <div class="p-3 rounded bg-dark border border-secondary text-light">
                    <small class="d-block text-warning fw-bold mb-1">UGC &amp; AICTE Approved</small>
                    <small class="text-white-50">Recognized under Section 2(f) of UGC Act 1956</small>
                </div>
            </div>

        </div>
    </div>

    <!-- Copyright Bar -->
    <div class="footer-bottom py-3">
        <div class="container-xl text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> Sarvepalli Radhakrishnan University (SRKU), Bhopal. All Rights Reserved. Designed &amp; Maintained on PHP CMS.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap 5.3 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>
