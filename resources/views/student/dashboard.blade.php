@extends('layouts.student')
@section('content')


      <!-- ==========================================
           ADMIN VIEW CONTAINER
           ========================================== -->
      <!-- STUDENT VIEW CONTAINER (Replicates Ref)
           ========================================== -->
      <div id="studentDashboardView" data-role-limit="student" class="slide-up" style="display:none;">

        <div class="student-dashboard-layout">
          <!-- Banner card -->
          <div class="student-card-banner">
            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=200&h=200"
              alt="Ananya Profile">
            <div>
              <span class="text-muted font-semibold" style="font-size: 0.75rem; text-transform: uppercase;">Student
                Portal</span>
              <h2 class="text-serif text-primary" style="font-size: 1.4rem; margin-bottom: 0.25rem;">Welcome back,
                Ananya! 👋</h2>
              <p class="text-muted mb-2" style="font-size: 0.85rem;">Keep practicing, great music accomplishments take
                time.</p>
              <button class="btn btn-primary btn-sm" onclick="alert('Launching Live Audio/Video Stream room...')">Join
                Next Class</button>
            </div>
          </div>

          <!-- Next Class Box -->
          <div class="student-card">
            <div>
              <span class="form-label" style="font-size: 0.7rem;">Next Class</span>
              <h4 class="font-semibold text-primary mt-1">Raag Yaman - Vilambit</h4>
              <p class="text-muted" style="font-size: 0.8rem;">with <a href="javascript:void(0)" class="text-primary hover-underline font-semibold" onclick="showTeacherProfileModal('Meera Sharma')">Meera Sharma</a></p>
            </div>
            <div class="student-class-box mt-2">
              <div class="font-semibold" style="font-size: 0.85rem;">Tomorrow, 08:00 PM</div>
              <div class="text-muted" style="font-size: 0.7rem;">Duration: 60 mins</div>
            </div>
            <button class="btn btn-secondary btn-sm"
              onclick="window.location.href='my-classes.html'">Reschedule</button>
          </div>

          <!-- Progress Ring Card -->
          <div class="student-card align-center text-center">
            <span class="form-label">Progress Overview</span>
            <div class="text-muted mb-2" style="font-size: 0.75rem;">Keep going, you're doing amazing!</div>

            <div id="studentProgressRing" class="progress-ring-container my-2"></div>

            <div class="w-100 mt-2" style="font-size: 0.8rem; text-align: left;">
              <div class="d-flex justify-between border-bottom p-1">
                <span>Classes Completed</span>
                <span class="font-bold">18 / 24</span>
              </div>


            </div>
          </div>
        </div>

        <!-- Transaction Log -->
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold">Credit Transaction Log</h4>
          </div>
          <div class="card-body p-3">
            <table class="table display responsive nowrap" id="transactionsTable" style="width:100%">
              <thead>
                <tr>
                  <th>Timestamp</th>
                  <th>Student Name</th>
                  <th>Action</th>
                  <th>Quantity</th>
                  <th>Reason / Remarks</th>
                </tr>
              </thead>
              <tbody id="transactionTableBody">
                <!-- Populated via JS -->
              </tbody>
            </table>
          </div>
        </div>


      </div>

      <!-- Developed by Sitesoch footer -->
      <footer class="footer">
        <p>© 2026 Harita Music Academy. All rights reserved. | Developed by <a href="https://sitesoch.com"
            target="_blank">Sitesoch</a></p>
      </footer>

    
@endsection