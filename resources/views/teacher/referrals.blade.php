@extends('layouts.teacher')
@section('content')

      <div class="referral-grid">

        <!-- Left Side: Code & Submission Form -->
        <div>
          <!-- Code Card -->
          <div class="referral-code-card">
            <h4 class="font-semibold"
              style="font-family: var(--font-serif); font-size: 1.1rem; color: var(--text-main);">My Affiliate Code</h4>
            <div class="referral-code-text">HMA-MEERA</div>
            <p class="text-muted mb-0" style="font-size:0.75rem;">Refer new students or teachers. Earn a Rs 500 bonus
              paid directly with your payroll for every approved referral conversion!</p>
          </div>

          <!-- Submit Form -->
          <div class="card">
            <div class="card-header">
              <h4 class="font-semibold">Submit New Referral</h4>
            </div>
            <div class="card-body p-4">
              <form id="referralForm" onsubmit="submitReferralForm(event)">
                <div class="form-group mb-3">
                  <label class="form-label font-semibold">Name</label>
                  <input type="text" id="refName" class="form-control" placeholder="Enter full name" required>
                </div>
                <div class="form-group mb-3">
                  <label class="form-label font-semibold">Mobile Number</label>
                  <input type="text" id="Number" class="form-control" placeholder="eg. +91 7788676399" required>
                </div>
                <div class="form-group mb-3">
                  <label class="form-label font-semibold">Referred Person Category</label>
                  <select id="refRole" class="form-control" required>
                    <option value="student">Student Candidate</option>
                    <option value="teacher">Teacher Candidate</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit Referral</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Right Side: Referrals Log -->
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold" style="font-family: var(--font-serif); font-size: 1.25rem;">My Referrals History
            </h4>
          </div>
          <div class="card-body p-3">
            <table class="table display responsive nowrap" id="refHistoryTable" style="width:100%">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Referred Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Reward Status</th>
                </tr>
              </thead>
              <tbody id="refHistoryBody">
                <!-- Loaded Dynamically -->
              </tbody>
            </table>
          </div>
        </div>

      </div>
    
@endsection