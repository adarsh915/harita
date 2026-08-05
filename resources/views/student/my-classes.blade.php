@extends('layouts.student')
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
          <button class="btn btn-primary" onclick="openBookModal()">
            Book New Session
          </button>
        </div>
      </div>

      <div id="agendaList" class="slide-up">
        <!-- Dynamically loaded list of agenda cards -->
      </div>

      <!-- Developed by Sitesoch footer -->
      <footer class="footer">
        <p>© 2026 Harita Music Academy. All rights reserved. | Developed by <a href="https://sitesoch.com"
            target="_blank">Sitesoch</a></p>
      </footer>

    
@endsection