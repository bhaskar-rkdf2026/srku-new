<?php
$footerAddress = getSetting('footer_address', getSetting('address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026'));
$helpline = getSetting('footer_phone', getSetting('helpline', '0755 - 4911204'));
$email = getSetting('footer_email', getSetting('email', 'exam@srku.edu.in'));
$fbUrl = getSetting('facebook_url', '#');
$instaUrl = getSetting('instagram_url', '#');
$ytUrl = getSetting('youtube_url', '#');
$liUrl = getSetting('linkedin_url', '#');

$footerHeading = getSetting('footer_about_heading', 'Sarvepalli Radhakrishnan University');
$footerAbout = getSetting('footer_about_text', 'SRK University Bhopal is a premier educational ecosystem delivering world-class technical, medical, management, agricultural, and scientific education with state-of-the-art infrastructure and 94% placement record.');
$footerUgc = getSetting('footer_ugc_text', 'Recognized under Section 2(f) of UGC Act 1956');
$footerCopyright = getSetting('footer_copyright_text', '© ' . date('Y') . ' Sarvepalli Radhakrishnan University (SRKU), Bhopal. All Rights Reserved. Dynamic PHP Web Architecture.');
$footerCustomScripts = getSetting('footer_custom_scripts', '');

$enableWhatsapp = getSetting('enable_whatsapp_float', '1');
$whatsappNumber = getSetting('whatsapp_float_number', '917554911204');
$whatsappMsg = getSetting('whatsapp_float_msg', 'Hello SRKU, I am interested in Admission Details.');
$enableEnquiryTab = getSetting('enable_enquiry_tab', '1');
$enquiryTabText = getSetting('enquiry_tab_text', 'Admissions 2026-27');
$enquiryTabLink = getSetting('enquiry_tab_link', '#apply');
$enableBackToTop = getSetting('enable_back_to_top', '1');
?>
<!-- ═══════════════════════════════════════════════════════
     FOOTER SECTION (Bootstrap 5.3 Responsive Grid)
═══════════════════════════════════════════════════════ -->
<footer class="srku-footer pt-5">
    <div class="container-xl pb-4">
        <div class="row g-4">
            
            <!-- Col 1: About -->
            <div class="col-12 col-md-6 col-lg-4 footer-col">
                <h5 class="fw-bold text-white mb-3"><?php echo sanitize($footerHeading); ?></h5>
                <div class="mb-3 text-light-50" style="line-height:1.7;">
                    <?php echo $footerAbout; ?>
                </div>
                <div class="footer-social d-flex gap-2">
                    <a href="<?php echo sanitize($fbUrl); ?>" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo sanitize($instaUrl); ?>" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="<?php echo sanitize($ytUrl); ?>" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="<?php echo sanitize($liUrl); ?>" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="col-12 col-md-6 col-lg-2 footer-col">
                <h5 class="fw-bold text-white mb-3">Quick Links</h5>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                    <li><a href="<?php echo BASE_URL; ?>about.php"><i class="fas fa-angle-right me-1 text-warning"></i> About SRKU</a></li>
                    <li><a href="<?php echo BASE_URL; ?>why-srk.php"><i class="fas fa-angle-right me-1 text-warning"></i> Why Choose SRKU</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php"><i class="fas fa-angle-right me-1 text-warning"></i> Academic Programmes</a></li>
                    <li><a href="<?php echo BASE_URL; ?>page.php?slug=vision-mission"><i class="fas fa-angle-right me-1 text-warning"></i> Vision &amp; Mission</a></li>
                    <li><a href="<?php echo BASE_URL; ?>placements.php"><i class="fas fa-angle-right me-1 text-warning"></i> Placement Records</a></li>
                    <li><a href="<?php echo BASE_URL; ?>facilities.php"><i class="fas fa-angle-right me-1 text-warning"></i> 42+ Labs &amp; Campus</a></li>
                    <li><a href="<?php echo BASE_URL; ?>contact.php"><i class="fas fa-angle-right me-1 text-warning"></i> Admissions 2026-27</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admission-enquiry.php"><i class="fas fa-angle-right me-1 text-warning"></i> Admission Enquiry</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admin/login.php"><i class="fas fa-lock me-1 text-warning"></i> Admin CMS</a></li>
                </ul>
            </div>

            <!-- Col 3: Institutes -->
            <div class="col-12 col-md-6 col-lg-3 footer-col">
                <h5 class="fw-bold text-white mb-3">Institutes &amp; Faculties</h5>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                    <li><a href="<?php echo BASE_URL; ?>rkdf-institute-of-science-technology"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF Institute Of Science &amp; Technology</a></li>
                    <li><a href="<?php echo BASE_URL; ?>sri-sai-college-of-pharmacy"><i class="fas fa-angle-right me-1 text-warning"></i> Sri Sai College Of Pharmacy</a></li>
                    <li><a href="<?php echo BASE_URL; ?>rkdf-institute-science-technology-mca"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF Institute Science &amp; Technology MCA</a></li>
                    <li><a href="<?php echo BASE_URL; ?>rkdf-college-of-nursing"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF College Of Nursing</a></li>
                    <li><a href="<?php echo BASE_URL; ?>rkdf-institute-of-management"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF Institute Of Management</a></li>
                    <li><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-agriculture"><i class="fas fa-angle-right me-1 text-warning"></i> Faculty of Agriculture</a></li>
                    <li><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-law"><i class="fas fa-angle-right me-1 text-warning"></i> Faculty of Law</a></li>
                </ul>
            </div>

            <!-- Col 4: Contact -->
            <div class="col-12 col-md-6 col-lg-3 footer-col">
                <h5 class="fw-bold text-white mb-3">Contact Campus</h5>
                <p class="mb-2 text-light-50"><i class="fas fa-map-marker-alt text-warning me-2"></i><?php echo sanitize($footerAddress); ?></p>
                <p class="mb-2 text-light-50"><i class="fas fa-phone-alt text-warning me-2"></i><?php echo sanitize($helpline); ?></p>
                <p class="mb-3 text-light-50"><i class="fas fa-envelope text-warning me-2"></i><?php echo sanitize($email); ?></p>
                <div class="p-3 rounded bg-dark border border-secondary text-light">
                    <small class="d-block text-warning fw-bold mb-1"><i class="fas fa-certificate me-1"></i> UGC &amp; AICTE Approved</small>
                    <small class="text-white-50"><?php echo sanitize($footerUgc); ?></small>
                </div>
            </div>

        </div>
    </div>

    <!-- Copyright Bar -->
    <div class="footer-bottom py-3">
        <div class="container-xl text-center">
            <p class="mb-0 text-white-50 small"><?php echo sanitize($footerCopyright); ?></p>
        </div>
    </div>
</footer>

<!-- ═══════ FLOATING INTERACTIVE WIDGETS ═══════ -->
<?php if ($enableEnquiryTab === '1'): ?>
    <!-- 1. Floating Quick Admission Enquiry Tab (Right Edge) -->
    <a href="<?php echo (strpos($enquiryTabLink, 'http') === 0 || strpos($enquiryTabLink, '#') === 0) ? $enquiryTabLink : BASE_URL . $enquiryTabLink; ?>" class="floating-enquiry-tab d-none d-md-flex" title="Quick Admission Enquiry">
        <i class="fas fa-paper-plane me-2"></i> <?php echo sanitize($enquiryTabText); ?>
    </a>
<?php endif; ?>

<?php if ($enableWhatsapp === '1'): ?>
    <!-- 2. WhatsApp Direct Helpline Bubble (Bottom Left) -->
    <a href="https://api.whatsapp.com/send?phone=<?php echo preg_replace('/[^0-9]/', '', $whatsappNumber); ?>&text=<?php echo urlencode($whatsappMsg); ?>" target="_blank" class="whatsapp-float-btn" title="Chat on WhatsApp" aria-label="WhatsApp Helpline">
        <i class="fab fa-whatsapp"></i>
    </a>
<?php endif; ?>

<?php if ($enableBackToTop === '1'): ?>
    <!-- 3. Back To Top Rocket Button (Bottom Right) -->
    <a href="#" id="backToTopBtn" class="back-to-top-btn" title="Back to top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </a>
<?php endif; ?>

<!-- Bootstrap 5.3 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
<?php if ($footerCustomScripts): echo $footerCustomScripts; endif; ?>
</body>
</html>
