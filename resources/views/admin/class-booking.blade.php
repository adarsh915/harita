@extends('layouts.admin')
@section('content')


      <!-- BOOKING PANEL (Admins & Teachers) -->
      <div class="card mb-4" id="classBookingSection">
        <div class="card-header">
          <h4 class="font-semibold" id="bookingPanelTitle">Schedule a New Class Room</h4>
        </div>
        <form id="bookingForm" onsubmit="bookNewClass(event)" class="card-body">
          <div class="booking-container">
            <!-- Left Side: Inputs -->
            <div class="booking-form-section">
              <div class="booking-grid">
                <div class="form-group">
                  <label class="form-label" for="bookStudent">Student Name</label>
                  <select id="bookStudent" class="form-control" required onchange="onStudentSelectChange()">
                    <!-- Loaded dynamically -->
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label" for="bookDate">Select Date</label>
                  <input type="date" id="bookDate" class="form-control" required onchange="onDateSelectChange()">
                </div>
              </div>

              <!-- Student Status Card (populated on select student) -->
              <div id="studentStatusCard" class="student-info-card" style="display: none;">
                <div class="student-info-item">
                  <span class="student-info-label">Assigned Teacher</span>
                  <span id="statusTeacher" class="student-info-value">-</span>
                </div>
                <div class="student-info-item">
                  <span class="student-info-label">Instrument / Subject</span>
                  <span id="statusInstrument" class="student-info-value">-</span>
                </div>
                <div class="student-info-item">
                  <span class="student-info-label">Allocated Credits</span>
                  <span id="statusCredits" class="student-info-value">-</span>
                </div>
              </div>

              <div class="booking-grid">
                <div class="form-group">
                  <label class="form-label" for="bookTime">Start Time</label>
                  <select id="bookTime" class="form-control" required onchange="onTimeSelectChange()">
                    <!-- Loaded dynamically from 8 AM to 2 AM -->
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Call Duration</label>
                  <input type="text" class="form-control" value="40 Minutes" readonly style="background-color: var(--border-light)">
                </div>
              </div>

              <!-- Recurrence Settings (Initially hidden until date selected) -->
              <div id="recurrenceSection" style="display: none; flex-direction: column; gap: 1rem;">
                <div class="form-group">
                  <label class="form-label">Booking Type</label>
                  <div class="segmented-control">
                    <button type="button" id="btnOneTime" class="segmented-control-btn active" onclick="setRecurrenceMode('one-time')">One-time Class</button>
                    <button type="button" id="btnRecurring" class="segmented-control-btn" onclick="setRecurrenceMode('recurring')">Recurring Weekly</button>
                  </div>
                  <input type="hidden" id="recurrenceMode" value="one-time">
                </div>

                <div id="recurringWeeksGroup" class="form-group" style="display: none;">
                  <label class="form-label" for="bookWeeks">Number of Weekly Occurrences</label>
                  <select id="bookWeeks" class="form-control" onchange="onWeeksSelectChange()">
                    <!-- Dynamic based on credits -->
                  </select>
                  <span class="text-muted" style="font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                    The class will repeat weekly on <span id="detectedDayLabel" class="font-semibold">-</span>s. Capped by student's available credits.
                  </span>
                </div>
              </div>

              <!-- Warning Banner -->
              <div id="bookingWarningText" class="text-danger font-semibold mb-2" style="display:none; font-size: 0.8rem;"></div>

              <button type="submit" id="btnSubmitBooking" class="btn btn-primary" style="margin-top: 1rem;">Create Scheduled Class Room</button>
            </div>

            <!-- Right Side: Live Summary & Preview -->
            <div class="preview-card">
              <h5 class="preview-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Booking Live Preview
              </h5>
              <div class="preview-body">
                <div class="preview-row">
                  <span class="preview-label">Student:</span>
                  <span id="previewStudent" class="preview-val">-</span>
                </div>
                <div class="preview-row">
                  <span class="preview-label">Teacher:</span>
                  <span id="previewTeacher" class="preview-val">-</span>
                </div>
                <div class="preview-row">
                  <span class="preview-label">Schedule Type:</span>
                  <span id="previewType" class="preview-val">-</span>
                </div>
                <div class="preview-row">
                  <span class="preview-label">Start Time:</span>
                  <span id="previewStart" class="preview-val">-</span>
                </div>
                <div class="preview-row">
                  <span class="preview-label">End Time:</span>
                  <span id="previewEnd" class="preview-val">-</span>
                </div>
                <div class="preview-row">
                  <span class="preview-label">Google Meet:</span>
                  <span id="previewMeet" class="preview-val meet-badge">Auto-Generated</span>
                </div>
                
                <!-- Recurring Dates list -->
                <div id="previewOccurrencesGroup" style="display: none; margin-top: 0.5rem;">
                  <span class="preview-label" style="display: block; margin-bottom: 0.35rem;">Scheduled Session Dates:</span>
                  <div id="previewOccurrencesList" class="preview-occurrences-list">
                    <!-- Populated dynamically -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Student view warning helper -->
      <div class="card grid-2-col-span-2" style="grid-column: span 2; display:none;" id="studentBookingPlaceholder">
        <div class="card-body text-center p-4">
          <span style="font-size: 2.5rem;">🎻</span>
          <h3 class="text-serif text-primary mt-2">Class Booking Matrix</h3>
          <p class="text-muted mt-2">Class slots are assigned by your mentor (Meera Sharma). If you need to request a
            slot, please email the administrator or choose one of your active classes on the right to trigger a
            reschedule call.</p>
          <button class="btn btn-primary mt-3" onclick="window.location.href='profile.html'">View Teacher
            Contact</button>
        </div>
      </div>

      <!-- ACTIVE SCHEDULE FOR RESCHEDULING (All Roles) -->
      <div class="card mb-4">
        <div class="card-header">
          <h4 class="font-semibold">Active Scheduled Classes</h4>
        </div>
        <div class="card-body p-3">
          <table class="table display responsive nowrap" id="rescheduleTable" style="width: 100%;">
            <thead>
              <tr>
                <th>Instrument</th>
                <th>Date & Time</th>
                <th id="partyHeader">With</th>
                <th>Google Meet</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="rescheduleTableBody">
              <!-- Populated via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Developed by Sitesoch footer -->
      <footer class="footer">
        <p>© 2026 Harita Music Academy. All rights reserved. | Developed by <a href="https://sitesoch.com"
            target="_blank">Sitesoch</a></p>
      </footer>

    
@endsection