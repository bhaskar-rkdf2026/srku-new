<?php
$pageTitle = "Academic Calendar 2026-27 | Semester Schedule, Holidays & Exams | SRKU Bhopal";
$pageDesc = "View the official Academic Calendar 2026-27 for Sarvepalli Radhakrishnan University (SRKU), Bhopal. Check semester dates, mid-term exams, end-semester examinations and holidays.";
$pageKeywords = "SRKU Academic Calendar, University Schedule 2026-27, Semester Exam Dates Bhopal, University Holidays MP";
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
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgba(255,255,255,0.85);">Academic Calendar</li>
                    </ol>
                </nav>
                <span class="about-hero-v2__eyebrow"><i class="fas fa-calendar-alt"></i> Official Academic Planning</span>
                <h1 class="about-hero-v2__title">Academic Calendar <span>2026&ndash;2027</span></h1>
                <p class="about-hero-v2__desc">
                    Comprehensive semester roadmap, teaching schedules, internal assessments, continuous evaluations, university examinations, cultural festivals, and gazetted holiday schedules.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Academic-Calendar.pdf" target="_blank" class="btn-hero-yellow">
                        <i class="fas fa-file-pdf me-1"></i> Download Official Calendar (PDF)
                    </a>
                    <a href="<?php echo BASE_URL; ?>exam-rules.php" class="btn-hero-outline">
                        <i class="fas fa-clipboard-check me-1"></i> Examination Rules &amp; Ordinances
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-hero-v2__cards">
                    <div class="about-hero-v2__card about-hero-v2__card--float1">
                        <i class="fas fa-calendar-check"></i>
                        <span class="num">180+</span>
                        <span class="lbl">Teaching Days / Year</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float2">
                        <i class="fas fa-clock"></i>
                        <span class="num">90</span>
                        <span class="lbl">Days / Semester</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float3">
                        <i class="fas fa-pen-fancy"></i>
                        <span class="num">2</span>
                        <span class="lbl">Mid-Term CIA Tests</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float4">
                        <i class="fas fa-award"></i>
                        <span class="num">UGC</span>
                        <span class="lbl">Compliant Schedule</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calendar Overview Section -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">

        <!-- Semester Filter Tabs -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h3 class="fw-bold text-navy mb-1">Session 2026-27 Milestones</h3>
                <p class="text-muted small mb-0">Follow all academic events, examinations, and term breaks.</p>
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Academic-Calendar.pdf" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 py-2 fw-bold shadow-sm">
                    <i class="fas fa-download me-1"></i> Download PDF
                </a>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- Odd Semester Block (July - December 2026) -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
                    <div class="p-4 text-white" style="background: linear-gradient(135deg, #7A0B0D 0%, #a8171b 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-white"><i class="fas fa-sun me-2 text-warning"></i> Odd Semester (Sem I, III, V, VII)</h5>
                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill small fw-bold">July &ndash; Dec 2026</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 small">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th style="width: 35%;">Academic Activity</th>
                                        <th style="width: 35%;">Scheduled Timeline</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-navy">Commencement of Classes</td>
                                        <td class="text-danger fw-semibold">15th July 2026</td>
                                        <td class="text-muted">Freshers &amp; Senior Batches</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">Orientation &amp; Induction</td>
                                        <td>15th - 20th July 2026</td>
                                        <td class="text-muted">Deeksharambh Induction</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">First Mid-Term (CIA-1)</td>
                                        <td class="text-primary fw-semibold">1st - 6th Sept 2026</td>
                                        <td class="text-muted">Continuous Assessment</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">Second Mid-Term (CIA-2)</td>
                                        <td class="text-primary fw-semibold">15th - 20th Oct 2026</td>
                                        <td class="text-muted">Continuous Assessment</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">Submission of Exam Forms</td>
                                        <td>1st - 10th Nov 2026</td>
                                        <td class="text-muted">Without Late Fee</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">Practical / Viva Examinations</td>
                                        <td>20th - 28th Nov 2026</td>
                                        <td class="text-muted">Internal &amp; External Viva</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">End-Semester Theory Exams</td>
                                        <td class="text-danger fw-bold">1st - 22nd Dec 2026</td>
                                        <td class="text-muted">University Final Exams</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">Winter Break / Vacation</td>
                                        <td>23rd Dec 2026 - 2nd Jan 2027</td>
                                        <td class="text-muted">Semester Recess</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Even Semester Block (January - June 2027) -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
                    <div class="p-4 text-white" style="background: linear-gradient(135deg, #0F1E3B 0%, #1e3a8a 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-white"><i class="fas fa-snowflake me-2 text-info"></i> Even Semester (Sem II, IV, VI, VIII)</h5>
                            <span class="badge bg-info text-dark px-3 py-1 rounded-pill small fw-bold">Jan &ndash; June 2027</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 small">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th style="width: 35%;">Academic Activity</th>
                                        <th style="width: 35%;">Scheduled Timeline</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-navy">Commencement of Classes</td>
                                        <td class="text-danger fw-semibold">4th January 2027</td>
                                        <td class="text-muted">All Programmes</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">Annual Sports &amp; Cultural Fest</td>
                                        <td class="text-success fw-semibold">10th - 14th Feb 2027</td>
                                        <td class="text-muted">"Tarang" Youth Fest</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">First Mid-Term (CIA-1)</td>
                                        <td class="text-primary fw-semibold">22nd - 27th Feb 2027</td>
                                        <td class="text-muted">Continuous Assessment</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">National Science Day Symposium</td>
                                        <td>28th February 2027</td>
                                        <td class="text-muted">Research Paper Contest</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">Second Mid-Term (CIA-2)</td>
                                        <td class="text-primary fw-semibold">5th - 10th April 2027</td>
                                        <td class="text-muted">Continuous Assessment</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">Practical / Lab Examinations</td>
                                        <td>25th April - 2nd May 2027</td>
                                        <td class="text-muted">External Examiners</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">End-Semester Theory Exams</td>
                                        <td class="text-danger fw-bold">5th - 28th May 2027</td>
                                        <td class="text-muted">University Final Exams</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-navy">Summer Internship / Vacation</td>
                                        <td>1st June - 14th July 2027</td>
                                        <td class="text-muted">Industry Projects</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Gazetted Holidays & Guidelines -->
        <div class="row g-4 mt-2">
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-umbrella-beach text-warning me-2"></i> Major Institutional Observances &amp; Holidays 2026-27</h5>
                    <div class="row g-2 small text-secondary">
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Independence Day: 15 Aug</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Raksha Bandhan: Aug 2026</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Janmashtami: Aug 2026</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Gandhi Jayanti: 02 Oct</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Dussehra (Vijaydashmi): Oct 2026</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Deepawali Break: Nov 2026</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Guru Nanak Jayanti: Nov 2026</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Christmas: 25 Dec</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Republic Day: 26 Jan 2027</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Maha Shivratri: Feb 2027</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Holi Festival: March 2027</div>
                        <div class="col-6 col-md-4"><i class="fas fa-calendar-day text-danger me-1"></i> Dr. Ambedkar Jayanti: 14 April 2027</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                    <h5 class="fw-bold text-warning mb-2"><i class="fas fa-info-circle me-1"></i> Mandatory Notes</h5>
                    <ul class="list-unstyled small text-white-50 d-flex flex-column gap-2 mb-0" style="line-height: 1.6;">
                        <li><i class="fas fa-check text-warning me-1"></i> <strong>75% Attendance</strong> is strictly mandatory in theory &amp; practical classes to appear in final exams.</li>
                        <li><i class="fas fa-check text-warning me-1"></i> Medical or emergency leave must be submitted within 7 days to the Head of Department.</li>
                        <li><i class="fas fa-check text-warning me-1"></i> Dates are subject to statutory notifications as per university ordinances.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
