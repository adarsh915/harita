@extends('layouts.main')
@section('page', 'payroll')

@push('styles')
<style>
.payroll-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.25rem;
      margin-bottom: 1.5rem;
    }

    @media (max-width: 992px) {
      .payroll-stats {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 576px) {
      .payroll-stats {
        grid-template-columns: 1fr;
      }
    }

    .payroll-grid {
      display: grid;
      grid-template-columns: 1.2fr 1.8fr;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    @media (max-width: 992px) {
      .payroll-grid {
        grid-template-columns: 1fr;
      }
    }

    .salary-calc-box {
      /* background-color: var(--primary-light); */
      border: 1.5px solid var(--primary);
      border-radius: var(--radius-md);
      padding: 1.25rem;
      margin-top: 1rem;
    }
</style>
@endpush

@section('content')
<!-- Stats Grid -->
      <div class="payroll-stats">
        <div class="card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: var(--success-bg); color: var(--success)">💳</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Per Class Rate</div>
            <h3 id="classRateText" class="font-bold">₹500</h3>
          </div>
        </div>
        <div class="card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: var(--info-bg); color: var(--info)">📊</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Classes Taught</div>
            <h3 id="classesTaughtText" class="font-bold">24</h3>
          </div>
        </div>
        <div class="card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: var(--warning-bg); color: var(--warning)">⭐</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Opportunities Taken</div>
            <h3 id="oppTakenText" class="font-bold">5</h3>
          </div>
        </div>
        <div class="card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: var(--success-bg); color: var(--success)">💰</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Estimated Payout</div>
            <h3 id="estPayoutText" class="font-bold">₹12,500</h3>
          </div>
        </div>
      </div>

      <!-- Main Payroll Display Grid -->
      <div class="payroll-grid">

        <!-- Payout Calculation Details -->
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold" style="font-family: var(--font-serif); font-size: 1.25rem;">Salary Slip - July
              2026</h4>
          </div>
          <div class="card-body p-4">
            <div class="info-list-item">
              <span class="text-muted">Teacher Name</span>
              <span class="font-bold">Meera Sharma</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">Month &amp; Year</span>
              <span class="font-semibold">July 2026</span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">Base Salary (Dynamic)</span>
              <span class="font-semibold">₹12,000 <small class="text-muted">(Rate × 24 Classes)</small></span>
            </div>
            <div class="info-list-item">
              <span class="text-muted">Opportunities Bonus</span>
              <span class="font-semibold">₹500 <small class="text-muted">(20% Rate × 5 Demos)</small></span>
            </div>

            <!-- Calculation Box -->
            <div class="salary-calc-box">
              <div class="font-bold text-primary mb-2" style="font-size: 0.85rem; text-transform: uppercase;">Academy
                Ledger Formula</div>

              <!-- Hardcoded required formula demonstration -->
              <div class="mb-2" style="font-size:0.8rem; line-height: 1.45;">
                <span class="font-medium">Standard Pack Salary:</span><br>
                <code>(Rate * 10) + (20% of Rate * 5)</code><br>
                = <code>(500 * 10) + (100 * 5)</code> = <b class="text-serif font-bold">₹5,500</b>
              </div>

              <div style="font-size:0.8rem; line-height: 1.45; border-top: 1px solid var(--primary); padding-top: 0.5rem; margin-top: 0.5rem;">
                <span class="text-muted font-medium">This Month Actual Payout:</span><br>
                <code>(Rate * 24) + (20% of Rate * 5)</code><br>
                = <code>(500 * 24) + (100 * 5)</code> = <b class="text-serif font-bold" style="font-size:1.1rem; color: var(--secondary);">₹12,500</b>
              </div>
            </div>
          </div>
        </div>

        <!-- Days Taught Detail Logs -->
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold" style="font-family: var(--font-serif); font-size: 1.25rem;">Days Taught Ledger
              (Current Month)</h4>
          </div>
          <div class="card-body p-3">
            <table class="table display responsive nowrap" id="payrollTable" style="width:100%">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Classes Taken</th>
                  <th>Total Hours</th>
                  <th>Class / Student Details</th>
                </tr>
              </thead>
              <tbody id="payrollTableBody">
                <!-- Populated Dynamically -->
              </tbody>
            </table>
          </div>
        </div>

      </div>
@endsection
