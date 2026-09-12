<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? $_GET['doc'] ?? '');
$fileParam = sanitize($_GET['file'] ?? '');

$documentsRegistry = array (
  'about-us' => 
  array (
    'title' => 'About Sarvepalli Radhakrishnan University',
    'category' => 'About H.E.I.',
    'subtitle' => 'Institutional Profile, Heritage, Vision & Multidisciplinary Infrastructure',
    'pdf_path' => 'assets/uploads/2025/10/new-update/about-us.pdf',
    'description' => 'Comprehensive institutional overview of Sarvepalli Radhakrishnan University (SRKU), Bhopal highlighting university milestones, leadership, campus infrastructure, academic faculties, research output, and state-of-the-art facilities.',
    'highlights' => 
    array (
      0 => 'Recognized under Section 2(f) of the UGC Act 1956 & MP Niji Vishwavidyalaya Adhiniyam.',
      1 => 'Multidisciplinary campus spread across 85+ lush green acres in Bhopal.',
      2 => 'Constituent colleges in Engineering, Medicine, Dental, Pharmacy, Nursing, Law, and Management.',
      3 => 'Modern research laboratories, central digital library, and 750+ bed teaching hospital.',
    ),
  ),
  'act-statutes' => 
  array (
    'title' => 'Act & Statutes',
    'category' => 'About H.E.I.',
    'subtitle' => 'State Legislative Act, Gazette Notifications & University Statutes',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Act-Statutes.pdf',
    'description' => 'Official legislative act enacted by the Madhya Pradesh State Legislature and gazetted statutes governing the establishment, statutory powers, governance bodies, and operational framework of Sarvepalli Radhakrishnan University.',
    'highlights' => 
    array (
      0 => 'Statutory enactment under MP Niji Vishwavidyalaya Adhiniyam.',
      1 => 'Official Madhya Pradesh Government Gazette notifications.',
      2 => 'Powers, duties, and jurisdiction of statutory university authorities.',
      3 => 'Legal and administrative framework for academic degree conferment.',
    ),
  ),
  'institutional-development-plan' => 
  array (
    'title' => 'Institutional Development Plan (IDP)',
    'category' => 'About H.E.I.',
    'subtitle' => 'Strategic Roadmap for Academic Excellence, NEP 2020 & Infrastructure Augmentation',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Institutional-Development-Plan.pdf',
    'description' => 'Comprehensive strategic institutional development plan formulated in alignment with NEP 2020 guidelines, charting multi-year goals for curriculum modernization, research innovation, global faculty recruitment, and student empowerment.',
    'highlights' => 
    array (
      0 => 'Multi-year strategic roadmap aligned with NEP 2020 directives.',
      1 => 'Infrastructure development, smart classrooms, and central instrumentation labs.',
      2 => 'Faculty development programs and industry-aligned skill centers.',
      3 => 'Metrics for research funding, patent generation, and student placements.',
    ),
  ),
  'constituent-units' => 
  array (
    'title' => 'Constituent Units of SRK University',
    'category' => 'About H.E.I.',
    'subtitle' => 'Approved Constituent Colleges, Specialized Institutes & Faculties',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Constituent-units.pdf',
    'description' => 'Official directory of constituent units, institutes, and departments operating under the statutory umbrella of Sarvepalli Radhakrishnan University Bhopal, approved by respective national regulatory councils.',
    'highlights' => 
    array (
      0 => 'Complete list of constituent colleges across Medical, Dental, Pharmacy, Engineering, and Law.',
      1 => 'Regulatory council approval references (NMC, DCI, PCI, AICTE, BCI, INC).',
      2 => 'Campus locations, academic programs, and sanctioned student intake.',
      3 => 'Interdisciplinary academic resources and shared hospital infrastructure.',
    ),
  ),
  'accreditation-ranking' => 
  array (
    'title' => 'Accreditation & Institutional Ranking',
    'category' => 'About H.E.I.',
    'subtitle' => 'National Accreditations, Regulatory Approvals & Institutional Rankings',
    'pdf_path' => 'assets/uploads/pdf/Accreditation-Ranking.pdf',
    'description' => 'Official record of accreditations, certifications, and institutional rankings conferred on Sarvepalli Radhakrishnan University by apex educational and professional bodies.',
    'highlights' => 
    array (
      0 => 'UGC Section 2(f) statutory recognition.',
      1 => 'National Institutional Ranking Framework (NIRF) participation and disclosures.',
      2 => 'Professional council certifications across technical and medical faculties.',
      3 => 'Quality benchmarks validated by internal and external academic audits.',
    ),
  ),
  'recognition-approval' => 
  array (
    'title' => 'Recognition & Statutory Approvals',
    'category' => 'About H.E.I.',
    'subtitle' => 'UGC, AICTE, PCI, INC, BCI, AYUSH & Statutory Council Approvals',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Recognition-Approval.pdf',
    'description' => 'Gazetted statutory recognitions, UGC notifications, and apex regulatory council approval orders authorising degree conferral and academic operations at SRKU.',
    'highlights' => 
    array (
      0 => 'Statutory approvals from UGC, AICTE, NMC, PCI, BCI, and INC.',
      1 => 'State Government authorization orders and gazetted regulations.',
      2 => 'Validations for Undergraduate, Postgraduate, and Doctoral degree offerings.',
      3 => 'Periodic extension of approval (EOA) notifications.',
    ),
  ),
  'annual-report' => 
  array (
    'title' => 'Annual Report 2024-25',
    'category' => 'About H.E.I.',
    'subtitle' => 'Annual Institutional Progress, Academic Achievements & Financial Summary',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Recognition-Approval.pdf',
    'description' => 'Comprehensive annual report of Sarvepalli Radhakrishnan University detailing annual academic performance, research publications, faculty achievements, admissions, and campus developments.',
    'highlights' => 
    array (
      0 => 'Summary of academic milestones achieved during the academic year 2024-25.',
      1 => 'Student enrollment, examination results, and convocation degree statistics.',
      2 => 'Research grants, funded projects, patents, and peer-reviewed publications.',
      3 => 'Campus placements, recruitment partners, and student achievement honors.',
    ),
  ),
  'details-of-sponsoring-body' => 
  array (
    'title' => 'Details of Sponsoring Body',
    'category' => 'About H.E.I.',
    'subtitle' => 'RKDF Education Society - Founding Trust, Objectives & Governance',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Details_of_Sponsoring_Body.pdf',
    'description' => 'Official registration documentation, charter, objectives, and governing body details of the RKDF Education Society, the sponsoring body of Sarvepalli Radhakrishnan University Bhopal.',
    'highlights' => 
    array (
      0 => 'Registration under the Societies Registration Act.',
      1 => 'Visionary educational leadership steering 25+ institutions across Central India.',
      2 => 'Philanthropic initiatives, scholarship endowments, and rural healthcare delivery.',
      3 => 'Statutory compliance documents and financial transparency records.',
    ),
  ),
  'council-of-technical-education' => 
  array (
    'title' => 'Council of Technical Education (EOA Report)',
    'category' => 'About H.E.I.',
    'subtitle' => 'AICTE Extension of Approval (EOA) Compliance & Sanctioned Intakes',
    'pdf_path' => 'assets/uploads/2023/09/EOA_Report_2020-21-1.pdf',
    'description' => 'Official AICTE Extension of Approval (EOA) letters specifying approved technical, engineering, pharmacy, and management courses, along with sanctioned intakes and institutional norms.',
    'highlights' => 
    array (
      0 => 'AICTE extension of approval for B.Tech, M.Tech, MBA, and MCA programmes.',
      1 => 'Sanctioned student intake capacity per academic discipline.',
      2 => 'Faculty cadre compliance and lab infrastructure audit records.',
      3 => 'Adherence to AICTE approval process handbook guidelines.',
    ),
  ),
  'university-ordinance' => 
  array (
    'title' => 'University Ordinance (1 to 92)',
    'category' => 'About H.E.I.',
    'subtitle' => 'Statutory Academic Ordinances, Rules of Admission & Course Syllabi',
    'pdf_path' => 'assets/uploads/2026/07/university-ordinance.pdf',
    'description' => 'Official gazetted university ordinances (Ordinance 1 to 92) governing course admission criteria, examination grading schemas, conduct of examinations, fee structure, and degree conferral.',
    'highlights' => 
    array (
      0 => 'Detailed course-by-course ordinances for Undergraduate and Postgraduate programs.',
      1 => 'Examination passing standards, grace marks regulations, and grade conversions.',
      2 => 'Rules for condonation of attendance, migration, and revaluation.',
      3 => 'Disciplinary regulations and code of student conduct.',
    ),
  ),
  'ordinance-93-100' => 
  array (
    'title' => 'Subsequent Ordinance (93 to 100)',
    'category' => 'About H.E.I.',
    'subtitle' => 'Gazette Notifications for Specialized Academic Ordinances 93-100',
    'pdf_path' => 'assets/uploads/2025/08/ordinance/ordinance-93-100.pdf',
    'description' => 'Subsequent official university ordinances (Ordinance 93 to 100) notified in the Madhya Pradesh Gazette covering specialized postgraduate curricula, super-specialty medical, paramedical, and research degrees.',
    'highlights' => 
    array (
      0 => 'Gazette notifications for newly introduced interdisciplinary courses.',
      1 => 'Regulations for specialized healthcare and technical programs.',
      2 => 'Credit accumulation and transfer framework aligned with NEP 2020.',
      3 => 'Evaluation modalities for advanced certifications and fellowships.',
    ),
  ),
  'ugc-information' => 
  array (
    'title' => 'UGC Information (Annexure I)',
    'category' => 'About H.E.I.',
    'subtitle' => 'Statutory Compliance Submission to University Grants Commission (UGC)',
    'pdf_path' => 'assets/uploads/2023/05/annexure-I-UGCinfo.pdf',
    'description' => 'Official statutory disclosure and information submission provided to the University Grants Commission (UGC) pursuant to Section 2(f) requirements, covering campus land, buildings, faculty, and academic programs.',
    'highlights' => 
    array (
      0 => 'Full compliance proforma submitted to UGC Expert Committee.',
      1 => 'Physical infrastructure, built-up area, and equipment inventories.',
      2 => 'Faculty rosters, pay scales, and qualification validations.',
      3 => 'Financial stability certificates and endowment fund disclosures.',
    ),
  ),
  'student-grievance-committee' => 
  array (
    'title' => 'Student Grievance Redressal Committee',
    'category' => 'All Committee',
    'subtitle' => 'Institutional Grievance Redressal Committee (SGRC) & Regulations',
    'pdf_path' => 'assets/uploads/2025/allCommittee/Student_Grievance_Committee.pdf',
    'description' => 'Official notification delineating the constitution, membership, powers, and procedure of the Student Grievance Redressal Committee (SGRC) constituted in compliance with UGC Regulations.',
    'highlights' => 
    array (
      0 => 'Independent committee headed by senior faculty to resolve student complaints.',
      1 => 'Time-bound 15-day grievance investigation and redressal mechanism.',
      2 => 'Special provisions for online registration of academic and hostel concerns.',
      3 => 'Direct appellate pathway to University Ombudsman.',
    ),
  ),
  'anti-ragging' => 
  array (
    'title' => 'Anti-Ragging Committee & Squad',
    'category' => 'All Committee',
    'subtitle' => 'Zero Tolerance Policy, Anti-Ragging Squad & Student Welfare Mandate',
    'pdf_path' => 'assets/uploads/2025/allCommittee/AntiRagging.pdf',
    'description' => 'University notification on Anti-Ragging Committee and Squads constituted as per Supreme Court directives and UGC Anti-Ragging regulations, maintaining a 100% ragging-free campus.',
    'highlights' => 
    array (
      0 => 'Zero tolerance policy with immediate punitive consequences for ragging.',
      1 => '24x7 monitoring squads across academic zones, dining halls, and student hostels.',
      2 => 'National Anti-Ragging helpline coordinates and institutional nodal officers.',
      3 => 'Mandatory affidavits collected from students and parents at admission.',
    ),
  ),
  'obc-minority' => 
  array (
    'title' => 'OBC & Minority Grievance Committee',
    'category' => 'All Committee',
    'subtitle' => 'Welfare, Equal Opportunity & Support for OBC & Minority Students',
    'pdf_path' => 'assets/uploads/pdf/OBC-Minority.pdf',
    'description' => 'Institutional cell constituted to oversee welfare, redress grievances, and provide academic support to Other Backward Classes (OBC) and Religious/Linguistic Minority students.',
    'highlights' => 
    array (
      0 => 'Assistance with state and central scholarship applications (Post-Matric, Merit-cum-Means).',
      1 => 'Remedial coaching and communication skill development workshops.',
      2 => 'Confidential hearing and prompt resolution of academic and social issues.',
      3 => 'Representation in university student welfare councils.',
    ),
  ),
  'women-grievance-committee' => 
  array (
    'title' => 'Women Grievance Committee',
    'category' => 'All Committee',
    'subtitle' => 'Women Empowerment, Safety & Internal Complaint Redressal',
    'pdf_path' => 'assets/uploads/2024/07/women-grievance-committee.pdf',
    'description' => 'Statutory committee dedicated to ensuring the safety, dignity, and empowerment of female students, faculty, and administrative staff across university campuses.',
    'highlights' => 
    array (
      0 => 'Strict adherence to POSH guidelines and UGC gender sensitization mandates.',
      1 => 'Confidential grievance reporting and fast-track investigation hearings.',
      2 => 'Regular counseling sessions, self-defense workshops, and awareness rallies.',
      3 => 'Safe campus corridors, secure hostel accommodation, and women helpline access.',
    ),
  ),
  'sc-st-grievance-committee' => 
  array (
    'title' => 'SC & ST Grievance Committee',
    'category' => 'All Committee',
    'subtitle' => 'Prevention of Caste Discrimination & SC/ST Cell Oversight',
    'pdf_path' => 'assets/uploads/2025/allCommittee/SC_ST_Grievance_committee.pdf',
    'description' => 'Statutory committee established to prevent discrimination, ensure social justice, and promote the academic and professional development of Scheduled Caste (SC) and Scheduled Tribe (ST) students.',
    'highlights' => 
    array (
      0 => 'Strict enforcement of Scheduled Castes and the Scheduled Tribes (Prevention of Atrocities) Act.',
      1 => 'Special guidance for government freeship, fellowship, and scholarship schemes.',
      2 => 'Academic mentoring, book bank access, and competitive examination preparation.',
      3 => 'Dedicated nodal officer for transparent dispute resolution.',
    ),
  ),
  'equal-opportunity-cell' => 
  array (
    'title' => 'Equal Opportunity Cell',
    'category' => 'All Committee',
    'subtitle' => 'Inclusive Campus Environment, Accessibility & Student Support',
    'pdf_path' => 'assets/uploads/pdf/EqualOppurtunityCell.pdf',
    'description' => 'Official notification and operational charter of the Equal Opportunity Cell fostering an inclusive, equitable, and barrier-free educational environment for students of all backgrounds.',
    'highlights' => 
    array (
      0 => 'Holistic support for differently-abled and economically marginalized scholars.',
      1 => 'Ensuring barrier-free infrastructure, ramps, accessible elevators, and tactile paths.',
      2 => 'Skill-enhancement workshops, digital accessibility tools, and assistive tech.',
      3 => 'Sensitization programs on inclusivity, mutual respect, and social equity.',
    ),
  ),
  'officers-of-university' => 
  array (
    'title' => 'Officers of the University',
    'category' => 'Administration',
    'subtitle' => 'Statutory Officers, Leadership & Administrative Authorities',
    'pdf_path' => 'assets/uploads/2026/07/OfficersofUniversity.pdf',
    'description' => 'Official gazetted directory of statutory officers of Sarvepalli Radhakrishnan University including the Chancellor, Vice-Chancellor, Registrar, Chief Finance Officer, Deans, and Examination Controller.',
    'highlights' => 
    array (
      0 => 'Statutory administrative framework and executive hierarchy.',
      1 => 'Profiles and designations of apex university officers.',
      2 => 'Official contact channels and administrative responsibilities.',
      3 => 'Compliance with State University Act and Ordinances.',
    ),
  ),
  'governing-body' => 
  array (
    'title' => 'Governing Body',
    'category' => 'Administration',
    'subtitle' => 'Constitution, Apex Governance & Members of University Governing Body',
    'pdf_path' => 'assets/uploads/pdf/Governing-Body.pdf',
    'description' => 'Official constitution and list of distinguished members constituting the Governing Body of Sarvepalli Radhakrishnan University, responsible for strategic policy formulation and institutional stewardship.',
    'highlights' => 
    array (
      0 => 'Apex decision-making authority of the University.',
      1 => 'Distinguished academicians, administrators, and industry experts.',
      2 => 'Approval of university budgets, development plans, and expansions.',
      3 => 'Institutional vision and academic governance.',
    ),
  ),
  'board-of-management' => 
  array (
    'title' => 'Board of Management',
    'category' => 'Administration',
    'subtitle' => 'Executive Governance, Appointments & Administrative Affairs',
    'pdf_path' => 'assets/uploads/pdf/Board-of-Management.pdf',
    'description' => 'Official documentation outlining the composition and executive powers of the Board of Management, overseeing overall administration, faculty recruitment, infrastructure creation, and operational governance.',
    'highlights' => 
    array (
      0 => 'Executive body responsible for administrative operations and management.',
      1 => 'Review and sanction of academic appointments and cadre approvals.',
      2 => 'Establishment of departments, centers, and infrastructure expansion.',
      3 => 'Execution of statutory regulations and ordinances.',
    ),
  ),
  'finance-committee' => 
  array (
    'title' => 'Finance Committee',
    'category' => 'Administration',
    'subtitle' => 'Financial Oversight, Annual Budgeting & Audit Control',
    'pdf_path' => 'assets/uploads/pdf/Finance-Committee.pdf',
    'description' => 'Constitution and membership of the University Finance Committee, entrusted with annual financial planning, budget allocations, expenditure monitoring, and internal financial audits.',
    'highlights' => 
    array (
      0 => 'Scrutiny of annual budget estimates and capital allocations.',
      1 => 'Monitoring of institutional financial health, grants, and audit reports.',
      2 => 'Resource allocation for laboratory modernization and research seed grants.',
      3 => 'Compliance with statutory accounting and financial norms.',
    ),
  ),
  'academic-councils' => 
  array (
    'title' => 'Academic Council',
    'category' => 'Administration',
    'subtitle' => 'Apex Academic Authority, Curriculum Standards & Examination Framework',
    'pdf_path' => 'assets/uploads/pdf/ACADEMIC-COUNCIL-20.pdf.pdf',
    'description' => 'Official listing of members constituting the Academic Council of SRKU, responsible for maintaining high academic standards, curriculum revisions, pedagogical innovations, and examination regulations.',
    'highlights' => 
    array (
      0 => 'Formulation and approval of academic regulations and degree schemes.',
      1 => 'Curriculum development in alignment with NEP 2020 guidelines.',
      2 => 'Approval of new faculties, courses, and interdisciplinary programmes.',
      3 => 'Evaluation standards, credit frameworks, and grading systems.',
    ),
  ),
  'board-of-studies' => 
  array (
    'title' => 'Board of Studies',
    'category' => 'Administration',
    'subtitle' => 'Departmental Academic Panels, Course Syllabus & Curriculum Panels',
    'pdf_path' => 'assets/uploads/pdf/BoardofStudies.pdf',
    'description' => 'Department-wise committees of the Board of Studies (BOS) comprising subject experts and senior faculty responsible for designing, updating, and evaluating course curricula across disciplines.',
    'highlights' => 
    array (
      0 => 'Periodic syllabus revision aligned with emerging industrial requirements.',
      1 => 'Design of practical experiments, project modules, and internship structures.',
      2 => 'Prescription of textbook references, e-learning resources, and research papers.',
      3 => 'Continuous evaluation schemes and question paper frameworks.',
    ),
  ),
  'internal-complaint-committee' => 
  array (
    'title' => 'Internal Complaint Committee (ICC)',
    'category' => 'Administration',
    'subtitle' => 'Grievance Redressal, Gender Sensitization & Women Safety at Workplace',
    'pdf_path' => 'assets/uploads/pdf/Internal-Complaint-Committee.pdf',
    'description' => 'Official constitution, mandate, and contact details of the Internal Complaint Committee established in compliance with POSH Act regulations to ensure a secure, respectful, and gender-inclusive campus environment.',
    'highlights' => 
    array (
      0 => 'Prevention, prohibition, and redressal of sexual harassment and discrimination.',
      1 => 'Confidential and time-bound inquiry mechanism for registered grievances.',
      2 => 'Regular gender-sensitization workshops, awareness drives, and counseling support.',
      3 => 'Zero tolerance towards harassment across campus facilities and hostels.',
    ),
  ),
  'academic-leadership' => 
  array (
    'title' => 'Academic Leadership',
    'category' => 'Administration',
    'subtitle' => 'Deans of Faculties, Institute Principals & Departmental Heads',
    'pdf_path' => 'assets/uploads/pdf/AcademicLeadership.pdf',
    'description' => 'Official directory of Deans, Directors, and Principals steering academic excellence across Engineering, Medical, Dental, Pharmacy, Nursing, Law, Agriculture, Management, and Science faculties.',
    'highlights' => 
    array (
      0 => 'Leadership profiles of constituent college heads and faculty deans.',
      1 => 'Directorial oversight of research centers, hospital administration, and labs.',
      2 => 'Industry collaboration, corporate liaison, and global partnerships.',
      3 => 'Mentorship of doctoral research scholars and faculty development.',
    ),
  ),
  'bjmc-syllabus-scheme' => 
  array (
    'title' => 'BJMC Syllabus & Scheme',
    'category' => 'Syllabus',
    'subtitle' => 'Bachelor of Journalism & Mass Communication Curriculum & Evaluation Scheme',
    'pdf_path' => 'assets/uploads/pdf/Srk-University-BJMC-syllabus-scheme.pdf',
    'description' => 'Comprehensive academic syllabus, semester-wise scheme of examination, subject codes, and practical laboratory components for the Bachelor of Journalism and Mass Communication (BJMC) degree program.',
    'highlights' => 
    array (
      0 => 'Semester-wise breakdown of print, television, digital, and radio journalism modules.',
      1 => 'Media law, ethics, public relations, advertising, and corporate communications.',
      2 => 'Practical news anchoring, audio-video production, editing software, and photojournalism.',
      3 => 'Mandatory newsroom internships, media project portfolios, and dissertation guidelines.',
    ),
  ),
  'details-of-academic-programmes' => 
  array (
    'title' => 'Details of Academic Programmes',
    'category' => 'Academics',
    'subtitle' => 'Undergraduate, Postgraduate, Diploma & Doctoral Programmes Directory',
    'pdf_path' => 'assets/uploads/pdf/Details-of-Academic-Programmes.pdf',
    'description' => 'Comprehensive academic programme directory detailing course nomenclature, duration, intake capacity, and eligibility parameters across faculties.',
    'highlights' => 
    array (
      0 => '90+ programs across Engineering, Medicine, Dental, Pharmacy, Law, and Sciences.',
      1 => 'Sanctioned seat matrices and regulatory approval references.',
      2 => 'NEP-2020 aligned multiple entry-exit credit structures.',
      3 => 'Admission criteria, minimum eligibility percentages, and entrance requisites.',
    ),
  ),
  'academic-calendar' => 
  array (
    'title' => 'Academic Calendar 2024-25',
    'category' => 'Academics',
    'subtitle' => 'Semester Schedule, Teaching Days, Mid-Terms, Breaks & Terminal Examinations',
    'pdf_path' => 'assets/uploads/pdf/Academic-Calendar.pdf',
    'description' => 'Official university academic calendar for odd and even semesters specifying commencement of classes, continuous internal assessments, practical exams, term-end examinations, and vacation schedules.',
    'highlights' => 
    array (
      0 => 'Prescribed 90 teaching days per semester standard compliant with UGC norms.',
      1 => 'Schedule for internal assessment tests (MST-I, MST-II), quizzes, and assignments.',
      2 => 'Winter/Summer semester break timelines and gazetted university holidays.',
      3 => 'Terminal university examination and result declaration deadlines.',
    ),
  ),
  'statutes-ordinances-academics-examination' => 
  array (
    'title' => 'Statutes & Ordinances Pertaining to Academics & Examination',
    'category' => 'Academics',
    'subtitle' => 'Academic Framework, Evaluation Standards, Grading & Conduct of Examinations',
    'pdf_path' => 'assets/uploads/2026/07/statutes-ordinances-pertaining-to-academics-examination.pdf',
    'description' => 'Official university statutes and ordinances regulating academic curricula, grading systems, continuous evaluation, and terminal examination protocols.',
    'highlights' => 
    array (
      0 => 'Choice Based Credit System (CBCS) rules, credit definitions, and grade point averages (SGPA/CGPA).',
      1 => 'Conduct of practical, viva-voce, theory examinations, and appointment of external examiners.',
      2 => 'Provisions regarding scrutiny, re-totaling, revaluation, and unfair means committee.',
      3 => 'Norms for promotion from one academic semester to the subsequent year.',
    ),
  ),
  'school-department-centres' => 
  array (
    'title' => 'School / Department / Centres Directory',
    'category' => 'Academics',
    'subtitle' => 'Constituent Units, Academic Faculties, Departments & Specialist Research Centres',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Constituent-units&Department.pdf',
    'description' => 'Institutional directory listing all university academic schools, teaching departments, specialized clinical centers, and interdisciplinary research facilities under SRKU.',
    'highlights' => 
    array (
      0 => 'Complete directory of constituent academic schools and departments.',
      1 => 'Specialized clinical and technical centers supporting high-level studies.',
      2 => 'Interdisciplinary learning hubs, design studios, and simulation labs.',
      3 => 'Departmental leadership contacts and administrative infrastructure.',
    ),
  ),
  'faculty-staff-details' => 
  array (
    'title' => 'Faculty & Staff Details',
    'category' => 'Academics',
    'subtitle' => 'Department-Wise Directory of Professors, Associate Professors & Academic Staff',
    'pdf_path' => 'assets/uploads/pdf/department-wise-faculty-details.pdf',
    'description' => 'Official department-wise directory showcasing distinguished faculty members, academic designations, doctoral qualifications, specializations, and years of teaching/research experience.',
    'highlights' => 
    array (
      0 => 'Full faculty roster across 25+ constituent colleges and faculties.',
      1 => 'Professors, Associate Professors, and Assistant Professors with Ph.D. qualifications.',
      2 => 'Research interest domains, patent holders, and funded project investigators.',
      3 => 'Staff-to-student ratios compliant with statutory council standards.',
    ),
  ),
  'iqac' => 
  array (
    'title' => 'Internal Quality Assurance Cell (IQAC)',
    'category' => 'Academics',
    'subtitle' => 'Quality Enhancement Initiatives, Academic Audits & Compliance Framework',
    'pdf_path' => 'assets/uploads/pdf/IQAC.pdf',
    'description' => 'Constitution, objectives, quality initiatives, and annual audit procedures of the University Internal Quality Assurance Cell (IQAC) dedicated to continuous institutional quality enhancement.',
    'highlights' => 
    array (
      0 => 'Monitoring institutional teaching-learning methodologies and outcome benchmarks.',
      1 => 'Conduction of periodic internal and external academic and administrative audits.',
      2 => 'Stakeholder feedback mechanism from students, alumni, parents, and recruiters.',
      3 => 'Facilitation of faculty development, curriculum revamps, and NAAC/NIRF metrics.',
    ),
  ),
  'university-library' => 
  array (
    'title' => 'University Central Library',
    'category' => 'Academics',
    'subtitle' => 'Central Knowledge Resource, E-Journals, Digital Library & Learning Spaces',
    'pdf_path' => 'assets/uploads/pdf/UniversityLibrary.pdf',
    'description' => 'Detailed information regarding the University Central Library and constituent branch libraries housing over 1,00,000+ volumes, international journals, digital databases, and DELNET subscriptions.',
    'highlights' => 
    array (
      0 => 'Extensive repository of textbooks, reference manuals, theses, and rare manuscripts.',
      1 => '24x7 Digital Library portal with remote access to IEEE, ScienceDirect, PubMed, and DELNET.',
      2 => 'Air-conditioned reading halls accommodating 500+ students simultaneously.',
      3 => 'Automated library management system with RFID barcoding and automated issue/return.',
    ),
  ),
  'prospectus' => 
  array (
    'title' => 'University Prospectus',
    'category' => 'Admission & Fee',
    'subtitle' => 'Official Academic Prospectus, Disciplines, Infrastructure & Campus Life',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Prospectus.pdf',
    'description' => 'Official university prospectus containing detailed information regarding academic departments, undergraduate, postgraduate and doctoral programmes, campus facilities, faculty profiles, and student amenities.',
    'highlights' => 
    array (
      0 => 'Overview of 25+ Constituent Colleges, Institutes and University Faculties.',
      1 => 'Undergraduate, Postgraduate, Diploma and Doctoral degree offerings.',
      2 => 'Modern laboratory infrastructure, Central Computing Facility and 750+ Bed Teaching Hospital.',
      3 => 'Scholarships, campus placement records, and student development initiatives.',
    ),
  ),
  'admission-process-guidelines' => 
  array (
    'title' => 'Admission Process & Guidelines',
    'category' => 'Admission & Fee',
    'subtitle' => 'Step-by-Step Admission Procedure, Verification Norms & Schedule',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Admission-Process&Guidelines.pdf',
    'description' => 'Comprehensive institutional guidelines outlining candidate registration, qualifying document scrutiny, counseling schedule, merit list criteria, and fee deposition for candidates seeking admission.',
    'highlights' => 
    array (
      0 => 'Clear step-by-step instructions for online and campus counter admissions.',
      1 => 'Checklist of required certificates, mark-sheets, and identity proofs.',
      2 => 'Fee payment modalities, installment schedules, and receipt generation.',
      3 => 'Reporting instructions, induction schedules, and commencement dates.',
    ),
  ),
  'fee-refund-policy' => 
  array (
    'title' => 'Fee Refund Policy',
    'category' => 'Admission & Fee',
    'subtitle' => 'University Fee Cancellation & Refund Regulations Compliant with UGC Norms',
    'pdf_path' => 'assets/uploads/pdf/Fee-Refund-Policy-2024-25.pdf',
    'description' => 'Official policy governing the procedure, timelines, deductions, and processing of fee refunds for candidates seeking cancellation or withdrawal of admission as per UGC and statutory council regulations.',
    'highlights' => 
    array (
      0 => 'Standardized refund slabs based on formal withdrawal application submission dates.',
      1 => 'Deduction rules and processing mechanism through banking channels.',
      2 => 'Refund procedure for caution money and hostel/transport deposits.',
      3 => 'Grievance redressal channel for admission cancellation requests.',
    ),
  ),
  'research-development-cell' => 
  array (
    'title' => 'Research & Development Cell (RDC)',
    'category' => 'Research',
    'subtitle' => 'Research Promotion, Project Grants, Publications & Innovations',
    'pdf_path' => 'assets/uploads/2025/10/new-update/research&developmentcell.pdf',
    'description' => 'Documentation outlining the objectives, organizational hierarchy, and operational framework of the University Research & Development Cell fostering high-impact research, external grants, and technology innovation.',
    'highlights' => 
    array (
      0 => 'Coordination of sponsored research projects with DST, SERB, ICMR, and AICTE.',
      1 => 'Facilitation of multidisciplinary research groups and innovation clusters.',
      2 => 'Research seed grants for young faculty and doctoral scholars.',
      3 => 'Incentive schemes for SCI/Scopus indexed journal publications and patents.',
    ),
  ),
  'incubation-centre' => 
  array (
    'title' => 'University Incubation Centre',
    'category' => 'Research',
    'subtitle' => 'Startup Ecosystem, Innovation Hub, Mentorship & Entrepreneurship Support',
    'pdf_path' => 'assets/uploads/pdf/incubation-centre.pdf',
    'description' => 'Overview of the University Technology Business Incubation Centre providing seed funding, mentorship, prototyping labs, and legal/IPR advisory to budding student and faculty startups.',
    'highlights' => 
    array (
      0 => 'Plug-and-play co-working spaces equipped with high-speed internet and conference rooms.',
      1 => 'Access to venture capitalists, angel investors, and government startup grants.',
      2 => 'Mentorship from successful tech entrepreneurs, alumni founders, and industry leaders.',
      3 => 'Assistance with company incorporation, patenting, and commercial pilot launches.',
    ),
  ),
  'research-policy' => 
  array (
    'title' => 'University Research Policy',
    'category' => 'Research',
    'subtitle' => 'Institutional Guidelines for Ethics, Publications, IPR & Seed Funding',
    'pdf_path' => 'assets/uploads/pdf/university_research_policy.pdf',
    'description' => 'Comprehensive policy governing research standards, ethical clearances, intellectual property management, patent filings, research incentives, and collaborative research initiatives at SRKU.',
    'highlights' => 
    array (
      0 => 'Code of ethics in scientific research and academic publishing.',
      1 => 'Intellectual Property Rights (IPR) filing support and patent commercialization.',
      2 => 'Financial incentives for high-impact research publications and books.',
      3 => 'Guidelines for collaborative research with national and international bodies.',
    ),
  ),
  'central-facilities-research' => 
  array (
    'title' => 'Central Facilities for Research and Development',
    'category' => 'Research',
    'subtitle' => 'Advanced Instrumentation, Central Computing & Laboratory Infrastructure',
    'pdf_path' => 'assets/uploads/pdf/Central-Facilities-for-Research-and-Development.pdf',
    'description' => 'Overview of high-end analytical equipment, computational clusters, central research labs, animal house, and specialized instrumentation accessible to university researchers and doctoral scholars.',
    'highlights' => 
    array (
      0 => 'Advanced analytical instrumentation across Pharmacy, Medical, and Science labs.',
      1 => 'High-performance computing laboratory and simulation software tools.',
      2 => 'CPCSEA approved Animal House and Central Biosafety facilities.',
      3 => 'Open access facility usage guidelines for scholars and faculty.',
    ),
  ),
  'ethics-board' => 
  array (
    'title' => 'Ethics Board to Maintain Research Integrity',
    'category' => 'Research',
    'subtitle' => 'Institutional Ethics Committee, Bioethics & Research Integrity Guidelines',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Constitution-of-Ethics-Board.pdf',
    'description' => 'Constitution and code of practice of the Institutional Ethics Board monitoring research integrity, ethical clearance for human and animal trials, and anti-plagiarism compliance across all disciplines.',
    'highlights' => 
    array (
      0 => 'Ethical scrutiny of biomedical, clinical, and pharmacological research proposals.',
      1 => 'Strict adherence to ICMR, CPCSEA, and global bioethics guidelines.',
      2 => 'Plagiarism checking protocol for dissertations, papers, and synopsis.',
      3 => 'Promoting transparent, responsible, and ethical conduct in scientific inquiry.',
    ),
  ),
  'consultancy-projects' => 
  array (
    'title' => 'Consultancy Projects & Guidelines',
    'category' => 'Research',
    'subtitle' => 'Industry Consultancy, Technical Solutions & Technology Transfer',
    'pdf_path' => 'assets/uploads/pdf/consultancy-projects.pdf',
    'description' => 'Framework for faculty and departments offering specialized industrial consultancy, testing services, corporate training, and technical advisory to government and private sector organizations.',
    'highlights' => 
    array (
      0 => 'Revenue sharing, institutional overheads, and project administration norms.',
      1 => 'Material testing, drug formulation analysis, and software development services.',
      2 => 'Corporate customized training and skill development programs.',
      3 => 'MoUs with leading industrial firms and technology corporations.',
    ),
  ),
  'phd-admission-policy' => 
  array (
    'title' => 'Admission Policy for Ph.D. Programme',
    'category' => 'Research',
    'subtitle' => 'UGC Minimum Standards for the Award of Ph.D. Degree Ordinance',
    'pdf_path' => 'assets/uploads/pdf/Admission_policy_for_Ph.D.Programme.pdf',
    'description' => 'Official university ordinance governing Doctor of Philosophy (Ph.D.) admissions, eligibility standards, coursework structure, Research Advisory Committee (RAC) evaluations, and thesis submission.',
    'highlights' => 
    array (
      0 => 'Eligibility norms compliant with UGC / AICTE and Apex Regulatory Councils.',
      1 => 'Doctoral Entrance Test (DET) guidelines and interview evaluation criteria.',
      2 => 'Mandatory Pre-Ph.D. coursework, research ethics, and publication mandates.',
      3 => 'Research synopsis approval, progress review, and dissertation examination.',
    ),
  ),
  'constitution-of-research-advisory-committee' => 
  array (
    'title' => 'Constitution of Research Advisory Committee (RAC)',
    'category' => 'Research',
    'subtitle' => 'Doctoral Monitoring Panels, Guide Allocation & Half-Yearly Research Reviews',
    'pdf_path' => 'assets/uploads/pdf/constitution-of-research-advisory-committee.pdf',
    'description' => 'Mandate, composition, and functions of candidate-specific Research Advisory Committees (RAC) overseeing doctoral research milestones from topic approval to thesis defense.',
    'highlights' => 
    array (
      0 => 'Three-member expert committee constituted for every registered Ph.D. scholar.',
      1 => 'Evaluation of half-yearly research progress reports and laboratory experiments.',
      2 => 'Guidance on pre-submission presentation, thesis drafting, and viva voce.',
      3 => 'Resolution of research bottlenecks and supervisor coordination.',
    ),
  ),
  'phd-scholars-currently-enrolled' => 
  array (
    'title' => 'Details About Ph.D. Scholars Currently Enrolled',
    'category' => 'Research',
    'subtitle' => 'Official Registry of Active Doctoral Research Scholars across Disciplines',
    'pdf_path' => 'assets/uploads/pdf/Details-about-Ph.D.Scholars-Currently-Enrolled.pdf',
    'description' => 'Official university registry and public disclosure of active doctoral research scholars pursuing Ph.D. programmes along with their department, guide details, and registration session.',
    'highlights' => 
    array (
      0 => 'Public compliance record as per UGC minimum standard disclosure mandates.',
      1 => 'Discipline-wise distribution of currently enrolled doctoral scholars.',
      2 => 'Details of approved research supervisors and recognized guides.',
      3 => 'Research progress monitoring and Departmental Research Committee tracking.',
    ),
  ),
  'sports-facilities' => 
  array (
    'title' => 'Sports Facilities',
    'category' => 'Student Life',
    'subtitle' => 'Sports Infrastructure, Athletic Complexes & University Gymnasium',
    'pdf_path' => 'assets/uploads/2025/10/new-update/sports-Facilities.pdf',
    'description' => 'Overview of world-class outdoor and indoor sports facilities, athletic tracks, cricket ground, football arena, basketball courts, and fitness centers at SRK University.',
    'highlights' => 
    array (
      0 => 'Olympic-standard athletic track and multipurpose sports grounds.',
      1 => 'Dedicated indoor complex for Badminton, Table Tennis, Chess, and Carrom.',
      2 => 'Modern fitness center and gymnasium with certified trainers.',
      3 => 'Annual sports meet, inter-university tournaments, and athletic scholarships.',
    ),
  ),
  'ncc-nss' => 
  array (
    'title' => 'NCC & NSS',
    'category' => 'Student Life',
    'subtitle' => 'National Cadet Corps & National Service Scheme Activities & Units',
    'pdf_path' => 'assets/uploads/pdf/NCC-NSS-Details.pdf',
    'description' => 'Details of active NCC battalions and NSS units at SRKU promoting leadership, community service, discipline, social outreach, and defense career preparedness.',
    'highlights' => 
    array (
      0 => 'Authorized NCC Senior Division army wings offering B & C certificates.',
      1 => 'Active NSS volunteer units organizing regular blood donation and rural health camps.',
      2 => 'Special reservation and career advantage for defense forces and public services.',
      3 => 'Participation in Republic Day Parade and National Integration Camps.',
    ),
  ),
  'hostel-details' => 
  array (
    'title' => 'Hostel Details',
    'category' => 'Student Life',
    'subtitle' => 'On-Campus Student Residential Facilities, Dining, Security & Amenities',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Hostel-Details.pdf',
    'description' => 'Comprehensive documentation of on-campus boys and girls hostels featuring furnished rooms, 24x7 security, dining mess, and resident warden support.',
    'highlights' => 
    array (
      0 => 'Separate hostel blocks for boys and girls with 24x7 CCTV and security personnel.',
      1 => 'Nutritious vegetarian and multi-cuisine dining hall supervised by food safety auditors.',
      2 => 'High-speed Wi-Fi connectivity, laundry services, and solar hot water facility.',
      3 => 'Resident wardens, anti-ragging squad coverage, and medical emergency transport.',
    ),
  ),
  'placement-cell' => 
  array (
    'title' => 'Placement Cell',
    'category' => 'Student Life',
    'subtitle' => 'Corporate Relations, Soft Skill Training, Internships & Campus Recruitment',
    'pdf_path' => 'assets/uploads/pdf/placement-cell.pdf',
    'description' => 'Official overview of the University Training & Placement Cell coordinating corporate tie-ups, personality enhancement workshops, mock interviews, internships, and campus recruitment drives.',
    'highlights' => 
    array (
      0 => '120+ leading corporate recruitment partners and Fortune 500 hiring tie-ups.',
      1 => 'Specialized technical aptitude, coding bootcamps, and soft skill grooming.',
      2 => 'Highest package benchmarks, average pay growth, and multi-offer opportunities.',
      3 => 'Dedicated industry internship liaison and summer project mentorship.',
    ),
  ),
  'ombudsman' => 
  array (
    'title' => 'University Ombudsman',
    'category' => 'Student Life',
    'subtitle' => 'Statutory University Ombudsman for Student Grievance Adjudication',
    'pdf_path' => 'assets/uploads/pdf/ombudsman.pdf',
    'description' => 'Official appointment, jurisdiction, and contact details of the University Ombudsman appointed in accordance with UGC grievance redressal regulations for independent adjudication.',
    'highlights' => 
    array (
      0 => 'Statutory independent appellate authority for aggrieved university students.',
      1 => 'Senior Academician / Former District Judge appointed under UGC regulations.',
      2 => 'Impartial hearing and binding recommendations on contested grievances.',
      3 => 'Guaranteed protection against victimization or unfair treatment.',
    ),
  ),
  'health-facility' => 
  array (
    'title' => 'Health Facility',
    'category' => 'Student Life',
    'subtitle' => '24x7 Campus Medical Care, On-Site Hospital & Emergency Services',
    'pdf_path' => 'assets/uploads/pdf/Health-facility.pdf',
    'description' => 'Comprehensive overview of on-campus health facilities, round-the-clock emergency medical care, qualified medical officers, pharmacy, ambulances, and association with 750+ bed teaching hospital.',
    'highlights' => 
    array (
      0 => 'Immediate on-campus primary care center with resident medical officers and nurses.',
      1 => 'Direct linkage with SRK University 750+ Bed Super-Specialty Teaching Hospital.',
      2 => '24x7 emergency response with dedicated ambulances on standby.',
      3 => 'Annual health checkups, vaccination drives, and student wellness support.',
    ),
  ),
  'sedg-cell' => 
  array (
    'title' => 'Socio Economically Disadvantaged Groups Cell (SEDG)',
    'category' => 'Student Life',
    'subtitle' => 'UGC NEP-2020 Aligned SEDG Cell for Equity & Holistic Support',
    'pdf_path' => 'assets/uploads/pdf/Socio-Economically-Disadvantaged-Groups-Cell-(SEDG).pdf',
    'description' => 'Institutional framework of the SEDG Cell constituted in alignment with National Education Policy (NEP 2020) and UGC guidelines to empower socio-economically disadvantaged students.',
    'highlights' => 
    array (
      0 => 'Institutionalized financial guidance, scholarship assistance, and fee concessions.',
      1 => 'Academic bridge courses, language development, and remedial mentoring.',
      2 => 'Psychosocial counseling and peer support networks.',
      3 => 'Special placement preparation and corporate sponsorship linkage.',
    ),
  ),
  'differently-abled-facilities' => 
  array (
    'title' => 'Facilities For Differently Abled Students',
    'category' => 'Student Life',
    'subtitle' => 'Barrier-Free Built Environment, Assistive Infrastructure & Ramps',
    'pdf_path' => 'assets/uploads/pdf/FACILITIES-FORDIFFERENTLYABLED-STUDENTS.pdf',
    'description' => 'Documentation of barrier-free campus infrastructure including wheelchair ramps, accessible elevators, tactile pathways, designated washrooms, and assistive software tools for differently-abled students.',
    'highlights' => 
    array (
      0 => 'Barrier-free architectural design with wheelchair ramps and handrails across all blocks.',
      1 => 'Elevators equipped with Braille keypads and voice announcements.',
      2 => 'Specially designed, barrier-free accessible washrooms on all academic floors.',
      3 => 'Assistive reading software, screen readers, and dedicated library seating.',
    ),
  ),
  'alumni-registration-certificate' => 
  array (
    'title' => 'Alumni Registration Certificate',
    'category' => 'Alumni',
    'subtitle' => 'Official Legal Registration Certificate of SRKU Alumni Association',
    'pdf_path' => 'assets/uploads/2025/10/new-update/AluminaiRegistrationCertificate.pdf',
    'description' => 'Official registration certificate under the Societies Registration Act legalizing the Sarvepalli Radhakrishnan University Alumni Association for global networking, student mentorship, and philanthropic contributions.',
    'highlights' => 
    array (
      0 => 'Registered under the statutory Societies Registration framework.',
      1 => 'Formal recognition of the SRKU Global Alumni Network.',
      2 => 'Governance structure, founding patrons, and executive body members.',
      3 => 'Enabling alumni chapters in Delhi, Mumbai, Bengaluru, and international hubs.',
    ),
  ),
  'alumni-bylaws' => 
  array (
    'title' => 'Alumni Bylaws & Constitution',
    'category' => 'Alumni',
    'subtitle' => 'Rules, Regulations & Code of Operations of Alumni Association',
    'pdf_path' => 'assets/uploads/2025/10/new-update/alumni.pdf',
    'description' => 'Constitution and bylaws governing membership categories, election of executive office bearers, annual general meetings, endowment funds, and outreach activities of the SRKU Alumni Association.',
    'highlights' => 
    array (
      0 => 'Membership eligibility criteria for graduates of all constituent colleges.',
      1 => 'Procedure for election of President, Vice President, Secretary, and Treasurer.',
      2 => 'Creation of student scholarship funds and industry innovation grants.',
      3 => 'Organization of annual alumni re-unions and distinguished alumni awards.',
    ),
  ),
  'alumni-committee' => 
  array (
    'title' => 'Alumni Committee',
    'category' => 'Alumni',
    'subtitle' => 'Executive Committee Members & Departmental Alumni Coordinators',
    'pdf_path' => 'assets/uploads/2025/10/new-update/Alumni-committee.pdf',
    'description' => 'Official composition of the University Alumni Committee coordinating institutional engagements, career talks, mentorship pairing, and networking forums between alumni and current scholars.',
    'highlights' => 
    array (
      0 => 'Senior faculty and distinguished alumni representing diverse faculties.',
      1 => 'Coordination of guest lectures, corporate seminars, and internship pipelines.',
      2 => 'Quarterly meetings reviewing alumni chapter expansions and initiatives.',
      3 => 'Dedicated alumni liaison desk and portal administration.',
    ),
  ),
  'rti' => 
  array (
    'title' => 'Right to Information (RTI)',
    'category' => 'Information Corner',
    'subtitle' => 'Public Information Officers, Appellate Authority & RTI Guidelines',
    'pdf_path' => 'assets/uploads/2025/10/new-update/rti.pdf',
    'description' => 'Official notification designating the Public Information Officer (PIO), Assistant Public Information Officer (APIO), and First Appellate Authority of SRKU under the Right to Information Act, 2005.',
    'highlights' => 
    array (
      0 => 'Statutory public disclosure under Section 4(1)(b) of the RTI Act 2005.',
      1 => 'Name, designation, and official contact coordinates of appointed PIO and Appellate Authority.',
      2 => 'Prescribed RTI application fee modalities and procedure for filing appeals.',
      3 => 'Commitment to institutional transparency and good governance.',
    ),
  ),
  'phd-pursuing' => 
  array (
    'title' => 'Ph.D. Scholars Pursuing',
    'category' => 'Placements & Research',
    'subtitle' => 'Comprehensive Directory of Enrolled Doctoral Research Candidates',
    'pdf_path' => 'assets/uploads/pdf/Phd-Pursuing.pdf',
    'description' => 'Public disclosure record of doctoral research scholars currently enrolled and pursuing their Doctor of Philosophy (Ph.D.) degree under approved research supervisors across academic departments.',
    'highlights' => 
    array (
      0 => 'Scholar registration details, enrolment years, and research supervisor allocations.',
      1 => 'Department-wise distribution across Engineering, Pharmacy, Management, and Sciences.',
      2 => 'Progress monitoring in accordance with UGC Minimum Standards regulations.',
      3 => 'Public compliance record for transparency in research admissions.',
    ),
  ),
  'phd-completed' => 
  array (
    'title' => 'Ph.D. Scholars Awarded / Completed',
    'category' => 'Placements & Research',
    'subtitle' => 'Official Registry of Conferred Doctor of Philosophy Degrees',
    'pdf_path' => 'assets/uploads/pdf/Phd-Completed.pdf',
    'description' => 'Official university registry of research scholars successfully awarded Doctor of Philosophy (Ph.D.) degrees upon recommendation of the external evaluation board and viva-voce examination.',
    'highlights' => 
    array (
      0 => 'Comprehensive historical list of conferred doctorate degree recipients.',
      1 => 'Research thesis titles, supervising faculty, and graduation sessions.',
      2 => 'Notification numbers and gazette references for academic verification.',
      3 => 'Benchmark scholarly output contributing to university research citations.',
    ),
  ),
  'nirf-2026' => 
  array (
    'title' => 'NIRF 2026 Institutional Report',
    'category' => 'Accreditation',
    'subtitle' => 'National Institutional Ranking Framework (NIRF) 2026 Disclosure',
    'pdf_path' => 'assets/uploads/2026/07/NIRF-2026.pdf',
    'description' => 'Official submission data and institutional disclosure submitted by Sarvepalli Radhakrishnan University to the National Institutional Ranking Framework (NIRF), Ministry of Education, Government of India.',
    'highlights' => 
    array (
      0 => 'Student strength, sanctioned intakes, and graduation outcome parameters.',
      1 => 'Faculty qualifications, student-teacher ratios, and research publications.',
      2 => 'Financial resources, capital expenditures, and operational infrastructure spends.',
      3 => 'Facilities for physically challenged students and public perception indices.',
    ),
  ),
  'vacancy' => 
  array (
    'title' => 'University Job Vacancies & Recruitment',
    'category' => 'Careers',
    'subtitle' => 'Faculty & Administrative Staff Recruitment Notification & Eligibility',
    'pdf_path' => 'assets/uploads/pdf/SRKU-Requirement-Paper.pdf',
    'description' => 'Official university recruitment announcement and employment advertisement for Professor, Associate Professor, Assistant Professor, and administrative cadre vacancies across university faculties.',
    'highlights' => 
    array (
      0 => 'Vacancies across Engineering, Pharmacy, Management, Medicine, and Law.',
      1 => 'Prescribed qualifications and pay scales as per UGC, AICTE, and state council norms.',
      2 => 'Application submission modalities, selection interview schedule, and deadlines.',
      3 => 'Equal opportunity employer offering attractive research incentives and academic growth.',
    ),
  ),
);

$aliases = array (
  'act-and-statutes' => 'act-statutes',
  'act_statutes' => 'act-statutes',
  'idp' => 'institutional-development-plan',
  'institutional_development_plan' => 'institutional-development-plan',
  'constituent-unit' => 'constituent-units',
  'constituent_units' => 'constituent-units',
  'accreditation' => 'accreditation-ranking',
  'accreditation_ranking' => 'accreditation-ranking',
  'recognition' => 'recognition-approval',
  'recognition_approval' => 'recognition-approval',
  'annual-report-2024-25' => 'annual-report',
  'annual_report' => 'annual-report',
  'details_of_sponsoring_body' => 'details-of-sponsoring-body',
  'sponsoring-body' => 'details-of-sponsoring-body',
  'eoa-report' => 'council-of-technical-education',
  'eoa-report-2020-21-1' => 'council-of-technical-education',
  'eoa_report_2020-21-1' => 'council-of-technical-education',
  'ordinance-1-to-92' => 'university-ordinance',
  'ordinance' => 'university-ordinance',
  'subsequent-ordinance-93-100' => 'ordinance-93-100',
  'subsequent-ordinance' => 'ordinance-93-100',
  'annexure-i-ugcinfo' => 'ugc-information',
  'ugc-info' => 'ugc-information',
  'officersofuniversity' => 'officers-of-university',
  'officers' => 'officers-of-university',
  'governing_body' => 'governing-body',
  'board_of_management' => 'board-of-management',
  'bom' => 'board-of-management',
  'finance_committee' => 'finance-committee',
  'academic-council' => 'academic-councils',
  'academic_council' => 'academic-councils',
  'boardofstudies' => 'board-of-studies',
  'board_of_studies' => 'board-of-studies',
  'bos' => 'board-of-studies',
  'icc' => 'internal-complaint-committee',
  'internalcomplaint-committee' => 'internal-complaint-committee',
  'internalcomplaintcommittee' => 'internal-complaint-committee',
  'bjmc' => 'bjmc-syllabus-scheme',
  'bjmc-syllabus' => 'bjmc-syllabus-scheme',
  'details-of-academic-programs' => 'details-of-academic-programmes',
  'academic-calendar-2024-25' => 'academic-calendar',
  'academic-calendar-2026-27' => 'academic-calendar',
  'statutes-ordinances' => 'statutes-ordinances-academics-examination',
  'statutes-ordinances-pertaining-to-academics-examination' => 'statutes-ordinances-academics-examination',
  'constituent-units-departments' => 'school-department-centres',
  'constituent-units-department' => 'school-department-centres',
  'constituent-units&department' => 'school-department-centres',
  'department-wise-faculty-details' => 'faculty-staff-details',
  'internal-quality-assurance-cell' => 'iqac',
  'library' => 'university-library',
  'admission-process' => 'admission-process-guidelines',
  'admission-process&guidelines' => 'admission-process-guidelines',
  'fee-refund' => 'fee-refund-policy',
  'fee-refund-policy-2024-25' => 'fee-refund-policy',
  'research-and-development-cell' => 'research-development-cell',
  'research&developmentcell' => 'research-development-cell',
  'rdc' => 'research-development-cell',
  'incubation-center' => 'incubation-centre',
  'incubation' => 'incubation-centre',
  'central-facilities-for-research-and-development' => 'central-facilities-research',
  'constitution-of-ethics-board' => 'ethics-board',
  'admission-policy-for-ph-d-programme' => 'phd-admission-policy',
  'admission-policy-for-phd-programme' => 'phd-admission-policy',
  'research-advisory-committee' => 'constitution-of-research-advisory-committee',
  'rac' => 'constitution-of-research-advisory-committee',
  'details-about-ph-d-scholars-currently-enrolled' => 'phd-scholars-currently-enrolled',
  'details-about-phd-scholars-currently-enrolled' => 'phd-scholars-currently-enrolled',
  'phd-scholars-pursuing' => 'phd-scholars-currently-enrolled',
  'sports' => 'sports-facilities',
  'ncc-nss-details' => 'ncc-nss',
  'hostel' => 'hostel-details',
  'placement' => 'placement-cell',
  'student-grievance' => 'student-grievance-committee',
  'health' => 'health-facility',
  'anti-ragging-committee' => 'anti-ragging',
  'anti-ragging-committe' => 'anti-ragging',
  'equal-opportunity' => 'equal-opportunity-cell',
  'sedg' => 'sedg-cell',
  'sedg-cell' => 'sedg-cell',
  'socio-economically-disadvantaged-groups-cell-sedg' => 'sedg-cell',
  'socio-economically-disadvantaged-groups-cell' => 'sedg-cell',
  'socio-economically-disadvantaged-groups-cell-(sedg)' => 'sedg-cell',
  'facilities-for-differently-abled-students' => 'differently-abled-facilities',
  'facilities-for-differently-abled--students' => 'differently-abled-facilities',
  'alumni-registration-certificate' => 'alumni-registration-certificate',
  'aluminai-registration-certificate' => 'alumni-registration-certificate',
  'alumni-registration-certificat' => 'alumni-registration-certificate',
  'alumni-bylaws' => 'alumni-bylaws',
  'right-to-information' => 'rti',
  'ph-d-pursuing' => 'phd-pursuing',
  'ph-d-completed' => 'phd-completed',
  'phd-scholars-completed' => 'phd-completed',
  'nirf' => 'nirf-2026',
  'careers' => 'vacancy',
  'requirement-paper' => 'vacancy',
);

// ═══════════════════════════════════════════════════════
// MULTI-TIER DOCUMENT RESOLUTION ENGINE
// ═══════════════════════════════════════════════════════
$doc = null;
$cleanSlug = strtolower(trim($slug));
// Normalize dashes, spaces, underscores
$normKey = preg_replace('/[^a-z0-9]+/', '-', $cleanSlug);
$normKey = trim($normKey, '-');

// 1. Check direct registry match
if (!empty($slug) && isset($documentsRegistry[$slug])) {
    $doc = $documentsRegistry[$slug];
} elseif (!empty($normKey) && isset($documentsRegistry[$normKey])) {
    $doc = $documentsRegistry[$normKey];
    $slug = $normKey;
}

// 2. Check alias map
if (!$doc && !empty($normKey) && isset($aliases[$normKey])) {
    $targetSlug = $aliases[$normKey];
    if (isset($documentsRegistry[$targetSlug])) {
        $doc = $documentsRegistry[$targetSlug];
        $slug = $targetSlug;
    }
}

// 3. Check case-insensitive & fuzzy match in registry
if (!$doc && !empty($normKey)) {
    foreach ($documentsRegistry as $k => $item) {
        $cleanK = strtolower(preg_replace('/[^a-z0-9]+/', '-', $k));
        if ($cleanK === $normKey || strpos($cleanK, $normKey) !== false || strpos($normKey, $cleanK) !== false) {
            $doc = $item;
            $slug = $k;
            break;
        }
    }
}

// 4. Check Database `pages` table
if (!$doc && !empty($slug)) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = :s OR slug = :norm LIMIT 1");
        $stmt->execute([':s' => $slug, ':norm' => $normKey]);
        $pRow = $stmt->fetch();
        if ($pRow && !empty($pRow['banner_img']) && preg_match('/\.pdf$/i', $pRow['banner_img'])) {
            $doc = [
                'title' => $pRow['title'],
                'category' => 'Official Document',
                'subtitle' => !empty($pRow['banner_subtitle']) ? $pRow['banner_subtitle'] : (!empty($pRow['banner_title']) ? $pRow['banner_title'] : $pRow['title']),
                'pdf_path' => $pRow['banner_img'],
                'description' => !empty($pRow['meta_description']) ? $pRow['meta_description'] : strip_tags($pRow['content']),
                'highlights' => []
            ];
        }
    } catch (Exception $e) {}
}

// 5. Match by fileParam
if (!$doc && !empty($fileParam)) {
    $searchBase = basename($fileParam);
    foreach ($documentsRegistry as $k => $item) {
        if (basename($item['pdf_path']) === $searchBase || $item['pdf_path'] === $fileParam) {
            $doc = $item;
            $slug = $k;
            break;
        }
    }
    if (!$doc) {
        $cleanTitle = ucwords(str_replace(['-', '_', '.pdf', '%20'], ' ', $searchBase));
        $doc = [
            'title' => $cleanTitle,
            'category' => 'University Document',
            'subtitle' => 'Official University Publication & Information Document',
            'pdf_path' => $fileParam,
            'description' => 'Official published document of Sarvepalli Radhakrishnan University (SRKU), Bhopal for student and faculty reference.',
            'highlights' => [
                'Official publication approved by university authorities.',
                'Prescribed format, guidelines, and compliance records.',
                'Available for public reference and direct download.'
            ]
        ];
    }
}

// 6. Dynamic Disk Search across assets/uploads/
if (!$doc && !empty($normKey)) {
    $searchDirs = [
        __DIR__ . '/assets/uploads/2025/10/new-update/',
        __DIR__ . '/assets/uploads/2025/allCommittee/',
        __DIR__ . '/assets/uploads/2026/07/',
        __DIR__ . '/assets/uploads/phd/',
        __DIR__ . '/assets/uploads/2025/nirf/',
        __DIR__ . '/assets/uploads/2023/09/',
        __DIR__ . '/assets/uploads/2023/05/',
        __DIR__ . '/assets/uploads/2024/07/',
        __DIR__ . '/assets/uploads/pdf/',
        __DIR__ . '/assets/uploads/'
    ];

    $normSlugWord = preg_replace('/[^a-z0-9]/', '', $normKey);
    foreach ($searchDirs as $dir) {
        if (!is_dir($dir)) continue;
        $files = scandir($dir);
        foreach ($files as $file) {
            if (!preg_match('/\.pdf$/i', $file)) continue;
            $normFileWord = preg_replace('/[^a-z0-9]/', '', strtolower($file));
            if ($normFileWord === $normSlugWord || strpos($normFileWord, $normSlugWord) !== false || strpos($normSlugWord, $normFileWord) !== false) {
                $cleanTitle = ucwords(str_replace(['-', '_', '.pdf', '%20'], ' ', $file));
                $relPath = str_replace(__DIR__ . '/', '', $dir . $file);
                $doc = [
                    'title' => $cleanTitle,
                    'category' => 'Official Document',
                    'subtitle' => 'Official University Document & Public Disclosure',
                    'pdf_path' => $relPath,
                    'description' => 'Official document and notification published by Sarvepalli Radhakrishnan University (SRKU), Bhopal.',
                    'highlights' => []
                ];
                break 2;
            }
        }
    }
}

if (!$doc) {
    $doc = reset($documentsRegistry);
    $slug = key($documentsRegistry);
}

$pageTitle = sanitize($doc['title']) . " | Official University Document & PDF | SRKU Bhopal";
$pageDesc = sanitize($doc['description']);
$pageKeywords = sanitize($doc['title']) . ", SRKU PDF, Official Document SRKU Bhopal, " . sanitize($doc['category']);
$activeNav = strtolower($doc['category']);
require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner Header -->
<?php renderPageBanner('document-view', $doc['title'], $doc['subtitle']); ?>

<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm border mb-0">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-navy text-decoration-none"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><span class="text-muted"><?php echo sanitize($doc['category']); ?></span></li>
                <li class="breadcrumb-item active text-danger fw-bold" aria-current="page"><?php echo sanitize($doc['title']); ?></li>
            </ol>
        </nav>

        <!-- Top Action Callout Banner -->
        <div class="card p-4 p-lg-5 border-0 shadow rounded-4 text-white mb-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #7A0B0D 0%, #16233f 100%);">
            <div class="row align-items-center g-4 position-relative z-2">
                <div class="col-12 col-lg-8">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="fas fa-file-pdf me-1"></i> <?php echo sanitize($doc['category']); ?> Official Document
                    </span>
                    <h2 class="h2 fw-bold text-white mb-3"><?php echo sanitize($doc['title']); ?></h2>
                    <p class="text-white-50 mb-4" style="line-height: 1.7; font-size: 0.98rem;">
                        <?php echo sanitize($doc['description']); ?>
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" download class="btn btn-warning text-dark fw-bold px-4 py-3 rounded-pill shadow">
                            <i class="fas fa-download me-2"></i> Download Official PDF
                        </a>
                        <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" target="_blank" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill">
                            <i class="fas fa-external-link-alt me-2"></i> View PDF Fullscreen
                        </a>
                        <a href="#pdf-viewer" class="btn btn-light text-navy fw-bold px-4 py-3 rounded-pill">
                            <i class="fas fa-eye me-2"></i> In-Page Preview
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-4 rounded-4 bg-white text-navy shadow-sm">
                        <h6 class="fw-bold text-navy mb-3"><i class="fas fa-info-circle text-danger me-2"></i> Document Information</h6>
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Type:</span>
                                <strong class="text-navy">Official PDF File</strong>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Category:</span>
                                <strong class="text-navy"><?php echo sanitize($doc['category']); ?></strong>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Compliance:</span>
                                <strong class="text-success">UGC / Regulatory Norms</strong>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Status:</span>
                                <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold">Active &amp; Verified</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 g-lg-5 mb-5">
            
            <!-- Left Column: Interactive PDF Viewer -->
            <div class="col-12 col-lg-8">
                
                <!-- PDF Preview Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-4" id="pdf-viewer">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <div>
                            <span class="section-subtitle"><i class="fas fa-file-pdf text-danger me-1"></i> DOCUMENT VIEWER</span>
                            <h3 class="h4 fw-bold text-navy mb-0"><?php echo sanitize($doc['title']); ?></h3>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" download class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
                                <i class="fas fa-download me-1"></i> Download PDF
                            </a>
                            <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" target="_blank" class="btn btn-sm btn-outline-navy rounded-pill px-3 fw-bold">
                                <i class="fas fa-external-link-alt me-1"></i> Fullscreen
                            </a>
                        </div>
                    </div>

                    <div class="ratio ratio-4x3 border rounded-4 overflow-hidden shadow-sm bg-light" style="min-height: 600px;">
                        <iframe src="<?php echo BASE_URL . $doc['pdf_path']; ?>#toolbar=1" class="w-100 h-100" style="border:none;" title="<?php echo sanitize($doc['title']); ?>">
                            <p class="p-4 text-center text-muted">
                                Your browser does not support embedded PDF viewing. 
                                <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" target="_blank" class="btn btn-danger btn-sm ms-2">Click here to download and view the PDF.</a>
                            </p>
                        </iframe>
                    </div>
                </div>

                <?php if (!empty($doc['highlights'])): ?>
                <!-- Key Highlights Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h4 class="fw-bold text-navy mb-3"><i class="fas fa-check-circle text-success me-2"></i> Key Document Highlights</h4>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                        <?php foreach ($doc['highlights'] as $highlight): ?>
                            <li class="d-flex align-items-start gap-3">
                                <i class="fas fa-arrow-circle-right text-danger mt-1"></i>
                                <span class="text-secondary"><?php echo sanitize($highlight); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

            </div>

            <!-- Right Sidebar: Contact Desk & Related Documents -->
            <div class="col-12 col-lg-4">
                
                <!-- University Office Card -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-university text-danger me-2"></i> University Desk</h5>
                    <p class="text-muted small mb-3">
                        For questions, authentication, or queries regarding university regulations, circulars, or admissions:
                    </p>
                    <div class="p-3 rounded-3 bg-light border small text-muted mb-3">
                        <strong class="text-navy d-block mb-1">Sarvepalli Radhakrishnan University</strong>
                        NH-12, Hoshangabad Road, Misrod,<br>
                        Bhopal, Madhya Pradesh - 462026
                    </div>
                    <div class="d-flex flex-column gap-2 small">
                        <a href="tel:7024144981" class="text-decoration-none text-navy fw-semibold p-2 rounded-3 bg-light border d-flex align-items-center">
                            <i class="fas fa-phone-alt text-danger me-2"></i> University Helpline: 7024144981
                        </a>
                        <a href="mailto:info@srku.edu.in" class="text-decoration-none text-navy fw-semibold p-2 rounded-3 bg-light border d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-2"></i> info@srku.edu.in
                        </a>
                    </div>
                </div>

                <!-- Related Documents in this category -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-folder-open text-warning me-2"></i> Related Documents</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                        <?php 
                        $count = 0;
                        foreach ($documentsRegistry as $k => $item): 
                            if ($k === $slug) continue;
                            if ($item['category'] === $doc['category'] || $count < 4):
                                $count++;
                        ?>
                            <li>
                                <a href="<?php echo BASE_URL; ?>document/<?php echo $k; ?>" class="text-decoration-none text-navy d-flex align-items-center justify-content-between p-2 rounded-2 hover-bg-light">
                                    <span class="text-truncate me-2"><i class="fas fa-file-pdf text-danger me-2"></i><?php echo sanitize($item['title']); ?></span>
                                    <i class="fas fa-chevron-right text-muted small"></i>
                                </a>
                            </li>
                        <?php 
                            endif;
                            if ($count >= 6) break;
                        endforeach; 
                        ?>
                    </ul>
                </div>

            </div>

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>