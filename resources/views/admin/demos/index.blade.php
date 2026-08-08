@extends('layouts.main')
@section('title', 'Demo Classes')
@section('page', 'demos')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
.stat-card-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.25rem;
      margin-bottom: 1.5rem;
    }

    @media (max-width: 992px) {
      .stat-card-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 576px) {
      .stat-card-grid {
        grid-template-columns: 1fr;
      }
    }

    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: var(--radius-md);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      transition: all 0.2s;
      flex-shrink: 0;
    }

    .badge-select {
      font-size: 11.5px;
      font-weight: 600;
      padding: 0.25rem 0.5rem;
      border-radius: var(--radius-sm);
      outline: none;
      transition: all 0.2s;
      cursor: pointer;
    }
</style>
@endpush

@section('content')
<!-- KPI Stats -->
      <div class="stat-card-grid">
        <div class="card stat-card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: #eff6ff; color: #1e40af">📅</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Scheduled Demos</div>
            <h3 id="statScheduled" class="font-bold">{{ $demos->where('status', 'scheduled')->count() }}</h3>
          </div>
        </div>
        <div class="card stat-card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: var(--success-bg); color: var(--success)">✔️</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Completed Demos</div>
            <h3 id="statCompleted" class="font-bold">{{ $demos->where('status', 'completed')->count() }}</h3>
          </div>
        </div>
        <div class="card stat-card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: #fef3c7; color: #b45309;">👤</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Converted Students</div>
            <h3 id="statConverted" class="font-bold">{{ $demos->where('status', 'converted')->count() }}</h3>
          </div>
        </div>
        <div class="card stat-card p-3 d-flex align-center gap-3">
          <div class="stat-icon" style="background-color: #fee2e2; color: #b91c1c;">❌</div>
          <div>
            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Cancelled / No Show</div>
            <h3 id="statCancelled" class="font-bold">{{ $demos->whereIn('status', ['cancelled', 'no-show'])->count() }}</h3>
          </div>
        </div>
      </div>

      <!-- Demo Classes Log -->
      <div class="card">
        <div class="card-header d-flex align-center justify-between flex-wrap gap-2">
          <h4 class="font-semibold" style="font-family: var(--font-serif); font-size: 1.25rem;">Demo Session Ledger</h4>
          <button class="btn btn-primary" onclick="openAddDemoModal()">+ Add Demo</button>
        </div>
        <div class="card-body p-3" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
          <table class="table display responsive nowrap" id="demosTable" style="width:100%">
            <thead>
              <tr>
                <th data-priority="7">Demo ID</th>
                <th data-priority="1">Student Name</th>
                <th data-priority="3">Instrument</th>
                <th data-priority="4">Assigned Teacher</th>
                <th data-priority="5">Scheduled Date &amp; Time</th>
                <th data-priority="6">Duration</th>
                <th data-priority="1">Status (Update Inline)</th>
              </tr>
            </thead>
            <tbody id="demosTableBody">
              @foreach($demos as $demo)
              <tr>
                  <td class="font-bold text-primary">DMO{{ str_pad($demo->id, 3, '0', STR_PAD_LEFT) }}</td>
                  <td class="font-semibold">{{ $demo->student_name }}</td>
                  <td><span class="badge badge-primary">{{ $demo->instrument }}</span></td>
                  <td>{{ $demo->teacher->user->name ?? 'N/A' }}</td>
                  <td>{{ $demo->scheduled_at->format('M d, Y h:i A') }}</td>
                  <td>{{ $demo->duration_minutes }} mins</td>
                  <td>
                    @if($demo->status === 'converted')
                        <span class="badge badge-success" style="background-color: #fef3c7; color: #b45309; border: 1px solid #f59e0b;">Converted</span>
                        <div style="font-size:10px; margin-top:2px;">(Student: {{ $demo->convertedStudent->user->name ?? 'N/A' }})</div>
                    @else
                        <form action="{{ route('admin.demos.status', $demo) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control badge-select" onchange="handleStatusChange(this, {{ $demo->id }})" style="
                                @if($demo->status == 'scheduled') background-color: #eff6ff; color: #1e40af; border: 1px solid #3b82f6;
                                @elseif($demo->status == 'completed') background-color: var(--success-bg); color: var(--success); border: 1px solid var(--success);
                                @elseif($demo->status == 'cancelled') background-color: #f3f4f6; color: #374151; border: 1px solid #9ca3af;
                                @elseif($demo->status == 'no-show') background-color: #fee2e2; color: #b91c1c; border: 1px solid #ef4444;
                                @endif
                            ">
                                <option value="scheduled" {{ $demo->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="completed" {{ $demo->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $demo->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="no-show" {{ $demo->status == 'no-show' ? 'selected' : '' }}>No Show</option>
                                <option value="convert_trigger" style="color: #b45309; font-weight: bold;"
                                    data-name="{{ $demo->student_name }}"
                                    data-email="{{ $demo->email }}"
                                    data-phone="{{ $demo->phone }}"
                                    data-instrument="{{ $demo->instrument }}"
                                    data-teacher-id="{{ $demo->teacher_id }}"
                                >➡️ Convert to Student</option>
                            </select>
                        </form>
                    @endif
                  </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

  <!-- ADD DEMO MODAL -->
  <div id="addDemoModal" class="modal-backdrop">
    <div class="modal" style="max-width: 500px;">
      <div class="modal-header">
        <h3 class="font-semibold text-serif">Schedule Demo Class</h3>
        <button class="modal-close" onclick="closeAddDemoModal()">×</button>
      </div>
      <form action="{{ route('admin.demos.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group mb-3">
              <label class="form-label">Student Name</label>
              <input type="text" name="student_name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Instrument / Class Type</label>
              <input type="text" name="instrument" class="form-control" placeholder="e.g. Carnatic Vocal, Sitar" required>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Assign Teacher</label>
              <select name="teacher_id" class="form-control" required>
                  <option value="">Select a Teacher</option>
                  @foreach($teachers as $teacher)
                      <option value="{{ $teacher->id }}">{{ $teacher->user->name }} ({{ implode(', ', $teacher->instruments ?? []) }})</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Scheduled Date & Time</label>
              <input type="datetime-local" name="scheduled_at" class="form-control" required>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Duration (Minutes)</label>
              <input type="number" name="duration_minutes" class="form-control" value="40" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeAddDemoModal()">Cancel</button>
          <button type="submit" class="btn btn-primary">Schedule Demo</button>
        </div>
      </form>
    </div>
  </div>


  <!-- CONVERT TO STUDENT MODAL -->
  <div id="convertToStudentModal" class="modal-backdrop">
    <div class="modal" style="max-width: 800px;">
      <div class="modal-header">
        <h3 class="font-semibold text-serif">Convert Lead to Student</h3>
        <button class="modal-close" type="button" onclick="closeConvertModal()">×</button>
      </div>
      <form id="convertForm" method="POST">
        @csrf
        <div class="modal-body">
          <div class="grid grid-2 gap-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div class="form-group">
              <label class="form-label" for="convertCode">Student ID Code</label>
              <input type="text" id="convertCode" name="student_code" class="form-control" placeholder="e.g. HMAST000051" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="convertName">Full Name</label>
              <input type="text" id="convertName" name="name" class="form-control" required>
            </div>
          </div>

          <div class="grid grid-2 gap-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div class="form-group">
              <label class="form-label" for="convertEmail">Email Address</label>
              <input type="email" id="convertEmail" name="email" class="form-control" required placeholder="e.g. rajesh@example.com">
            </div>
            <div class="form-group">
              <label class="form-label" for="convertPhone">Phone Number</label>
              <input type="text" id="convertPhone" name="phone" class="form-control" required placeholder="e.g. +91 98234 56789">
            </div>
          </div>

          <div class="grid grid-2 gap-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div class="form-group">
              <label class="form-label" for="convertLevel">Initial Level</label>
              <select id="convertLevel" name="enrolled_level" class="form-control" required>
                <option value="Foundation Level">Foundation Level</option>
                <option value="Intermediate Level">Intermediate Level</option>
                <option value="Advanced Level">Advanced Level</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label" for="convertInstrument">Instrument Category</label>
              <input type="text" id="convertInstrument" name="instrument" class="form-control" required>
            </div>
          </div>

          <div class="grid grid-2 gap-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div class="form-group">
              <label class="form-label" for="convertTeacher">Assigned Teacher</label>
              <select id="convertTeacher" name="teacher_id" class="form-control" required>
                  <option value="">Select a Teacher</option>
                  @foreach($teachers as $teacher)
                      <option value="{{ $teacher->id }}">{{ $teacher->user->name }} ({{ implode(', ', $teacher->instruments ?? []) }})</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">
              <label class="form-label" for="convertPackage">Selected Package</label>
              <select id="convertPackage" name="package" class="form-control" onchange="updatePackageCost()" required>
                <option value="">Select Package</option>
                <option value="12000|12">Sitar Advanced (12 classes - ₹12,000)</option>
                <option value="8500|10">Vocal Basic (10 classes - ₹8,500)</option>
                <option value="4500|5">Violin Starter (5 classes - ₹4,500)</option>
                <option value="16000|20">Tabla Intermediate (20 classes - ₹16,000)</option>
                <option value="0|0">Other / Custom</option>
              </select>
            </div>
          </div>

          <div class="grid grid-2 gap-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div class="form-group">
              <label class="form-label" for="convertAmount">Amount Paid (INR)</label>
              <input type="number" id="convertAmount" name="amount_paid" class="form-control" value="0" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="convertMode">Payment Mode</label>
              <select id="convertMode" name="payment_mode" class="form-control" required>
                <option value="UPI (PhonePe)">UPI (PhonePe)</option>
                <option value="UPI (GPay)">UPI (GPay)</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Cash">Cash</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeConvertModal()">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background-color: #5d151c; border-color: #5d151c;">Add Student & Register Sale</button>
        </div>
      </form>
    </div>
  </div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#demosTable').DataTable({
        "order": [[4, "desc"]], // Order by Scheduled Date
        "pageLength": 10,
        "language": {
            "search": "",
            "searchPlaceholder": "Search demos..."
        }
    });
});

function openAddDemoModal() {
    document.getElementById('addDemoModal').classList.add('show');
}

function closeAddDemoModal() {
    document.getElementById('addDemoModal').classList.remove('show');
}

function handleStatusChange(selectElement, demoId) {
    if (selectElement.value === 'convert_trigger') {
        // Reset the select dropdown to the previous value so it doesn't stay on "convert_trigger"
        selectElement.selectedIndex = 0; // Temporarily reset it
        
        // Populate modal data
        const option = selectElement.options[selectElement.options.length - 1];
        document.getElementById('convertName').value = option.getAttribute('data-name');
        document.getElementById('convertEmail').value = option.getAttribute('data-email');
        document.getElementById('convertPhone').value = option.getAttribute('data-phone');
        document.getElementById('convertInstrument').value = option.getAttribute('data-instrument');
        document.getElementById('convertTeacher').value = option.getAttribute('data-teacher-id');
        
        // Open convert modal
        let form = document.getElementById('convertForm');
        form.action = '/admin/demos/' + demoId + '/convert';
        document.getElementById('convertToStudentModal').classList.add('show');
    } else {
        // Normal status update, submit the form
        selectElement.form.submit();
    }
}

function updatePackageCost() {
    const pkg = document.getElementById('convertPackage').value;
    if (pkg) {
        const parts = pkg.split('|');
        if (parts.length > 1) {
            document.getElementById('convertAmount').value = parts[0];
        }
    } else {
        document.getElementById('convertAmount').value = 0;
    }
}

function closeConvertModal() {
    document.getElementById('convertToStudentModal').classList.remove('show');
}
</script>
@endpush
