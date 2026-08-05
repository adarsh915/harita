@extends('layouts.admin')
@section('content')


      <!-- ==========================================
           ADMIN VIEW CONTAINER
           ========================================== -->
      <div id="adminDashboardView" data-role-limit="admin" class="slide-up">
        <!-- 4 Stat boxes -->
        <div class="stat-card-grid">
          <div class="card p-3 d-flex align-center gap-3 stat-card">
            <div class="stat-icon">🎓</div>
            <div>
              <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Students</div>
              <h3 id="adminTotalStudents" class="font-bold">5</h3>
            </div>
          </div>
          <div class="card p-3 d-flex align-center gap-3 stat-card">
            <div class="stat-icon">🎻</div>
            <div>
              <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Teachers</div>
              <h3 id="adminTotalTeachers" class="font-bold">4</h3>
            </div>
          </div>
          <div class="card p-3 d-flex align-center gap-3 stat-card">
            <div class="stat-icon">📅</div>
            <div>
              <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Today's Classes</div>
              <h3 id="adminTodayClasses" class="font-bold">1</h3>
            </div>
          </div>
          <div class="card p-3 d-flex align-center gap-3 stat-card">
            <div class="stat-icon">💰</div>
            <div>
              <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Monthly Sales</div>
              <h3 id="adminMonthlySales" class="font-bold">₹41,000</h3>
            </div>
          </div>
        </div>

        <!-- Quick Admin Actions Card -->
        <div class="card mb-4">
          <div class="card-header">
            <h4 class="font-semibold">⚡ Quick Actions Panel</h4>
          </div>
          <div class="card-body d-flex gap-3 flex-wrap">
            <a href="students.html" class="btn btn-secondary btn-sm">➕ Add Student</a>
            <a href="teachers.html" class="btn btn-secondary btn-sm">➕ Add Teacher</a>
            <a href="credits.html" class="btn btn-secondary btn-sm">🪙 Adjust Credits</a>
            <a href="class-booking.html" class="btn btn-primary btn-sm">📅 Schedule Class</a>
          </div>
        </div>

        <!-- Charts grid -->
        <div class="grid grid-2 gap-4 mb-4">
          <div class="card">
            <div class="card-header">
              <h4 class="font-semibold">Revenue Trend (INR)</h4>
            </div>
            <div class="card-body d-flex justify-center align-center">
              <canvas id="revenueLineChart" style="width: 100%; height: 200px;"></canvas>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h4 class="font-semibold">Classes Booked by Instrument</h4>
            </div>
            <div class="card-body d-flex justify-center align-center">
              <canvas id="instrumentBarChart" style="width: 100%; height: 200px;"></canvas>
            </div>
          </div>
        </div>

        <!-- Additional Charts grid -->
        <div class="grid grid-2 gap-4 mb-4">
          <div class="card">
            <div class="card-header">
              <h4 class="font-semibold">Total Students Enrolled</h4>
            </div>
            <div class="card-body d-flex justify-center align-center">
              <canvas id="studentsEnrolledChart" style="width: 100%; height: 200px;"></canvas>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h4 class="font-semibold">Total Teachers Onboarded</h4>
            </div>
            <div class="card-body d-flex justify-center align-center">
              <canvas id="teachersOnboardedChart" style="width: 100%; height: 200px;"></canvas>
            </div>
          </div>
        </div>

        <!-- Lower Information Grid -->
        <div class="grid grid-2 gap-4 mb-4">
          <!-- Recent Activity -->
          <div class="card">
            <div class="card-header">
              <h4 class="font-semibold">🔔 Recent Academy Activity</h4>
            </div>
            <div class="card-body p-0">
              <div class="d-flex align-center gap-3 p-2 border-bottom" style="font-size: 13px;">
                <span>🟢</span>
                <div>
                  <strong>New Student Registered</strong>: Anirudh Ravichander enrolled in Flute class.
                  <div class="text-light" style="font-size: 11px; margin-top: 2px;">5 minutes ago</div>
                </div>
              </div>
              <div class="d-flex align-center gap-3 p-2 border-bottom" style="font-size: 13px;">
                <span>💳</span>
                <div>
                  <strong>Payment Confirmed</strong>: Aria Sharma purchased Tabla 20-Class Package.
                  <div class="text-light" style="font-size: 11px; margin-top: 2px;">2 hours ago</div>
                </div>
              </div>
              <div class="d-flex align-center gap-3 p-2" style="font-size: 13px;">
                <span>📅</span>
                <div>
                  <strong>Class Rescheduled</strong>: Sitar Intermediate (Rohan Malhotra) moved to tomorrow.
                  <div class="text-light" style="font-size: 11px; margin-top: 2px;">Yesterday</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Top Instructors -->
          <div class="card">
            <div class="card-header">
              <h4 class="font-semibold">⭐ Top Rated Instructors</h4>
            </div>
            <div class="card-body p-0">
              <div class="d-flex align-center justify-between p-2 border-bottom" style="font-size: 13.5px;">
                <div class="d-flex align-center">
                  <span class="table-avatar" style="background-color: var(--secondary-light);">MS</span>
                  <div>
                    <strong>Meera Sharma</strong>
                    <div class="text-light" style="font-size: 11px;">Vocal & Violin Specialist</div>
                  </div>
                </div>
                <span style="color: #eab308; font-weight: 700;">5.0 ⭐ (24 classes)</span>
              </div>
              <div class="d-flex align-center justify-between p-2 border-bottom" style="font-size: 13.5px;">
                <div class="d-flex align-center">
                  <span class="table-avatar" style="background-color: var(--secondary-light);">RS</span>
                  <div>
                    <strong>Pandit Ravi Sen</strong>
                    <div class="text-light" style="font-size: 11px;">Sitar Maestro</div>
                  </div>
                </div>
                <span style="color: #eab308; font-weight: 700;">4.9 ⭐ (18 classes)</span>
              </div>
              <div class="d-flex align-center justify-between p-2" style="font-size: 13.5px;">
                <div class="d-flex align-center">
                  <span class="table-avatar" style="background-color: var(--secondary-light);">HP</span>
                  <div>
                    <strong>Hari Prasad Jr</strong>
                    <div class="text-light" style="font-size: 11px;">Flute Specialist</div>
                  </div>
                </div>
                <span style="color: #eab308; font-weight: 700;">4.8 ⭐ (15 classes)</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ==========================================
           TEACHER VIEW CONTAINER
           ========================================== -->
      <!-- STUDENT VIEW CONTAINER (Replicates Ref)
           ========================================== -->
      <!-- Developed by Sitesoch footer -->
      <footer class="footer">
        <p>© 2026 Harita Music Academy. All rights reserved. | Developed by <a href="https://sitesoch.com"
            target="_blank">Sitesoch</a></p>
      </footer>

    
@endsection