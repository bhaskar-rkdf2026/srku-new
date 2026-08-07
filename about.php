<?php
$pageTitle = "About Us";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';
?>

<div style="background: linear-gradient(135deg, var(--dark-navy), var(--primary-maroon)); color: #ffffff; padding: 60px 20px; text-align: center;">
    <div class="container">
        <h1 style="font-family: var(--font-heading); font-size: 2.8rem; font-weight: 800;">About SRK University</h1>
        <p style="color: var(--accent-gold); font-size: 1.1rem; font-weight: 600; margin-top: 10px;">Excellence in Higher Education, Innovation & Character Building</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;">
            <div>
                <h2 style="font-family: var(--font-heading); color: var(--primary-maroon); font-size: 2rem; margin-bottom: 20px;">Welcome to Sarvepalli Radhakrishnan University</h2>
                <p style="margin-bottom: 15px; color: var(--text-dark); line-height: 1.8;">
                    Sarvepalli Radhakrishnan University (SRKU) Bhopal was established with the vision of offering high-quality technical, medical, pharmaceutical, and managerial education to students from across India and abroad.
                </p>
                <p style="margin-bottom: 20px; color: var(--text-muted); line-height: 1.8;">
                    Recognized under Section 2(f) of the UGC Act 1956, SRKU boasts lush green sprawling campus infrastructure, state-of-the-art laboratories, digital classrooms, comprehensive library resources, and dedicated sports facilities.
                </p>
                <ul style="margin-bottom: 25px;">
                    <li style="margin-bottom: 10px; font-weight: 600;"><i class="fas fa-check-circle" style="color: var(--accent-gold); margin-right: 8px;"></i> Recognized by UGC, AICTE, PCI, INC & Statutory Bodies</li>
                    <li style="margin-bottom: 10px; font-weight: 600;"><i class="fas fa-check-circle" style="color: var(--accent-gold); margin-right: 8px;"></i> 42+ High Tech Laboratories & Research Units</li>
                    <li style="margin-bottom: 10px; font-weight: 600;"><i class="fas fa-check-circle" style="color: var(--accent-gold); margin-right: 8px;"></i> 94% Placement Assistance with Top MNC Companies</li>
                </ul>
            </div>
            <div style="background: var(--light-bg); border-radius: var(--radius-lg); padding: 40px; border: 1px solid var(--border-color);">
                <h3 style="font-family: var(--font-heading); color: var(--dark-navy); margin-bottom: 20px;">University Governance & Statues</h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="page.php?slug=why-srk" class="card" style="padding: 15px; text-decoration: none;">
                        <strong style="color: var(--primary-maroon);">Why SRK University?</strong>
                        <span style="font-size: 0.85rem; color: var(--text-muted);">Discover what makes us the top academic hub in Central India.</span>
                    </a>
                    <a href="page.php?slug=vision-mission" class="card" style="padding: 15px; text-decoration: none;">
                        <strong style="color: var(--primary-maroon);">Vision & Mission Statement</strong>
                        <span style="font-size: 0.85rem; color: var(--text-muted);">Our long-term academic roadmap and institutional values.</span>
                    </a>
                    <a href="courses.php" class="card" style="padding: 15px; text-decoration: none;">
                        <strong style="color: var(--primary-maroon);">Constituent Colleges & Departments</strong>
                        <span style="font-size: 0.85rem; color: var(--text-muted);">Engineering, Pharmacy, Nursing, Management & Science institutes.</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ACCREDITATION SECTION -->
<section class="section bg-light" id="accreditation">
    <div class="container">
        <div class="section-title">
            <h2>Accreditation & Approvals</h2>
            <p>Committed to maintaining the highest national education standards</p>
        </div>
        <div class="grid-3">
            <div class="card" style="text-align: center;">
                <i class="fas fa-university" style="font-size: 3rem; color: var(--primary-maroon); margin-bottom: 15px;"></i>
                <h3 class="card-title">UGC Recognition</h3>
                <p class="card-text">Established by MP State Legislature Act & Recognized by University Grants Commission (UGC) under Section 2(f).</p>
            </div>
            <div class="card" style="text-align: center;">
                <i class="fas fa-award" style="font-size: 3rem; color: var(--accent-gold); margin-bottom: 15px;"></i>
                <h3 class="card-title">NIRF 2026 Participation</h3>
                <p class="card-text">Regular participant in National Institutional Ranking Framework (NIRF) reporting quality benchmarks.</p>
            </div>
            <div class="card" style="text-align: center;">
                <i class="fas fa-certificate" style="font-size: 3rem; color: var(--primary-maroon); margin-bottom: 15px;"></i>
                <h3 class="card-title">AICTE & PCI Approved</h3>
                <p class="card-text">All technical engineering and pharmaceutical programs strictly follow AICTE & PCI guidelines.</p>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
