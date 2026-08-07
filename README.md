# Sarvepalli Radhakrishnan University (SRKU) PHP Web Application & Admin CMS

This repository contains the custom PHP website and Admin CMS for Sarvepalli Radhakrishnan University (SRKU), replacing WordPress/Elementor with a fast, modern, and responsive custom PHP solution cloned from [https://srku.edu.in/new-staging/](https://srku.edu.in/new-staging/).

## 🚀 Features

- **Public University Website**:
  - Live top bar with Helpline, Email, Student Portal, and AICTE links.
  - Interactive top announcements marquee ticker bar.
  - Hero slider with key stats (42+ Labs, 94% Placement Record, etc.).
  - Academic departments filter (Engineering, Pharmacy, Computer Applications, Management, Nursing, Allied Sciences).
  - Chancellor & Vice-Chancellor leadership desk message.
  - Dynamic page renderer for custom pages (`page.php?slug=...`).
  - Admission Enquiry form connected directly to Admin CMS.

- **Admin CMS Panel (`/admin`)**:
  - **Dynamic Page CMS**: Add, edit, publish or delete custom pages with custom URLs.
  - **Courses & Fees Manager**: Manage academic degrees, eligibility, duration, and fees.
  - **Hero Banner Manager**: Control homepage sliders and call-to-action buttons.
  - **Campus News & Ticker**: Publish announcements, notices, and update top ticker text.
  - **Leads & Queries**: View and manage all student admission form enquiries.
  - **Global Settings**: Configure university contact phone, email, campus address.

---

## 🔐 Admin CMS Credentials

- **URL**: `http://localhost/srku-new/admin/login.php`
- **Username**: `admin`
- **Password**: `admin123`

---

## 🛠️ Installation & Setup Guide

1. Ensure **XAMPP / WAMP / Apache & MySQL** is running.
2. Copy or clone this folder into `htdocs`:
   ```bash
   c:\xampp\htdocs\srku-new
   ```
3. Open browser:
   - Main Site: `http://localhost/srku-new/`
   - Admin Panel: `http://localhost/srku-new/admin/login.php`
4. Database Auto-Setup:
   - The app automatically creates the MySQL database `srku_db` and all required tables upon first visit!
   - Alternatively, you can manually import `database.sql` into phpMyAdmin.

---

## 💻 Team Collaboration & Git Commands

To connect this repository to GitHub/GitLab for your team:

1. **Add Remote Origin**:
   ```bash
   git remote add origin <YOUR_GITHUB_REPO_URL>
   ```

2. **Push Code to Remote**:
   ```bash
   git branch -M main
   git push -u origin main
   ```

3. **How Team Members Clone & Work**:
   ```bash
   git clone <YOUR_GITHUB_REPO_URL>
   ```
