@extends('layouts.teacher')
@section('content')


      <div class="grid grid-3 gap-4">
        <!-- LEAVE APPLY FORM (Teacher Only) -->
        <div class="card" id="leaveApplySection" data-role-limit="teacher">
          <div class="card-header">
            <h4 class="font-semibold">Submit Leave Request</h4>
          </div>
          <form id="leaveForm" onsubmit="applyForLeave(event)" class="card-body">
            <div class="grid grid-2 gap-2">
              <div class="form-group">
                <label class="form-label" for="leaveStart">Start Date</label>
                <input type="date" id="leaveStart" class="form-control" required>
              </div>
              <div class="form-group">
                <label class="form-label" for="leaveEnd">End Date</label>
                <input type="date" id="leaveEnd" class="form-control" required>
              </div>
            </div>


            <div class="form-group">
              <label class="form-label" for="leaveReason">Reason / Notes</label>
              <textarea id="leaveReason" class="form-control" placeholder="e.g. Health checkup, concert..." rows="5"
                required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Request</button>
          </form>
        </div>

        <!-- LEAVES REGISTER LIST (All Roles) -->
        <div class="card grid-2-col-span-2" style="grid-column: span 2;" id="leaveRegisterSection">
          <div class="card-header">
            <h4 class="font-semibold">Leave Log Registry</h4>
          </div>
          <div class="card-body p-3">
            <table class="table display responsive nowrap" id="leavesTable" style="width:100%">
              <thead>
                <tr>
                  <th>Teacher</th>
                  <th>Dates</th>
                  <th>Reason</th>
                  <th>Cover Teacher</th>
                  <th>Status</th>
                  <th data-role-limit="admin">Approval Action</th>
                </tr>
              </thead>
              <tbody id="leavesTableBody">
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