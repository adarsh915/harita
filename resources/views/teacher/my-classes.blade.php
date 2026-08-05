@extends('layouts.teacher')
@section('content')


      <div class="card mb-3">
        <div class="card-body d-flex flex-wrap align-center justify-between gap-3">
          <div class="d-flex gap-2" style="flex: 1; max-width: 400px;">
            <select id="statusFilter" class="form-control" onchange="loadClassesAgenda()">
              <option value="">All Classes</option>
              <option value="Scheduled">Scheduled</option>
              <option value="Completed">Completed</option>
              <option value="Reschedule Requested">Reschedule Requested</option>
            </select>
          </div>
          <button class="btn btn-primary" onclick="window.location.href='class-booking.html'">
            Book New Session
          </button>
        </div>
      </div>

      <div class="card slide-up">
        <div class="card-body">

          <div id="calendar"></div>

          <hr style="margin:30px 0;">
          <h4 class="font-semibold text-primary mb-3">Today's Class Schedule</h4>
          <div id="agendaList"></div>

        </div>
      </div>

      <!-- Developed by Sitesoch footer -->
      <footer class="footer">
        <p>© 2026 Harita Music Academy. All rights reserved. | Developed by <a href="https://sitesoch.com"
            target="_blank">Sitesoch</a></p>
      </footer>

    
@endsection