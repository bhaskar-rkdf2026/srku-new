<?php
$footerAddress = getSetting('footer_address', getSetting('address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026'));
$helpline = getSetting('footer_phone', getSetting('helpline', '0755 - 4911204'));
$email = getSetting('footer_email', getSetting('email', 'exam@srku.edu.in'));
$fbUrl = getSetting('facebook_url', '#');
$instaUrl = getSetting('instagram_url', '#');
$ytUrl = getSetting('youtube_url', '#');
$liUrl = getSetting('linkedin_url', '#');

$footerHeading = getSetting('footer_about_heading', 'Sarvepalli Radhakrishnan University');
$footerAbout = getSetting('footer_about_text', 'Sarvepalli Radhakrishnan University (SRKU), Bhopal is established under the MP State Legislature Act and recognized under Section 2(f) of the UGC Act 1956. Delivering benchmark academic excellence across technical, pharmaceutical, medical, management, legal, and agricultural streams with 42+ research laboratories and 750+ bed hospital.');
$footerUgc = getSetting('footer_ugc_text', 'Recognized under Section 2(f) of UGC Act 1956 | AICTE, PCI, INC, BCI & NMC Approved');
$footerCopyright = getSetting('footer_copyright_text', '© ' . date('Y') . ' Sarvepalli Radhakrishnan University (SRKU), Bhopal. All Rights Reserved.');
$footerCustomScripts = getSetting('footer_custom_scripts', '');

$enableWhatsapp = getSetting('enable_whatsapp_float', '1');
$whatsappNumber = getSetting('whatsapp_float_number', '917554911204');
$whatsappMsg = getSetting('whatsapp_float_msg', 'Hello SRKU, I am interested in Admission Details 2026-27.');
$enableBackToTop = getSetting('enable_back_to_top', '1');
?>
<!-- ═══════════════════════════════════════════════════════
     INSTITUTIONAL FOOTER (Clean 4-Column Grid)
═══════════════════════════════════════════════════════ -->
<footer class="srku-footer pt-5">
    <div class="container-xl pb-4">
        <div class="row g-4">
            
            <!-- Col 1: About University -->
            <div class="col-12 col-md-6 col-lg-4 footer-col">
                <h5 class="fw-bold text-white mb-3"><?php echo sanitize($footerHeading); ?></h5>
                <p class="mb-3 text-light-50 small" style="line-height:1.75;">
                    <?php echo sanitize($footerAbout); ?>
                </p>
                <div class="p-3 rounded bg-dark border border-secondary text-light mb-3">
                    <small class="d-block text-warning fw-bold mb-1"><i class="fas fa-shield-alt me-1"></i> Statutory Approvals</small>
                    <small class="text-white-50"><?php echo sanitize($footerUgc); ?></small>
                </div>
                <div class="footer-social d-flex gap-2">
                    <a href="<?php echo sanitize($fbUrl); ?>" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo sanitize($instaUrl); ?>" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="<?php echo sanitize($ytUrl); ?>" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="<?php echo sanitize($liUrl); ?>" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Col 2: Quick Links & Academics -->
            <div class="col-12 col-md-6 col-lg-2 footer-col">
                <h5 class="fw-bold text-white mb-3">Quick Links</h5>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                    <li><a href="<?php echo BASE_URL; ?>about.php"><i class="fas fa-angle-right me-1 text-warning"></i> About SRKU</a></li>
                    <li><a href="<?php echo BASE_URL; ?>page.php?slug=why-srk"><i class="fas fa-angle-right me-1 text-warning"></i> Why Choose SRKU</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php"><i class="fas fa-angle-right me-1 text-warning"></i> Courses Offered</a></li>
                    <li><a href="<?php echo BASE_URL; ?>syllabus.php"><i class="fas fa-angle-right me-1 text-warning"></i> Scheme &amp; Syllabus</a></li>
                    <li><a href="<?php echo BASE_URL; ?>placements.php"><i class="fas fa-angle-right me-1 text-warning"></i> Placement Records</a></li>
                    <li><a href="<?php echo BASE_URL; ?>facilities.php"><i class="fas fa-angle-right me-1 text-warning"></i> Campus Facilities</a></li>
                    <li><a href="<?php echo BASE_URL; ?>contact.php#apply"><i class="fas fa-angle-right me-1 text-warning"></i> Admissions 2026-27</a></li>
                    <li><a href="<?php echo BASE_URL; ?>alumni.php"><i class="fas fa-angle-right me-1 text-warning"></i> Alumni Portal</a></li>
                </ul>
            </div>

            <!-- Col 3: Mandatory Disclosures & Student Welfare -->
            <div class="col-12 col-md-6 col-lg-3 footer-col">
                <h5 class="fw-bold text-white mb-3">Student Welfare &amp; Disclosures</h5>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
<<<<<<< HEAD
                    <li><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/AntiRagging.pdf"><i class="fas fa-shield-alt me-1 text-danger"></i> Anti-Ragging Cell (Toll-Free)</a></li>
                    <li><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Student_Grievance_Committee.pdf"><i class="fas fa-angle-right me-1 text-warning"></i> Grievance Redressal Cell</a></li>
                    <li><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Internal-Complaint-Committee.pdf"><i class="fas fa-angle-right me-1 text-warning"></i> Internal Complaints (ICC)</a></li>
                    <li><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/SC_ST_Grievance_committee.pdf"><i class="fas fa-angle-right me-1 text-warning"></i> SC/ST Grievance Committee</a></li>
                    <li><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/IQAC.pdf"><i class="fas fa-angle-right me-1 text-warning"></i> Internal Quality Assurance (IQAC)</a></li>
                    <li><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/NIRF-2026.pdf"><i class="fas fa-angle-right me-1 text-warning"></i> NIRF 2026 Disclosures</a></li>
                    <li><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Fee-Refund-Policy-2024-25.pdf"><i class="fas fa-angle-right me-1 text-warning"></i> Fee Refund Policy</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admin/login.php"><i class="fas fa-lock me-1 text-warning"></i> Staff / Admin Portal</a></li>
=======
                    <li><a href="<?php echo BASE_URL; ?>rkdf-institute-of-science-technology"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF Institute Of Science &amp; Technology</a></li>
                    <li><a href="<?php echo BASE_URL; ?>sri-sai-college-of-pharmacy"><i class="fas fa-angle-right me-1 text-warning"></i> Sri Sai College Of Pharmacy</a></li>
                    <li><a href="<?php echo BASE_URL; ?>rkdf-institute-science-technology-mca"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF Institute Science &amp; Technology MCA</a></li>
                    <li><a href="<?php echo BASE_URL; ?>rkdf-college-of-nursing"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF College Of Nursing</a></li>
                    <li><a href="<?php echo BASE_URL; ?>rkdf-institute-of-management"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF Institute Of Management</a></li>
                    <li><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-agriculture"><i class="fas fa-angle-right me-1 text-warning"></i> Faculty of Agriculture</a></li>
                    <li><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-law"><i class="fas fa-angle-right me-1 text-warning"></i> Faculty of Law</a></li>
>>>>>>> 81476b8a8671ab310774877cf5ce2986d278eef5
                </ul>
            </div>

            <!-- Col 4: Campus Contact -->
            <div class="col-12 col-md-6 col-lg-3 footer-col">
                <h5 class="fw-bold text-white mb-3">Campus Address</h5>
                <p class="mb-2 text-light-50 small"><i class="fas fa-map-marker-alt text-warning me-2"></i><?php echo sanitize($footerAddress); ?></p>
                <p class="mb-2 text-light-50 small"><i class="fas fa-phone-alt text-warning me-2"></i>Helpline: <?php echo sanitize($helpline); ?></p>
                <p class="mb-3 text-light-50 small"><i class="fas fa-envelope text-warning me-2"></i><?php echo sanitize($email); ?></p>
                
                <div class="bg-navy p-3 rounded border border-secondary text-light">
                    <strong class="text-warning d-block small mb-1"><i class="fas fa-phone-volume me-1"></i> Anti-Ragging Helpline</strong>
                    <span class="small text-white">Toll-Free: <strong>1800-180-5522</strong></span>
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
<?php if ($enableWhatsapp === '1'): ?>
    <!-- WhatsApp Direct Helpline Bubble (Bottom Left) -->
    <a href="https://api.whatsapp.com/send?phone=<?php echo preg_replace('/[^0-9]/', '', $whatsappNumber); ?>&text=<?php echo urlencode($whatsappMsg); ?>" target="_blank" class="whatsapp-float-btn" title="Chat on WhatsApp" aria-label="WhatsApp Helpline">
        <i class="fab fa-whatsapp"></i>
    </a>
<?php endif; ?>

<?php if ($enableBackToTop === '1'): ?>
    <!-- Back To Top Button (Bottom Right) -->
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
