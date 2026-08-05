@extends('layouts.admin')
@section('content')


      <!-- Student View specific warning about remaining credits -->
      <div id="studentCreditsWarning" class="card mb-4 p-3 badge-warning" data-role-limit="student"
        style="display: none; border-color: var(--warning);">
        <div class="d-flex align-center gap-3">
          <span style="font-size: 1.5rem;">⚠️</span>
          <div>
            <h4 class="font-bold text-primary">Class Credits Alert</h4>
            <p style="font-size: 0.9rem;">You have <strong id="studentRemainCredits">8</strong> class credits remaining.
              Buy more packages in settings to prevent schedule blocking!</p>
          </div>
        </div>
      </div>

      <!-- Student balances table -->
      <div class="card mb-4">
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