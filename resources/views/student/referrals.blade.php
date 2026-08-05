@extends('layouts.student')
@section('content')

      <div class="referral-grid">

        <!-- Left Side: Code & Submission Form -->
        <div>
          <!-- Code Card -->
          <div class="referral-code-card">
            <h4 class="font-semibold"
              style="font-family: var(--font-serif); font-size: 1.1rem; color: var(--text-main);">My Referral Code</h4>
            <div class="referral-code-text">HMA-ANANYA</div>
            <p class="text-muted mb-0" style="font-size:0.75rem;">Share this code with friends. Get <b>1 free
                credit</b> when they sign up and complete a package purchase!</p>
          </div>

          <!-- Submit Form -->
          <div class="card">
            <div class="card-header">
              <h4 class="font-semibold">Submit New Referral</h4>
            </div>
            <div class="card-body p-4">
              <form id="referralForm" onsubmit="submitReferralForm(event)">
                <div class="form-group mb-3">
                  <label class="form-label font-semibold">Friend's Name</label>
                  <input type="text" id="refName" class="form-control" placeholder="Enter full name" required>
                </div>
                <div class="form-group mb-3">
                  <label class="form-label font-semibold">Friend's Mobile</label>
                  <input type="text" id="refEmail" class="form-control" placeholder="+91 7789765678" required>
                </div>
                <div class="form-group mb-3">
                  <label class="form-label font-semibold">Instrument Interest</label>
                  <select id="refInstrument" class="form-control" required>
                    <option value="Sitar">Sitar</option>
                    <option value="Tabla">Tabla</option>
                    <option value="Violin">Violin</option>
                    <option value="Flute">Flute</option>
                    <option value="Vocal">Vocal</option>
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
                  <th>Status</th>
                  <th>Reward Earned</th>
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