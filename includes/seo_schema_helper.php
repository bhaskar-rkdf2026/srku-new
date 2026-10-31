<?php
/**
 * Educational Sector SEO & Structured Data (Schema.org) Engine
 * Designed for Sarvepalli Radhakrishnan University (SRKU), Bhopal & Constituent Colleges
 * 
 * Features:
 * 1. Multi-College Educational Hierarchy (Apex University + 28 Constituent Units)
 * 2. Official Google Rich Results Schemas: CollegeOrUniversity, Course, BreadcrumbList, WebSite, FAQPage
 * 3. Meta-Attack & Canonical Poisoning Defense (Parameter filtering, XSS prevention, clean URLs)
 */

if (!function_exists('buildSecureCanonicalUrl')) {
    /**
     * Resolves a strictly poison-proof, clean canonical URL.
     * Strips all untrusted query parameters (utm_*, ref, s, casino, etc.)
     * Only preserves sanctioned routing parameters (slug, course, id, page).
     */
    function buildSecureCanonicalUrl($rawCanonical = '', $pageIdentifier = '') {
        $baseUrl = defined('BASE_URL') ? rtrim(BASE_URL, '/') : 'https://srku.edu.in';
        
        // If raw canonical is explicitly configured in DB, adapt it safely
        if (!empty($rawCanonical)) {
            if (preg_match('#^https?://(localhost|127\.0\.0\.1)(:\d+)?(/srku-new)?(/.*)?$#i', $rawCanonical, $m)) {
                $pathPart = isset($m[4]) ? ltrim($m[4], '/') : '';
                return $baseUrl . '/' . $pathPart;
            } elseif (!preg_match('#^https?://#i', $rawCanonical)) {
                return $baseUrl . '/' . ltrim($rawCanonical, '/');
            }
            return $rawCanonical;
        }

        $script = basename($_SERVER['PHP_SELF'] ?? 'index.php');
        
        // Homepage canonical is ALWAYS pure domain root without index.php or query params
        if ($script === 'index.php' || $script === '') {
            return $baseUrl . '/';
        }

        // Whitelisted query parameters that legitimately change page content
        $allowedParams = ['slug', 'course', 'id', 'page', 'category'];
        $cleanParams = [];
        
        if (!empty($_GET)) {
            foreach ($allowedParams as $paramKey) {
                if (isset($_GET[$paramKey]) && is_string($_GET[$paramKey])) {
                    $val = preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $_GET[$paramKey]);
                    if ($val !== '') {
                        $cleanParams[$paramKey] = $val;
                    }
                }
            }
        }

        $url = $baseUrl . '/' . $script;
        if (!empty($cleanParams)) {
            $url .= '?' . http_build_query($cleanParams);
        }

        return $url;
    }
}

if (!function_exists('generateEducationalSchemas')) {
    /**
     * Builds comprehensive Google Rich Snippet & AEO structured data graphs
     */
    function generateEducationalSchemas($pageIdentifier, $seoResolved = []) {
        $baseUrl = defined('BASE_URL') ? rtrim(BASE_URL, '/') : 'https://srku.edu.in';
        $logoUrl = $baseUrl . '/assets/uploads/2026/07/SRK-logo.webp';
        $campusImg = $baseUrl . '/assets/uploads/2026/07/campus-1.webp';
        $canonical = $seoResolved['canonical'] ?? ($baseUrl . '/');

        $graph = [];

        // ══════════════════════════════════════════════════════════════════
        // 1. APEX UNIVERSITY SCHEMA (CollegeOrUniversity)
        // ══════════════════════════════════════════════════════════════════
        $universitySchema = [
            '@type' => 'CollegeOrUniversity',
            '@id' => $baseUrl . '/#university',
            'name' => 'Sarvepalli Radhakrishnan University',
            'alternateName' => ['SRKU', 'SRK University', 'SRKU Bhopal'],
            'url' => $baseUrl . '/',
            'logo' => $logoUrl,
            'image' => $campusImg,
            'description' => 'Sarvepalli Radhakrishnan University (SRKU), Bhopal is a premier multidisciplinary private university in Madhya Pradesh established under Section 2(f) of the UGC Act 1956 and recognized by UGC, AICTE, NMC, PCI, INC, BCI, DCI, NCISM, and NCH.',
            'foundingDate' => '1995',
            'parentOrganization' => [
                '@type' => 'EducationalOrganization',
                'name' => 'RKDF Education Society',
                'url' => $baseUrl . '/'
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'NH-12, Hoshangabad Road, Jatkhedi, Misrod',
                'addressLocality' => 'Bhopal',
                'addressRegion' => 'Madhya Pradesh',
                'postalCode' => '462026',
                'addressCountry' => 'IN'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => 23.1685,
                'longitude' => 77.4682
            ],
            'telephone' => '+91-755-4911204',
            'email' => 'info@srku.edu.in',
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'telephone' => '+91-7024144981',
                    'contactType' => 'Admissions Desk',
                    'areaServed' => 'IN',
                    'availableLanguage' => ['English', 'Hindi']
                ],
                [
                    '@type' => 'ContactPoint',
                    'telephone' => '+91-755-4911204',
                    'contactType' => 'Examination Cell',
                    'email' => 'exam@srku.edu.in',
                    'areaServed' => 'IN'
                ],
                [
                    '@type' => 'ContactPoint',
                    'email' => 'registrar@srku.edu.in',
                    'contactType' => 'Registrar Office',
                    'areaServed' => 'IN'
                ]
            ],
            'hasCredential' => [
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'UGC 2(f) Statutory Recognition'],
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'AICTE Approved Engineering & Technology'],
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'NMC Recognized Medical College (MBBS & MD/MS)'],
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'PCI Approved Pharmacy Education'],
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'INC Approved Nursing Programs'],
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'BCI Approved Legal Studies (BA.LL.B, LL.B, LL.M)'],
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'DCI Approved Dental Sciences (BDS, MDS)'],
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'NCISM Approved Ayurvedic Medicine (BAMS)'],
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'NCH Approved Homoeopathic Medicine (BHMS)'],
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'NAAC & MPPURC Accredited State Private University']
            ],
            'sameAs' => [
                'https://www.facebook.com/',
                'https://www.instagram.com/',
                'https://www.linkedin.com/',
                'https://www.youtube.com/'
            ]
        ];

        // Fetch Constituent Departments/Colleges to establish multi-college hierarchy
        try {
            $pdo = getDBConnection();
            $deptRows = $pdo->query("SELECT name, slug, established_year, category FROM departments WHERE status = 'active' ORDER BY name ASC LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($deptRows)) {
                $subColleges = [];
                foreach ($deptRows as $d) {
                    $subColleges[] = [
                        '@type' => 'EducationalOrganization',
                        'name' => $d['name'],
                        'url' => $baseUrl . '/department-detail.php?slug=' . urlencode($d['slug']),
                        'description' => "Constituent college of Sarvepalli Radhakrishnan University specializing in " . ($d['category'] ?: 'Higher Education')
                    ];
                }
                $universitySchema['department'] = $subColleges;
            }
        } catch (Exception $e) {}

        $graph[] = $universitySchema;

        // ══════════════════════════════════════════════════════════════════
        // 2. WEBSITE & SITELINKS SEARCHACTION (Homepage)
        // ══════════════════════════════════════════════════════════════════
        $isHome = (basename($_SERVER['PHP_SELF'] ?? '') === 'index.php');
        if ($isHome) {
            $graph[] = [
                '@type' => 'WebSite',
                '@id' => $baseUrl . '/#website',
                'url' => $baseUrl . '/',
                'name' => 'Sarvepalli Radhakrishnan University (SRKU)',
                'publisher' => ['@id' => $baseUrl . '/#university'],
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => [
                        '@type' => 'EntryPoint',
                        'urlTemplate' => $baseUrl . '/courses.php?search={search_term_string}'
                    ],
                    'query-input' => 'required name=search_term_string'
                ]
            ];
        }

        // ══════════════════════════════════════════════════════════════════
        // 3. CONSTITUENT COLLEGE / DEPARTMENT SCHEMA (Department Detail)
        // ══════════════════════════════════════════════════════════════════
        $script = basename($_SERVER['PHP_SELF'] ?? '');
        if ($script === 'department-detail.php' && !empty($_GET['slug'])) {
            try {
                $pdo = getDBConnection();
                $slug = preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['slug']);
                $stmt = $pdo->prepare("SELECT * FROM departments WHERE slug = :s LIMIT 1");
                $stmt->execute([':s' => $slug]);
                $dept = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($dept) {
                    $collegeSchema = [
                        '@type' => 'EducationalOrganization',
                        '@id' => $canonical . '#college',
                        'name' => $dept['name'],
                        'url' => $canonical,
                        'parentOrganization' => ['@id' => $baseUrl . '/#university'],
                        'description' => !empty($dept['description']) ? strip_tags(mb_substr($dept['description'], 0, 300)) . '...' : "Constituent college of Sarvepalli Radhakrishnan University, Bhopal.",
                        'foundingDate' => !empty($dept['established_year']) ? (string)$dept['established_year'] : '1995',
                        'telephone' => !empty($dept['contact_no']) ? $dept['contact_no'] : '+91-755-4911204',
                        'address' => [
                            '@type' => 'PostalAddress',
                            'streetAddress' => 'NH-12, Hoshangabad Road, Misrod',
                            'addressLocality' => 'Bhopal',
                            'addressRegion' => 'Madhya Pradesh',
                            'postalCode' => '462026',
                            'addressCountry' => 'IN'
                        ]
                    ];

                    if (!empty($dept['dean_name'])) {
                        $collegeSchema['leader'] = [
                            '@type' => 'Person',
                            'name' => $dept['dean_name'],
                            'jobTitle' => !empty($dept['dean_designation']) ? $dept['dean_designation'] : 'Dean / Principal'
                        ];
                    }

                    // Connected Courses in OfferCatalog
                    $stmtC = $pdo->prepare("SELECT course_name, slug, degree_level, duration FROM courses WHERE dept_slug = :ds OR department LIKE :dn LIMIT 15");
                    $stmtC->execute([':ds' => $slug, ':dn' => '%' . $dept['name'] . '%']);
                    $deptCourses = $stmtC->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($deptCourses)) {
                        $offers = [];
                        foreach ($deptCourses as $dc) {
                            $offers[] = [
                                '@type' => 'Course',
                                'name' => $dc['course_name'],
                                'url' => $baseUrl . '/course-detail.php?slug=' . urlencode($dc['slug']),
                                'timeRequired' => $dc['duration'] ?: 'P3Y'
                            ];
                        }
                        $collegeSchema['hasOfferCatalog'] = [
                            '@type' => 'OfferCatalog',
                            'name' => 'Academic Courses & Degrees',
                            'itemListElement' => $offers
                        ];
                    }

                    $graph[] = $collegeSchema;
                }
            } catch (Exception $e) {}
        }

        // ══════════════════════════════════════════════════════════════════
        // 4. COURSE SCHEMA (Course Detail Page)
        // ══════════════════════════════════════════════════════════════════
        if ($script === 'course-detail.php' && !empty($_GET['slug'])) {
            try {
                $pdo = getDBConnection();
                $slug = preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['slug']);
                $stmt = $pdo->prepare("SELECT * FROM courses WHERE slug = :s LIMIT 1");
                $stmt->execute([':s' => $slug]);
                $c = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($c) {
                    $courseSchema = [
                        '@type' => 'Course',
                        '@id' => $canonical . '#course',
                        'name' => $c['course_name'],
                        'url' => $canonical,
                        'description' => !empty($c['description']) ? strip_tags(mb_substr($c['description'], 0, 300)) . '...' : "Admissions open for " . $c['course_name'] . " at Sarvepalli Radhakrishnan University, Bhopal.",
                        'provider' => ['@id' => $baseUrl . '/#university'],
                        'educationalCredentialAwarded' => $c['course_name'] . ' Degree / Diploma',
                        'occupationalCredentialAwarded' => !empty($c['career_scope']) ? strip_tags(mb_substr($c['career_scope'], 0, 150)) : 'Professional Industry Role',
                        'hasCourseInstance' => [
                            '@type' => 'CourseInstance',
                            'courseMode' => 'Full-Time',
                            'courseWorkload' => !empty($c['duration']) ? $c['duration'] : 'Full Academic Term',
                            'instructor' => [
                                '@type' => 'EducationalOrganization',
                                'name' => !empty($c['department']) ? $c['department'] : 'Sarvepalli Radhakrishnan University'
                            ]
                        ]
                    ];
                    $graph[] = $courseSchema;
                }
            } catch (Exception $e) {}
        }

        // ══════════════════════════════════════════════════════════════════
        // 5. BREADCRUMBLIST SCHEMA (Universal on all pages)
        // ══════════════════════════════════════════════════════════════════
        $breadcrumbs = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => $baseUrl . '/'
            ]
        ];

        $pageTitleClean = !empty($seoResolved['title']) ? explode('|', $seoResolved['title'])[0] : 'University Page';
        $pageTitleClean = trim(strip_tags($pageTitleClean));

        if (!$isHome) {
            $sectionName = 'Academics';
            $sectionUrl = $baseUrl . '/courses.php';

            if (strpos($script, 'department') !== false || strpos($script, 'constituent') !== false) {
                $sectionName = 'Colleges & Departments';
                $sectionUrl = $baseUrl . '/departments.php';
            } elseif (strpos($script, 'admission') !== false || strpos($script, 'phd') !== false) {
                $sectionName = 'Admissions';
                $sectionUrl = $baseUrl . '/admissions.php';
            } elseif (strpos($script, 'about') !== false || strpos($script, 'vision') !== false || strpos($script, 'chancellor') !== false) {
                $sectionName = 'About SRKU';
                $sectionUrl = $baseUrl . '/about.php';
            } elseif (strpos($script, 'exam') !== false || strpos($script, 'syllabus') !== false) {
                $sectionName = 'Examinations & Syllabi';
                $sectionUrl = $baseUrl . '/examinations.php';
            } elseif (strpos($script, 'placement') !== false) {
                $sectionName = 'Placements';
                $sectionUrl = $baseUrl . '/placements.php';
            }

            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $sectionName,
                'item' => $sectionUrl
            ];

            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $pageTitleClean,
                'item' => $canonical
            ];
        }

        $graph[] = [
            '@type' => 'BreadcrumbList',
            '@id' => $canonical . '#breadcrumb',
            'itemListElement' => $breadcrumbs
        ];

        // ══════════════════════════════════════════════════════════════════
        // 6. FAQPAGES SCHEMA (Admissions, Examinations, PhD)
        // ══════════════════════════════════════════════════════════════════
        $isFaqPage = in_array($script, ['admission-enquiry.php', 'admissions.php', 'phd-admission.php', 'exam-time-table.php', 'index.php']);
        if ($isFaqPage) {
            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $canonical . '#faq',
                'mainEntity' => [
                    [
                        '@type' => 'Question',
                        'name' => 'Is Sarvepalli Radhakrishnan University (SRKU) approved by UGC?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'Yes, Sarvepalli Radhakrishnan University (SRKU), Bhopal is a statutory university established under the MP Niji Vishwavidyalaya Adhiniyam 2007 and recognized under Section 2(f) of the University Grants Commission (UGC) Act 1956. All degrees awarded are valid across India and globally.'
                        ]
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'What statutory professional accreditations does SRKU hold?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'SRKU holds apex regulatory approvals including All India Council for Technical Education (AICTE), National Medical Commission (NMC), Pharmacy Council of India (PCI), Indian Nursing Council (INC), Bar Council of India (BCI), Dental Council of India (DCI), and NCISM/NCH for Ayush programmes.'
                        ]
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'What is the admission procedure for Academic Session 2026-27?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'Admissions for 2026-27 are open online through the official portal (https://srku.edu.in/). Candidates can submit their application online, pay fees, or visit the University Admissions Cell on Hoshangabad Road, Bhopal. Helpline numbers: 7024144981, 0755-4911204.'
                        ]
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Are government and merit scholarships available at SRKU?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'Yes, SRKU facilitates Central and State Government scholarships for SC, ST, OBC, and minority students (including MP Post-Matric Scholarship). Additionally, the university awards merit scholarships and AICTE Pragati & Saksham schemes.'
                        ]
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Does SRKU provide hostel and transportation facilities in Bhopal?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'Yes, SRKU provides comprehensive residential hostels with separate blocks for boys and girls, 24/7 security, Wi-Fi, mess, gymnasium, and a dedicated fleet of university buses connecting all major nodes across Bhopal, Sehore, and Mandideep.'
                        ]
                    ]
                ]
            ];
        }

        // Return combined @graph structure
        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph
        ];
    }
}

