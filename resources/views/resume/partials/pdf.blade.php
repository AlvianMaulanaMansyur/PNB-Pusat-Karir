<?php
// Fungsi helper untuk format tanggal
function formatDate($date)
{
    return $date ? date('M Y', strtotime($date)) : '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Resume - <?= $resumeData['personal_details']['name'] ?? 'Your Name' ?></title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .header-container {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .header-left {
            text-align: center;
            margin-bottom: 15px;
        }

        .header-name {
            font-size: 32px;
            font-weight: 800;
            color: #111827;
            line-height: 1.2;
            margin-bottom: 5px;
        }

        .header-contact {
            font-size: 14px;
            color: #4b5563;
        }

        .header-divider {
            margin: 0 8px;
            color: #d1d5db;
        }

        .header-link {
            color: #2563eb;
            text-decoration: none;
            display: block;
            margin-top: 3px;
        }

        .profile-photo-container {
            text-align: center;
            margin-top: 10px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }

        /* Section Styles */
        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #3b82f6;
        }

        /* Item Styles */
        .item {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .item-title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }

        .item-date {
            font-size: 14px;
            color: #6b7280;
        }

        .item-subtitle {
            font-size: 16px;
            font-weight: 500;
            color: #4b5563;
        }

        .item-location {
            font-size: 14px;
            color: #6b7280;
            font-style: italic;
            margin-bottom: 8px;
        }

        .item-description {
            font-size: 14px;
            color: #4b5563;
            margin-top: 8px;
        }

        /* Skills Styles */
        .skills-container {
            margin-top: 15px;
        }

        .skill-category {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin: 15px 0 8px;
        }

        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }

        .skill-tag {
            background-color: #dbeafe;
            color: #1e40af;
            font-size: 13px;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .skill-tag.green {
            background-color: #dcfce7;
            color: #166534;
        }

        .skill-tag.purple {
            background-color: #f3e8ff;
            color: #7e22ce;
        }

        .skill-tag.gray {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        /* Link Styles */
        .project-links {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 8px;
        }

        .project-link {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
        }

        /* Utilities */
        .mb-3 {
            margin-bottom: 15px;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .text-sm {
            font-size: 14px;
        }

        .prose ul {
            list-style-type: disc;
            padding-left: 20px;
            margin-top: 8px;
        }

        .prose li {
            margin-bottom: 5px;
        }

        @media (min-width: 768px) {
            .header-container {
                flex-direction: row;
                justify-content: space-between;
                align-items: flex-start;
            }

            .header-left {
                text-align: left;
                margin-bottom: 0;
            }

            .profile-photo-container {
                margin-top: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section: Name, Contact, Photo -->
        <div class="header-container">
            <div class="header-left">
                <h1 class="header-name">
                    <?= htmlspecialchars($resumeData['personal_details']['name'] ?? 'Your Name') ?>
                </h1>
                <p class="header-contact">
                    <?= htmlspecialchars($resumeData['personal_details']['email'] ?? 'email@example.com') ?>
                    <?php if (!empty($resumeData['personal_details']['phone'])): ?>
                    <span class="header-divider">|</span>
                    <?= htmlspecialchars($resumeData['personal_details']['phone']) ?>
                    <?php endif; ?>
                </p>
                <?php if (!empty($resumeData['personal_details']['address'])): ?>
                <p class="header-contact">
                    <?= htmlspecialchars($resumeData['personal_details']['address']) ?>
                </p>
                <?php endif; ?>
                <?php if (!empty($resumeData['personal_details']['linkedin_url'])): ?>
                <a href="<?= htmlspecialchars($resumeData['personal_details']['linkedin_url']) ?>" class="header-link">
                    LinkedIn Profile
                </a>
                <?php endif; ?>
                <?php if (!empty($resumeData['personal_details']['github_url'])): ?>
                <a href="<?= htmlspecialchars($resumeData['personal_details']['github_url']) ?>" class="header-link">
                    GitHub Profile
                </a>
                <?php endif; ?>
                <?php if (!empty($resumeData['personal_details']['portfolio_url'])): ?>
                <a href="<?= htmlspecialchars($resumeData['personal_details']['portfolio_url']) ?>" class="header-link">
                    Portfolio
                </a>
                <?php endif; ?>
            </div>
            <?php if (!empty($profilePhotoUrl)): ?>
            <div class="profile-photo-container">
                <img src="<?= $profilePhotoUrl ?>" alt="Profile Photo" class="profile-img">
            </div>
            <?php endif; ?>
        </div>

        <!-- Summary -->
        <?php if (!empty($resumeData['personal_details']['summary'])): ?>
        <section class="section">
            <h3 class="section-title">Summary</h3>
            <p class="item-description">
                <?= htmlspecialchars($resumeData['personal_details']['summary']) ?>
            </p>
        </section>
        <?php endif; ?>

        <!-- Experience -->
        <?php if (!empty($resumeData['experiences'])): ?>
        <section class="section">
            <h3 class="section-title">Experience</h3>
            <?php foreach ($resumeData['experiences'] as $experience): ?>
            <div class="item">
                <div class="item-header">
                    <h4 class="item-title">
                        <?= htmlspecialchars($experience['title'] ?? 'Untitled Position') ?>
                    </h4>
                    <span class="item-date">
                        <?= formatDate($experience['start_date'] ?? '') ?> -
                        <?= !empty($experience['is_current']) ? 'Present' : formatDate($experience['end_date'] ?? '') ?>
                    </span>
                </div>
                <p class="item-subtitle">
                    <?= htmlspecialchars($experience['company'] ?? 'Unknown Company') ?>
                </p>
                <?php if (!empty($experience['location'])): ?>
                <p class="item-location">
                    <?= htmlspecialchars($experience['location']) ?>
                </p>
                <?php endif; ?>
                <?php if (!empty($experience['description'])): ?>
                <div class="item-description prose">
                    <?= $experience['description']
// Jika mengandung HTML, gunakan htmlspecialchars jika perlu
?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <!-- Education -->
        <?php if (!empty($resumeData['educations'])): ?>
        <section class="section">
            <h3 class="section-title">Education</h3>
            <?php foreach ($resumeData['educations'] as $education): ?>
            <div class="item">
                <div class="item-header">
                    <h4 class="item-title">
                        <?= htmlspecialchars($education['degree'] ?? 'N/A') ?>
                        <?php if ($education['field_of_study']): ?>
                        <span> in <?= htmlspecialchars($education['field_of_study']) ?></span>
                        <?php endif; ?>
                    </h4>
                    <span class="item-date">
                        <?= formatDate($education['start_date'] ?? '') ?> -
                        <?= !empty($education['is_current']) ? 'Present' : formatDate($education['end_date'] ?? '') ?>
                    </span>
                </div>
                <p class="item-subtitle">
                    <?= htmlspecialchars($education['institution'] ?? 'N/A') ?>
                </p>
                <?php if (isset($education['gpa']) && $education['gpa']): ?>
                <p class="text-sm mt-2">GPA: <?= htmlspecialchars($education['gpa']) ?></p>
                <?php endif; ?>
                <?php if (!empty($education['description'])): ?>
                <div class="item-description prose">
                    <?= $education['description'] ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <!-- Skills -->
        <?php if (!empty($resumeData['skills'])): ?>
        <section class="section">
            <h3 class="section-title">Skills</h3>
            <div class="skills-container">
                <?php if (!empty($resumeData['skills']['technical_skills'])): ?>
                <h4 class="skill-category">Technical Skills</h4>
                <div class="skills-list">
                    <?php foreach ($resumeData['skills']['technical_skills'] as $skill): ?>
                    <span class="skill-tag">
                        <?= htmlspecialchars($skill['name']) ?>
                        <?php if (!empty($skill['level'])): ?>
                        (<?= htmlspecialchars($skill['level']) ?>)
                        <?php endif; ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($resumeData['skills']['soft_skills'])): ?>
                <h4 class="skill-category">Soft Skills</h4>
                <div class="skills-list">
                    <?php foreach ($resumeData['skills']['soft_skills'] as $skill): ?>
                    <span class="skill-tag green">
                        <?= htmlspecialchars($skill['name']) ?>
                        <?php if (!empty($skill['level'])): ?>
                        (<?= htmlspecialchars($skill['level']) ?>)
                        <?php endif; ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($resumeData['skills']['languages'])): ?>
                <h4 class="skill-category">Languages</h4>
                <div class="skills-list">
                    <?php foreach ($resumeData['skills']['languages'] as $skill): ?>
                    <span class="skill-tag purple">
                        <?= htmlspecialchars($skill['name']) ?>
                        <?php if (!empty($skill['level'])): ?>
                        (<?= htmlspecialchars($skill['level']) ?>)
                        <?php endif; ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- Projects -->
        <?php if (!empty($resumeData['projects'])): ?>
        <section class="section">
            <h3 class="section-title">Projects</h3>
            <?php foreach ($resumeData['projects'] as $project): ?>
            <div class="item">
                <div class="item-header">
                    <h4 class="item-title">
                        <?= htmlspecialchars($project['project_name'] ?? 'Untitled Project') ?>
                    </h4>
                    <span class="item-date">
                        <?= formatDate($project['start_date'] ?? '') ?> -
                        <?= $project['is_current'] ?? false ? 'Present' : formatDate($project['end_date'] ?? '') ?>
                    </span>
                </div>
                <?php if ($project['role']): ?>
                <p class="item-subtitle">
                    <?= htmlspecialchars($project['role']) ?>
                </p>
                <?php endif; ?>
                <?php if ($project['technologies_used']): ?>
                <p class="text-sm mb-3">
                    <strong>Technologies:</strong>
                    <?= htmlspecialchars($project['technologies_used']) ?>
                </p>
                <?php endif; ?>
                <?php if ($project['description']): ?>
                <div class="item-description prose">
                    <?= $project['description'] ?>
                </div>
                <?php endif; ?>
                <div class="project-links">
                    <?php if ($project['project_url']): ?>
                    <a href="<?= htmlspecialchars($project['project_url']) ?>" class="project-link">
                        Live Project
                    </a>
                    <?php endif; ?>
                    <?php if ($project['github_url']): ?>
                    <a href="<?= htmlspecialchars($project['github_url']) ?>" class="project-link">
                        GitHub Repo
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <!-- Certifications -->
        <?php if (!empty($resumeData['certifications'])): ?>
        <section class="section">
            <h3 class="section-title">Certifications & Licenses</h3>
            <?php foreach ($resumeData['certifications'] as $certification): ?>
            <div class="item">
                <h4 class="item-title">
                    <?= htmlspecialchars($certification['name'] ?? 'Untitled Certification') ?>
                </h4>
                <p class="text-sm mt-2">
                    <?= htmlspecialchars($certification['issuing_organization'] ?? 'N/A') ?> |
                    Issued: <?= formatDate($certification['issue_date'] ?? '') ?>
                    <?php if ($certification['expiration_date']): ?>
                    | Expires: <?= formatDate($certification['expiration_date']) ?>
                    <?php endif; ?>
                </p>
                <?php if ($certification['credential_id']): ?>
                <p class="text-sm mt-2">
                    Credential ID: <?= htmlspecialchars($certification['credential_id']) ?>
                </p>
                <?php endif; ?>
                <?php if ($certification['credential_url']): ?>
                <a href="<?= htmlspecialchars($certification['credential_url']) ?>" class="project-link">
                    Verify Credential
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <!-- Awards -->
        <?php if (!empty($resumeData['awards'])): ?>
        <section class="section">
            <h3 class="section-title">Awards & Recognition</h3>
            <?php foreach ($resumeData['awards'] as $award): ?>
            <div class="item">
                <div class="item-header">
                    <h4 class="item-title">
                        <?= htmlspecialchars($award['name'] ?? 'Untitled Award') ?>
                    </h4>
                    <span class="item-date">
                        Received: <?= formatDate($award['date_received'] ?? '') ?>
                    </span>
                </div>
                <p class="item-subtitle">
                    <?= htmlspecialchars($award['awarding_organization'] ?? 'N/A') ?>
                </p>
                <?php if ($award['description']): ?>
                <div class="item-description prose">
                    <?= $award['description'] ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <!-- Volunteering -->
        <?php if (!empty($resumeData['volunteering'])): ?>
        <section class="section">
            <h3 class="section-title">Volunteering Experience</h3>
            <?php foreach ($resumeData['volunteering'] as $volunteering): ?>
            <div class="item">
                <div class="item-header">
                    <h4 class="item-title">
                        <?= htmlspecialchars($volunteering['organization_name'] ?? 'Untitled Organization') ?>
                    </h4>
                    <span class="item-date">
                        <?= formatDate($volunteering['start_date'] ?? '') ?> -
                        <?= $volunteering['is_current'] ?? false ? 'Present' : formatDate($volunteering['end_date'] ?? '') ?>
                    </span>
                </div>
                <p class="item-subtitle">
                    <?= htmlspecialchars($volunteering['role'] ?? 'Volunteer') ?>
                </p>
                <?php if ($volunteering['description']): ?>
                <div class="item-description prose">
                    <?= $volunteering['description'] ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <!-- Interests -->
        <?php if (!empty($resumeData['interests'])): ?>
        <section class="section">
            <h3 class="section-title">Interests & Hobbies</h3>
            <div class="skills-list">
                <?php foreach ($resumeData['interests'] as $interest): ?>
                <span class="skill-tag gray">
                    <?= htmlspecialchars($interest['interest'] ?? 'Untitled Interest') ?>
                </span>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</body>

</html>
