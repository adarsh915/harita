@extends('layouts.student')
@section('content')


      <!-- Student View specific warning about remaining credits -->
      <div id="studentCreditsWarning" class="card mb-4 p-3 badge-warning" data-role-limit="student"
        style="display: none; border-color: var(--warning);">
        <div class="d-flex align-center gap-3">
          <span style="font-size: 1.5rem;">⚠️</span>
          <div>
            <h4 class="font-bold text-primary">Class Credits Alert</h4>
            <p style="font-size: 0.9rem;">You have <strong id="studentRemainCredits">8</strong> class credits remaining.
            </p>
          </div>
        </div>
      </div>

      <div class="grid grid-2 gap-4 mb-4">
        <!-- Student balances table -->
        <div class="card grid-2-col-span-2" style="grid-column: span 2;">
          <div class="card-header">
            <h4 class="font-semibold">Student Credit Balances</h4>
            <input type="text" id="creditSearch" class="form-control" placeholder="Quick filter name..."
              style="width: 180px;">
          </div>
          <div class="card-body p-3">
            <table class="table display responsive nowrap" id="balancesTable" style="width:100%">
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Instrument</th>
                  <th>Current Balance</th>
                  <th data-role-limit="admin">Adjust Credits</th>
                </tr>
              </thead>
              <tbody id="creditsTableBody">
                <!-- Populated via JS -->
              </tbody>
            </table>
          </div>
        </div>

        <!-- Adjust Panel (Admin Only) -->
        <div class="card" data-role-limit="admin">
          <div class="card-header">
            <h4 class="font-semibold">Quick Credit Adjustment</h4>
          </div>
          <form id="adjustmentForm" onsubmit="applyAdjustment(event)" class="card-body">
            <div class="form-group">
              <label class="form-label" for="adjStudent">Select Student</label>
              <select id="adjStudent" class="form-control" required>
                <!-- Populated via JS -->
              </select>
            </div>

            <div class="grid grid-1 gap-2">
              <div class="form-group">
                <label class="form-label" for="adjAction">Action</label>
                <select id="adjAction" class="form-control" required>
                  <option value="add">Add (+)</option>
                  <option value="deduct">Deduct (-)</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label" for="adjAmount">Amount</label>
                <input type="number" id="adjAmount" class="form-control" min="1" value="1" required>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="adjReason">Reason / Notes</label>
              <select id="adjReason" class="form-control" required>
                <option value="Package Purchased">Package Purchased</option>
                <option value="Class Compensation">Class Compensation</option>
                <option value="Manual Correction">Manual Correction</option>
                <option value="Promo Credit">Promo Credit</option>
                <option value="Class Taken">Class Taken</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Apply Adjustment</button>
          </form>
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

      <!-- Developed by Sitesoch footer -->
      <footer class="footer">
        <p>© 2026 Harita Music Academy. All rights reserved. | Developed by <a href="https://sitesoch.com"
            target="_blank">Sitesoch</a></p>
      </footer>

    
@endsection