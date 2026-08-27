<?php
$pageTitle = "Examination Rules & Guidelines | Evaluation, Grading & Ordinances | SRKU Bhopal";
$pageDesc = "Official examination rules, evaluation scheme, 75% mandatory attendance threshold, 10-point CGPA grading scale, ATKT ordinances and revaluation policy of SRKU Bhopal.";
$pageKeywords = "SRKU Exam Rules, Examination Ordinances Bhopal, 10 Point Grading Scale, ATKT Rules SRKU, Attendance Rules 75%";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════
     HERO — AURORA MESH
═══════════════════════════════════════════════════════ -->
<section class="about-hero-v2">
    <div class="about-hero-v2__blob about-hero-v2__blob--1"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--2"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--3"></div>
    <div class="about-hero-v2__grid"></div>

    <div class="container-xl about-hero-v2__inner">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-warning"><i class="fas fa-home me-1"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>courses.php" class="text-decoration-none text-white-50">Academics</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgba(255,255,255,0.85);">Examination Rules</li>
                    </ol>
                </nav>
                <span class="about-hero-v2__eyebrow"><i class="fas fa-clipboard-check"></i> Academic Ordinances &amp; Regulations</span>
                <h1 class="about-hero-v2__title">Examination Rules &amp; <span>Evaluation Guidelines</span></h1>
                <p class="about-hero-v2__desc">
                    Comprehensive academic ordinances governing internal assessments, final examinations, attendance prerequisites, 10-point CBCS grading system, ATKT rules, and grievance redressal.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/statutes-ordinances-pertaining-to-academics-examination.pdf" target="_blank" class="btn-hero-yellow">
                        <i class="fas fa-file-pdf me-1"></i> Download Examination Statutes (PDF)
                    </a>
                    <a href="<?php echo BASE_URL; ?>academic-calendar.php" class="btn-hero-outline">
                        <i class="fas fa-calendar-alt me-1"></i> Academic Calendar
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-hero-v2__cards">
                    <div class="about-hero-v2__card about-hero-v2__card--float1">
                        <i class="fas fa-percentage"></i>
                        <span class="num">75%</span>
                        <span class="lbl">Min. Attendance</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float2">
                        <i class="fas fa-star-half-alt"></i>
                        <span class="num">10-Point</span>
                        <span class="lbl">CBCS Grade Scale</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float3">
                        <i class="fas fa-check-double"></i>
                        <span class="num">CIA + ESE</span>
                        <span class="lbl">Dual Evaluation</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float4">
                        <i class="fas fa-shield-alt"></i>
                        <span class="num">100%</span>
                        <span class="lbl">UGC Compliant</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Examination Rules Content -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        
        <!-- 1. Mandatory Attendance Ordinance -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="p-3 rounded-circle bg-danger-subtle text-danger" style="font-size: 1.3rem;">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div>
                    <span class="badge bg-danger text-white px-3 py-1 rounded-pill small fw-bold">Statutory Rule #1</span>
                    <h4 class="fw-bold text-navy mb-0 mt-1">75% Mandatory Attendance Rule</h4>
                </div>
            </div>
            <p class="text-secondary" style="line-height: 1.8;">
                In accordance with UGC regulations and statutory council directives (AICTE, NMC, PCI, BCI, INC), a student must have registered a <strong>minimum aggregate attendance of 75%</strong> in all lectures, tutorials, and practical laboratory sessions conducted during the semester to be eligible to appear for the End Semester University Examinations.
            </p>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="p-3 rounded-3 bg-light border">
                        <h6 class="fw-bold text-navy mb-1"><i class="fas fa-notes-medical text-danger me-2"></i> Medical Condonation</h6>
                        <p class="text-muted small mb-0">Condonation of up to 10% attendance may be granted by the Vice Chancellor on valid medical grounds, provided authentic registered medical certificates are submitted within 7 days of illness.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="p-3 rounded-3 bg-light border">
                        <h6 class="fw-bold text-navy mb-1"><i class="fas fa-running text-success me-2"></i> Sports &amp; Cultural Deputation</h6>
                        <p class="text-muted small mb-0">Attendance concession up to 10% is granted to students officially deputed to represent the university in AIU, state, or national championships and academic conferences.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Choice Based Credit System (CBCS) & 10-Point Grading Scale -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="p-3 rounded-circle bg-primary-subtle text-primary" style="font-size: 1.3rem;">
                    <i class="fas fa-calculator"></i>
                </div>
                <div>
                    <span class="badge bg-primary text-white px-3 py-1 rounded-pill small fw-bold">Statutory Rule #2</span>
                    <h4 class="fw-bold text-navy mb-0 mt-1">10-Point CBCS Grading System &amp; SGPA/CGPA Calculation</h4>
                </div>
            </div>
            <p class="text-secondary" style="line-height: 1.8;">
                The university follows the UGC standardized 10-Point Letter Grading System. Performance in each course is evaluated on continuous internal assessments (CIA: 30% / 40%) and end semester examinations (ESE: 70% / 60%).
            </p>
            
            <div class="table-responsive my-3">
                <table class="table table-bordered table-hover text-center align-middle small mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Academic Percentage</th>
                            <th>Letter Grade</th>
                            <th>Grade Point (GP)</th>
                            <th>Qualitative Performance Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-success">
                            <td>90% and above</td>
                            <td class="fw-bold text-success">O</td>
                            <td class="fw-bold">10</td>
                            <td>Outstanding (Exceptional Mastery)</td>
                        </tr>
                        <tr>
                            <td>80% to 89%</td>
                            <td class="fw-bold text-primary">A+</td>
                            <td class="fw-bold">9</td>
                            <td>Excellent</td>
                        </tr>
                        <tr>
                            <td>70% to 79%</td>
                            <td class="fw-bold text-primary">A</td>
                            <td class="fw-bold">8</td>
                            <td>Very Good</td>
                        </tr>
                        <tr>
                            <td>60% to 69%</td>
                            <td class="fw-bold text-info">B+</td>
                            <td class="fw-bold">7</td>
                            <td>Good</td>
                        </tr>
                        <tr>
                            <td>55% to 59%</td>
                            <td class="fw-bold text-info">B</td>
                            <td class="fw-bold">6</td>
                            <td>Above Average</td>
                        </tr>
                        <tr>
                            <td>50% to 54%</td>
                            <td class="fw-bold text-warning">C</td>
                            <td class="fw-bold">5</td>
                            <td>Average</td>
                        </tr>
                        <tr>
                            <td>40% to 49% (Pass marks vary by council)</td>
                            <td class="fw-bold text-secondary">P</td>
                            <td class="fw-bold">4</td>
                            <td>Pass</td>
                        </tr>
                        <tr class="table-danger">
                            <td>Below 40%</td>
                            <td class="fw-bold text-danger">F</td>
                            <td class="fw-bold text-danger">0</td>
                            <td>Fail / Re-appear</td>
                        </tr>
                        <tr class="table-secondary">
                            <td>Absent in Examination</td>
                            <td class="fw-bold text-danger">Ab</td>
                            <td class="fw-bold">0</td>
                            <td>Absent</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12 col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <span class="fw-bold text-navy d-block mb-1">Semester Grade Point Average (SGPA)</span>
                        <code class="text-dark bg-white p-2 rounded d-block border mb-1">SGPA = &sum;(Credit &times; Grade Point) / &sum;(Total Credits of Semester)</code>
                        <small class="text-muted">Measures performance across registered credits in an individual semester.</small>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <span class="fw-bold text-navy d-block mb-1">Cumulative Grade Point Average (CGPA)</span>
                        <code class="text-dark bg-white p-2 rounded d-block border mb-1">CGPA = &sum;(All Semester Credits &times; SGPA) / &sum;(Total Program Credits)</code>
                        <small class="text-muted">Represents cumulative academic standing across all semesters completed.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. ATKT (Allowed to Keep Term) & Promotion Criteria -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="p-3 rounded-circle bg-warning-subtle text-warning" style="font-size: 1.3rem;">
                    <i class="fas fa-forward"></i>
                </div>
                <div>
                    <span class="badge bg-warning text-dark px-3 py-1 rounded-pill small fw-bold">Statutory Rule #3</span>
                    <h4 class="fw-bold text-navy mb-0 mt-1">ATKT (Allowed to Keep Term) &amp; Promotion Rules</h4>
                </div>
            </div>
            <ul class="text-secondary d-flex flex-column gap-2 mb-0" style="line-height: 1.8;">
                <li>A student who fails in up to specified maximum theory/practical subjects in an odd/even semester is granted <strong>ATKT</strong> and promoted to the next semester.</li>
                <li>The candidate must clear the ATKT backlog examination conducted during the subsequent corresponding semester examinations.</li>
                <li>Promotion to final year degree requires clearance of all first-year foundational subjects as stipulated by the specific faculty ordinance.</li>
                <li>Maximum duration allowed to complete a degree is strictly governed by the <em>N + 2 years</em> UGC ordinance.</li>
            </ul>
        </div>

        <!-- 4. Revaluation, Scrutiny & Code of Conduct against UFM -->
        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                    <h5 class="fw-bold text-navy mb-2"><i class="fas fa-redo text-primary me-2"></i> Revaluation &amp; Scrutiny</h5>
                    <p class="text-muted small" style="line-height: 1.7;">
                        Students dissatisfied with their evaluated theory answer books may apply for <strong>Re-totaling / Revaluation</strong> within 15 days of declaration of results by submitting the prescribed fee through the examination portal.
                    </p>
                    <a href="<?php echo BASE_URL; ?>contact.php" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold mt-auto">
                        <i class="fas fa-external-link-alt me-1"></i> Exam Controller Desk
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 text-white" style="background: linear-gradient(135deg, #7A0B0D 0%, #a8171b 100%);">
                    <h5 class="fw-bold text-white mb-2"><i class="fas fa-ban text-warning me-2"></i> Unfair Means (UFM) Zero Tolerance</h5>
                    <p class="text-white-50 small" style="line-height: 1.7;">
                        Carrying mobile phones, smartwatches, chits, or unauthorized materials into examination halls is strictly prohibited. Instances of cheating are referred to the University UFM Disciplinary Committee and attract cancellation of examination or debarment.
                    </p>
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill small fw-bold">Strictly Enforced CCTV Surveillance</span>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
