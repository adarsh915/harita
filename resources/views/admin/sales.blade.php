@extends('layouts.admin')
@section('content')


      <!-- Sales Stats Grid -->
      <div class="sales-stat-grid">
        <div class="card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: var(--success-bg); color: var(--success)">📈</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Total Sales (Gross)</div>
            <h3 id="grossSalesText" class="font-bold">₹41,000</h3>
          </div>
        </div>
        <div class="card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: var(--info-bg); color: var(--info)">📦</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Student Enrolled</div>
            <h3 id="packagesSoldText" class="font-bold">4</h3>
          </div>
        </div>
        <div class="card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: var(--warning-bg); color: var(--warning)">⚖️</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Average Transaction</div>
            <h3 id="avgTxText" class="font-bold">₹10,250</h3>
          </div>
        </div>
        <div class="card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: var(--warning-bg); color: var(--warning)">⚖️</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Average Transaction</div>
            <h3 id="avgTxText" class="font-bold">₹10,250</h3>
          </div>
        </div>
      </div>

      <!-- Financial Chart -->
      <div class="card mb-4">
        <div class="card-header">
          <h4 class="font-semibold">Revenue Trend Analysis (INR)</h4>
        </div>
        <div class="card-body d-flex justify-center align-center">
          <canvas id="salesLineChart" style="width: 100%; height: 220px;"></canvas>
        </div>
      </div>



      <!-- Demo Leads & Inquiries Table -->
      <div class="card mb-4">
        <div class="card-header d-flex align-center justify-between">
          <h4 class="font-semibold" style="font-family: var(--font-serif); font-size: 1.25rem;">Demo Leads & Inquiries Pipeline</h4>
          <input type="text" id="leadsSearch" class="form-control" placeholder="Search leads..." style="width: 180px;">
        </div>
        <div class="card-body p-3" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
          <table class="table display responsive nowrap" id="leadsTable" style="width:100%">
            <thead>
              <tr>
                <th data-priority="8">Lead ID</th>
                <th data-priority="1">Student Name</th>
                <th data-priority="7">Contact Information</th>
                <th data-priority="6">Instrument Focus</th>
                <th data-priority="3">Amount</th>
                <th data-priority="4">Payment Mode</th>
                <th data-priority="5">Transaction Date</th>
                <th data-priority="2">Status</th>
                <th data-priority="1" style="width: 80px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody id="leadsTableBody">
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