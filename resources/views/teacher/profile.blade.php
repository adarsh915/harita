@extends('layouts.teacher')
@section('content')


      <!-- HERO -->
      <div class="profile-hero slide-up">
        <div class="profile-avatar-box" style="position: relative; display: inline-block; cursor: pointer;"
          onclick="document.getElementById('profileImageInput').click()">
          <div class="avatar avatar-lg" id="profileInitials">AD</div>
          <div class="profile-avatar-overlay"
            style="position: absolute; bottom: 0; right: 0; background: var(--primary); color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; border: 2px solid white; box-shadow: var(--shadow-sm); z-index: 5;">
            📷</div>
          <input type="file" id="profileImageInput" style="display: none;" accept="image/*"
            onchange="uploadProfileImage(event)">
        </div>
        <div class="profile-meta">
          <h2 id="profileName">Administrator</h2>
          <p id="profileSub">Super Admin of Harita Music Academy</p>
        </div>
      </div>

      <!-- Tab Buttons for All 3 Profile Sections -->
      <div class="profile-tabs-container">
        <button class="profile-tab active" id="tab_admin" onclick="switchProfileTab('admin')">Admin Profile</button>
        <button class="profile-tab" id="tab_teacher" onclick="switchProfileTab('teacher')">Teacher Profile</button>
        <button class="profile-tab" id="tab_student" onclick="switchProfileTab('student')">Student Profile</button>
      </div>

      <!-- ==========================================
           ADMIN PROFILE VIEW
           ========================================== -->
      <div id="adminProfileView" class="profile-grid-layout tab-content">
        <!-- Details Card -->
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold">Security Credentials</h4>
          </div>
          <div class="card-body">
            <div class="info-list-item">
              <span class="text-muted">Username</span>
              <span class="font-semibold">admin_harita</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">Contact Email</span>
              <span class="font-semibold">admin@haritamusic.com</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">System Level</span>
              <span class="font-semibold">Level 1 (All Access)</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">Assigned Keys</span>
              <span class="font-semibold">F281-992A-KK92</span>
            </div>
          </div>
        </div>
        <!-- Audit log -->
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold">Recent Administrative Logs</h4>
          </div>
          <div class="card-body">
            <div class="info-list-item">
              <span class="text-muted">Today, 11:30 AM</span>
              <span class="font-semibold">Updated permissions matrix for Student role.</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">Yesterday, 04:00 PM</span>
              <span class="font-semibold">Approved Leave Request for Meera Sharma (LEV001).</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">2026-07-21, 10:20 AM</span>
              <span class="font-semibold">Adjusted credits for Aria Sharma (+20 package).</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">2026-07-20, 09:15 AM</span>
              <span class="font-semibold">Added student Kabir Mehta (STU004).</span>
            </div>
          </div>
        </div>
      </div>

      <!-- ==========================================
           TEACHER PROFILE VIEW
           ========================================== -->
      <div id="teacherProfileView" class="profile-grid-layout tab-content" style="display:none;">
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold">Academic Profile</h4>
          </div>
          <div class="card-body">
            <div class="info-list-item">
              <span class="text-muted">Categories</span>
              <span class="font-semibold">Vocal, Veena</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">Level</span>
              <span class="font-semibold">Advanced Level</span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold">Teacher Biography</h4>
          </div>
          <div class="card-body">
            <p class="text-muted mb-4">
              Meera Sharma is a classical vocalist with 12+ years of teaching experience. She has mastered both
              Hindustani and Carnatic vocals and trained multiple students who have qualified for national level music
              competitions.
            </p>
            <h4 class="font-semibold text-primary mb-2" style="font-size: 0.95rem;">Availability Hours</h4>
            <div class="info-list-item">
              <span class="text-muted">Certifications</span>
              <span class="font-semibold">Certificate 1,Certificate 2</span>
            </div>

          </div>
        </div>
      </div>

      <!-- ==========================================
           STUDENT PROFILE VIEW
           ========================================== -->
      <div id="studentProfileView" class="profile-grid-layout tab-content" style="display:none;">
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold">Enrolment Overview</h4>
          </div>
          <div class="card-body">
            <div class="info-list-item">
              <span class="text-muted">Primary Instrument</span>
              <span class="font-semibold">Vocal (Carnatic)</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">Assigned Mentor</span>
              <span class="font-semibold">Meera Sharma</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">Remaining Credits</span>
              <span class="font-semibold text-primary">8 Class Credits</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">Admission Date</span>
              <span class="font-semibold">January 10, 2026</span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold">Package Purchases History</h4>
          </div>
          <div class="card-body">
            <div class="info-list-item">
              <div>
                <div class="font-semibold">Vocal Basic 10-Class Package</div>
                <div class="text-muted" style="font-size: 0.7rem;">Paid: UPI (Google Pay)</div>
              </div>
              <div class="text-right">
                <div class="font-bold">₹8,500</div>
                <div class="text-muted" style="font-size: 0.7rem;">2026-07-20</div>
              </div>
            </div>
            <div class="info-list-item">
              <div>
                <div class="font-semibold">Carnatic Starter 10-Class Package</div>
                <div class="text-muted" style="font-size: 0.7rem;">Paid: Net Banking</div>
              </div>
              <div class="text-right">
                <div class="font-bold">₹8,500</div>
                <div class="text-muted" style="font-size: 0.7rem;">2026-01-10</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Developed by Sitesoch footer -->
      <footer class="footer">
        <p>© 2026 Harita Music Academy. All rights reserved. | Developed by <a href="https://sitesoch.com"
            target="_blank">Sitesoch</a></p>
      </footer>

    
@endsection