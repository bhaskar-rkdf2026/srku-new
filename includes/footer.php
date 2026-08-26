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
$footerCopyright = getSetting('footer_copyright_text', '© ' . date('Y') . ' Sarvepalli Radhakrishnan University (SRKU), Bhopal. All Rights Reserved.');
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
            
            <!-- Col 1: About & University Logo -->
            <div class="col-12 col-md-6 col-lg-3 footer-col">
                <div class="footer-brand mb-3">
                    <a href="<?php echo BASE_URL; ?>" class="d-inline-block bg-white p-2 px-3 rounded-3 shadow-sm" title="Sarvepalli Radhakrishnan University, Bhopal">
                        <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-logo.webp" 
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/images/Dyno-Logo-1.png';" 
                             alt="Sarvepalli Radhakrishnan University, Bhopal" 
                             class="img-fluid" 
                             style="max-height: 46px; width: auto; display: block;">
                    </a>
                </div>
                <h5 class="fw-bold text-white mb-2" style="font-size: 1.05rem;"><?php echo sanitize($footerHeading); ?></h5>
                <div class="mb-3 text-light-50" style="line-height:1.65; font-size: 0.88rem;">
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
                    <li><a href="<?php echo BASE_URL; ?>chancellor-message.php"><i class="fas fa-angle-right me-1 text-warning"></i> Chancellor's Message</a></li>
                    <li><a href="<?php echo BASE_URL; ?>vice-chancellor-message.php"><i class="fas fa-angle-right me-1 text-warning"></i> VC's Message</a></li>
                    <li><a href="<?php echo BASE_URL; ?>academic-calendar.php"><i class="fas fa-angle-right me-1 text-warning"></i> Academic Calendar</a></li>
                    <li><a href="<?php echo BASE_URL; ?>exam-rules.php"><i class="fas fa-angle-right me-1 text-warning"></i> Examination Rules</a></li>
                    <li><a href="<?php echo BASE_URL; ?>hostel.php"><i class="fas fa-angle-right me-1 text-warning"></i> Hostel Accommodation</a></li>
                    <li><a href="<?php echo BASE_URL; ?>about.php"><i class="fas fa-angle-right me-1 text-warning"></i> About SRKU</a></li>
                    <li><a href="<?php echo BASE_URL; ?>why-srk.php"><i class="fas fa-angle-right me-1 text-warning"></i> Why Choose SRKU</a></li>
                    <li><a href="<?php echo BASE_URL; ?>courses.php"><i class="fas fa-angle-right me-1 text-warning"></i> Academic Programmes</a></li>
                    <li><a href="<?php echo BASE_URL; ?>placements.php"><i class="fas fa-angle-right me-1 text-warning"></i> Placement Records</a></li>
                    <li><a href="<?php echo BASE_URL; ?>gallery.php"><i class="fas fa-camera-retro me-1 text-warning"></i> Campus Photo Gallery</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admission-enquiry.php"><i class="fas fa-angle-right me-1 text-warning"></i> Admission Enquiry</a></li>
                    <li><a href="<?php echo BASE_URL; ?>grievance.php"><i class="fas fa-angle-right me-1 text-warning"></i> Grievance / Complaint</a></li>
                </ul>
            </div>

            <!-- Col 3: Constituent Units (Top 10) -->
            <div class="col-12 col-md-6 col-lg-2 footer-col">
                <h5 class="fw-bold text-white mb-3">Constituent Units</h5>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                    <li><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-science-technology"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF IST (Engineering)</a></li>
                    <li><a href="https://rkdfmedicalcollege.org/" target="_blank"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF Medical College</a></li>
                    <li><a href="http://www.srkcahrc.in/" target="_blank"><i class="fas fa-angle-right me-1 text-warning"></i> SRK College of Ayurveda</a></li>
                    <li><a href="http://www.rkdfhmc.in/" target="_blank"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF Homoeopathic Medical</a></li>
                    <li><a href="http://rkdfdentalcollege.in/" target="_blank"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF Dental College</a></li>
                    <li><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-college-of-pharmacy"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF College of Pharmacy</a></li>
                    <li><a href="<?php echo BASE_URL; ?>department-detail.php?slug=sri-sai-college-of-pharmacy"><i class="fas fa-angle-right me-1 text-warning"></i> Sri Sai Pharmacy College</a></li>
                    <li><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-college-of-nursing"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF College of Nursing</a></li>
                    <li><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-management"><i class="fas fa-angle-right me-1 text-warning"></i> RKDF Institute of Mgmt.</a></li>
                    <li><a href="<?php echo BASE_URL; ?>department-detail.php?slug=sarvepalli-radhakrishnan-college-of-law"><i class="fas fa-angle-right me-1 text-warning"></i> SRK College of Law</a></li>
                    <li><a href="<?php echo BASE_URL; ?>constituent-unit.php" class="text-warning fw-bold"><i class="fas fa-arrow-circle-right me-1"></i> View All 24+ Units &rarr;</a></li>
                </ul>
            </div>

            <!-- Col 4: CONTACT INFO -->
            <div class="col-12 col-md-6 col-lg-2 footer-col">
                <h5 class="fw-bold text-white mb-3">CONTACT INFO</h5>
                <div class="footer-contact-block text-light-50 small" style="line-height: 1.75; font-size: 0.86rem;">
                    <div>NH-12, Hoshangabad Road,</div>
                    <div>Jatkhedi, Misrod,</div>
                    <div>Bhopal,</div>
                    <div class="mb-2">Madhya Pradesh 462026</div>
                    <div class="mb-1"><a href="tel:07554700983" class="text-light-50 text-decoration-none d-inline-block hover-gold">07554700983</a></div>
                    <div class="mb-1"><a href="tel:07557024144981" class="text-light-50 text-decoration-none d-inline-block hover-gold">0755 7024144981,83,84,85,86</a></div>
                    <div><a href="mailto:info@srku.edu.in" class="text-warning text-decoration-none d-inline-block hover-gold">info@srku.edu.in</a></div>
                </div>
            </div>

            <!-- Col 5: IMPORTANT NO. & MAIL ID -->
            <div class="col-12 col-md-6 col-lg-3 footer-col">
                <h5 class="fw-bold text-white mb-3">IMPORTANT NO.</h5>
                <div class="footer-contact-block text-light-50 small" style="line-height: 1.75; font-size: 0.86rem;">
                    <div class="mb-1">EXAM help line <a href="tel:07554911204" class="text-light-50 text-decoration-none hover-gold fw-semibold">07554911204</a></div>
                    <div class="mb-1">ACADEMIC help line <a href="tel:07554700982" class="text-light-50 text-decoration-none hover-gold fw-semibold">0755-4700982</a></div>
                    <div class="mb-3">ADMISSION help line no <a href="tel:7024144981" class="text-light-50 text-decoration-none hover-gold fw-semibold">7024144981</a></div>
                    
                    <h6 class="text-white fw-bold mb-2 text-uppercase" style="font-size: 0.88rem; letter-spacing: 0.5px;">IMPORTANT MAIL ID.</h6>
                    <div class="mb-1">For Document Verification <a href="mailto:exam@srku.edu.in" class="text-warning text-decoration-none hover-gold">exam@srku.edu.in</a></div>
                    <div class="mb-1">Registrar Office <a href="mailto:registrar@srku.edu.in" class="text-warning text-decoration-none hover-gold">registrar@srku.edu.in</a></div>
                    <div>VC Office <a href="mailto:vc@srku.edu.in" class="text-warning text-decoration-none hover-gold">vc@srku.edu.in</a></div>
                </div>
            </div>

        </div>
    </div>

    <!-- Copyright Bar -->
    <div class="footer-bottom py-3">
        <div class="container-xl">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 text-center text-md-start">
                <p class="mb-0 text-white-50 small">
                    <?php echo sanitize($footerCopyright); ?>
                </p>
                <p class="mb-0 text-white-50 small">
                    Designed &amp; Developed by <a href="https://wecrescent.com/" target="_blank" rel="noopener noreferrer" class="text-warning text-decoration-none fw-semibold">Crescent Digital Solutions</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- ═══════ FLOATING INTERACTIVE WIDGETS ═══════ -->
<!-- Modern Slide-Out Quick Action Side Bar (Right Edge) -->
<div class="srku-side-actions" role="region" aria-label="Quick Actions">
    <!-- 1. Admission / Apply Online -->
    <button type="button" class="side-action-tab tab-admission" data-bs-toggle="modal" data-bs-target="#quickAdmissionModal" title="Online Admission Form 2026-27" aria-label="Admissions 2026">
        <span class="tab-icon"><i class="fas fa-file-signature"></i></span>
        <span class="tab-label">Admissions 2026</span>
    </button>
    
    <!-- 2. Grievance Redressal -->
    <button type="button" class="side-action-tab tab-grievance" data-bs-toggle="modal" data-bs-target="#quickGrievanceModal" title="Student Grievance &amp; Complaint Cell" aria-label="Grievance Cell">
        <span class="tab-icon"><i class="fas fa-balance-scale"></i></span>
        <span class="tab-label">Grievance Cell</span>
    </button>

    <!-- 3. Direct Phone Helpline Call -->
    <a href="tel:7024144981" class="side-action-tab tab-call" title="Call Direct Helpline: 7024144981" aria-label="Helpline Call">
        <span class="tab-icon"><i class="fas fa-phone-alt"></i></span>
        <span class="tab-label">7024144981</span>
    </a>

    <!-- 4. Contact Us Desk -->
    <a href="<?php echo BASE_URL; ?>contact.php" class="side-action-tab tab-contact" title="Campus Contact &amp; Enquiry Desk" aria-label="Contact Desk">
        <span class="tab-icon"><i class="fas fa-envelope-open-text"></i></span>
        <span class="tab-label">Enquiry Desk</span>
    </a>
</div>

<?php if ($enableWhatsapp === '1'): ?>
    <!-- WhatsApp Direct Helpline Bubble (Bottom Left) -->
    <a href="https://api.whatsapp.com/send?phone=<?php echo preg_replace('/[^0-9]/', '', $whatsappNumber); ?>&text=<?php echo urlencode($whatsappMsg); ?>" target="_blank" class="whatsapp-float-btn" title="Chat on WhatsApp" aria-label="WhatsApp Helpline">
        <i class="fab fa-whatsapp"></i>
    </a>
<?php endif; ?>

<?php if ($enableBackToTop === '1'): ?>
    <!-- Back To Top Rocket Button (Bottom Right) -->
    <a href="#" id="backToTopBtn" class="back-to-top-btn" title="Back to top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </a>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════
     MODAL 1: QUICK ADMISSION POPUP
═══════════════════════════════════════════════════════ -->
<div class="modal fade" id="quickAdmissionModal" tabindex="-1" aria-labelledby="quickAdmissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header bg-maroon text-white p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center p-2" style="width:46px; height:46px;">
                        <i class="fas fa-file-signature fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="quickAdmissionModalLabel">Online Admission Enquiry 2026-27</h5>
                        <small class="text-white-50">Sarvepalli Radhakrishnan University, Bhopal</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4 p-md-5 bg-light">
                <div id="admissionAlertBox" style="display:none;"></div>

                <form id="quickAdmissionForm" method="POST">
                    <input type="hidden" name="action" value="submit_admission">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Full Name *</label>
                            <input type="text" name="name" class="form-control py-2" placeholder="Candidate's full name" required minlength="2">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Father's Name</label>
                            <input type="text" name="father_name" class="form-control py-2" placeholder="Father's / Guardian's name">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">WhatsApp Mobile *</label>
                            <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit mobile number" pattern="[0-9]{10}" maxlength="10" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Email Address *</label>
                            <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small mb-1">Course of Interest *</label>
                        <select name="course" class="form-select py-2" required>
                            <option value="">-- Select Course (90+ Programs) --</option>
                            <?php 
                            $footerCourses = function_exists('getCourses') ? getCourses() : [];
                            if (!empty($footerCourses)):
                                $fLevels = ['UG' => 'Undergraduate (UG)', 'PG' => 'Postgraduate (PG)', 'Diploma' => 'Diploma & Certificate', 'Doctorate' => 'Ph.D. & Research'];
                                foreach ($fLevels as $flKey => $flLabel):
                                    $fFilt = array_filter($footerCourses, fn($c) => stripos($c['level'], $flKey) !== false || stripos($c['degree_level'], $flKey) !== false);
                                    if (!empty($fFilt)):
                            ?>
                                        <optgroup label="<?php echo $flLabel; ?>">
                                            <?php foreach ($fFilt as $fc): ?>
                                                <option value="<?php echo sanitize($fc['course_name']); ?>"><?php echo sanitize($fc['course_name']); ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                            <?php 
                                    endif;
                                endforeach;
                            else:
                            ?>
                                <option>B.Tech Computer Science &amp; Engineering</option>
                                <option>Bachelor of Pharmacy (B.Pharm)</option>
                                <option>MBA — Master of Business Administration</option>
                                <option>B.Sc. Nursing</option>
                                <option>B.Sc. (Hons) Agriculture</option>
                                <option>BPT — Bachelor of Physiotherapy</option>
                                <option>LL.B — Bachelor of Laws</option>
                            <?php endif; ?>
                            <option value="Other Programme">Other University Programme</option>
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">City</label>
                            <input type="text" name="city" class="form-control py-2" placeholder="e.g. Bhopal, Indore">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">State</label>
                            <input type="text" name="state" class="form-control py-2" placeholder="e.g. Madhya Pradesh">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-1">Any Query / Note (Optional)</label>
                        <textarea name="message" class="form-control py-2" rows="2" placeholder="Ask about fees, hostel, scholarships, or counseling..."></textarea>
                    </div>

                    <button type="submit" id="btnSubmitAdmission" class="btn btn-srku w-100 py-3 fw-bold text-white shadow d-flex align-items-center justify-content-center gap-2" style="font-size:1rem;">
                        <i class="fas fa-paper-plane"></i> <span>Submit Admission Enquiry</span>
                    </button>
                </form>
            </div>
            
            <div class="modal-footer bg-white p-3 d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="fas fa-phone-alt text-danger me-1"></i> Helpline: 0755-4700983, 7024144981</small>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     MODAL 2: QUICK GRIEVANCE REDRESSAL POPUP
═══════════════════════════════════════════════════════ -->
<div class="modal fade" id="quickGrievanceModal" tabindex="-1" aria-labelledby="quickGrievanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header bg-navy text-white p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center p-2" style="width:46px; height:46px;">
                        <i class="fas fa-balance-scale fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="quickGrievanceModalLabel">Student Grievance &amp; Complaint Redressal</h5>
                        <small class="text-white-50">Confidential Redressal Cell &bull; SRK University</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4 p-md-5 bg-light">
                <div id="grievanceAlertBox" style="display:none;"></div>

                <form id="quickGrievanceForm" method="POST">
                    <input type="hidden" name="action" value="submit_grievance">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Your Full Name *</label>
                            <input type="text" name="name" class="form-control py-2" placeholder="Enter student full name" required minlength="2">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Father's Name</label>
                            <input type="text" name="father_name" class="form-control py-2" placeholder="Father's name">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Enrollment Number</label>
                            <input type="text" name="enrollment_number" class="form-control py-2" placeholder="e.g. SRKU2024CS101">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Mobile Number *</label>
                            <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit mobile number" pattern="[0-9]{10}" maxlength="10" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Email ID *</label>
                            <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Institute / College Name</label>
                            <input type="text" name="institute_name" class="form-control py-2" placeholder="e.g. RKDF IST / College of Pharmacy">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Course &amp; Semester</label>
                            <input type="text" name="course_name" class="form-control py-2" placeholder="e.g. B.Tech CSE (4th Sem)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Type of Grievance *</label>
                            <select name="complaint_type" class="form-select py-2" required>
                                <option value="">-- Select Grievance Category --</option>
                                <option value="Academic">Academic &amp; Class Queries</option>
                                <option value="Examination">Examination &amp; Results</option>
                                <option value="Administrative">Administrative &amp; Office</option>
                                <option value="Hostel & Accommodation">Hostel &amp; Mess Accommodation</option>
                                <option value="Fee & Finance">Fee &amp; Accounts</option>
                                <option value="Faculty / Staff Behaviour">Faculty / Staff Support</option>
                                <option value="Infrastructure & Facilities">Infrastructure &amp; Labs</option>
                                <option value="Anti-Ragging">Anti-Ragging / Security</option>
                                <option value="Other">Other Issues</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-1">Detailed Description of Grievance *</label>
                        <textarea name="complaint_details" class="form-control py-2" rows="4" placeholder="Please describe the issue with relevant context..." minlength="10" required></textarea>
                    </div>

                    <button type="submit" id="btnSubmitGrievance" class="btn btn-dark w-100 py-3 fw-bold text-white shadow d-flex align-items-center justify-content-center gap-2" style="background:#0f172a; border-color:#0f172a; font-size:1rem;">
                        <i class="fas fa-shield-alt"></i> <span>Submit Grievance Securely</span>
                    </button>
                </form>
            </div>
            
            <div class="modal-footer bg-white p-3 d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="fas fa-lock text-success me-1"></i> Strictly confidential redressal as per UGC norms.</small>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>

<!-- AJAX Form Handlers for Instant Sticky Popups -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Admission Form AJAX
    const admForm = document.getElementById('quickAdmissionForm');
    if (admForm) {
        admForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmitAdmission');
            const alertBox = document.getElementById('admissionAlertBox');
            const origHtml = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Submitting...';
            alertBox.style.display = 'none';

            const formData = new FormData(admForm);
            fetch('<?php echo BASE_URL; ?>api-submit-lead.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = origHtml;
                alertBox.style.display = 'block';
                if (data.success) {
                    alertBox.className = 'alert alert-success d-flex align-items-center gap-2 mb-3';
                    alertBox.innerHTML = '<i class="fas fa-check-circle fa-lg"></i> <div>' + data.message + '</div>';
                    admForm.reset();
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('quickAdmissionModal'));
                        if (modal) modal.hide();
                        alertBox.style.display = 'none';
                    }, 3500);
                } else {
                    alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                    alertBox.innerHTML = '<i class="fas fa-exclamation-circle fa-lg"></i> <div>' + (data.error || 'Submission failed. Please check details.') + '</div>';
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = origHtml;
                alertBox.style.display = 'block';
                alertBox.className = 'alert alert-danger mb-3';
                alertBox.innerText = 'Network error. Please try again or call our admission desk.';
            });
        });
    }

    // 2. Grievance Form AJAX
    const grvForm = document.getElementById('quickGrievanceForm');
    if (grvForm) {
        grvForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmitGrievance');
            const alertBox = document.getElementById('grievanceAlertBox');
            const origHtml = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Registering...';
            alertBox.style.display = 'none';

            const formData = new FormData(grvForm);
            fetch('<?php echo BASE_URL; ?>api-submit-lead.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = origHtml;
                alertBox.style.display = 'block';
                if (data.success) {
                    alertBox.className = 'alert alert-success d-flex align-items-center gap-2 mb-3';
                    alertBox.innerHTML = '<i class="fas fa-check-circle fa-lg"></i> <div>' + data.message + '</div>';
                    grvForm.reset();
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('quickGrievanceModal'));
                        if (modal) modal.hide();
                        alertBox.style.display = 'none';
                    }, 3500);
                } else {
                    alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                    alertBox.innerHTML = '<i class="fas fa-exclamation-circle fa-lg"></i> <div>' + (data.error || 'Registration failed. Please check details.') + '</div>';
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = origHtml;
                alertBox.style.display = 'block';
                alertBox.className = 'alert alert-danger mb-3';
                alertBox.innerText = 'Network error. Please try again or contact university office.';
            });
        });
    }
});
</script>

<?php if ($footerCustomScripts): echo $footerCustomScripts; endif; ?>
</body>
</html>
