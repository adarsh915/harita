@extends('layouts.teacher')
@section('content')


      <!-- ==========================================
           ADMIN VIEW CONTAINER
           ========================================== -->
      <!-- TEACHER VIEW CONTAINER
           ========================================== -->
      <div id="teacherDashboardView" data-role-limit="teacher" class="slide-up" style="display:none;">
        <div class="welcome-banner">
          <div class="welcome-text">
            <h2>Welcome back, Meera Sharma! 🎻</h2>
            <p>Your students are waiting. Keep teaching, great music changes lives.</p>
          </div>
          <button class="btn btn-accent btn-sm" onclick="window.location.href='class-booking.html'">Book Class</button>
        </div>

        <div class="grid grid-12 gap-4 mb-4">
          <div class="card p-3">
            <h4 class="font-semibold text-primary mb-3">Today's Class Schedule</h4>
            <div id="teacherTodaySchedule" class="schedule-grid-cols">
              <!-- Dynamically populated classes -->
            </div>
          </div>

        </div>

        <!-- Teacher Analytics Chart Grid -->
        <div class="grid grid-2 gap-4 mb-4">
          <div class="card">
            <div class="card-header">
              <h4 class="font-semibold">Teaching Hours Trend</h4>
            </div>
            <div class="card-body d-flex justify-center align-center">
              <canvas id="teacherHoursChart" style="width: 100%; height: 200px;"></canvas>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h4 class="font-semibold">My Students by Instrument</h4>
            </div>
            <div class="card-body d-flex justify-center align-center">
              <canvas id="teacherStudentStats" style="width: 100%; height: 200px;"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- ==========================================
           STUDENT VIEW CONTAINER (Replicates Ref)
           ========================================== -->
      <!-- Developed by Sitesoch footer -->
      <footer class="footer">
        <p>© 2026 Harita Music Academy. All rights reserved. | Developed by <a href="https://sitesoch.com"
            target="_blank">Sitesoch</a></p>
      </footer>

    
@endsection