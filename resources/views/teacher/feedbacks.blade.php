@extends('layouts.teacher')
@section('content')

      <div class="card">
        <div class="card-header d-flex align-center justify-between">
          <h4 class="font-semibold" style="font-family: var(--font-serif); font-size: 1.25rem;">Feedbacks Given to Me
          </h4>
        </div>
        <div class="card-body p-3">
          <table class="table display responsive nowrap" id="teacherFbTable" style="width:100%">
            <thead>
              <tr>
                <th>Date</th>
                <th>Student Name</th>
                <th>Rating</th>
                <th>Review Message</th>
              </tr>
            </thead>
            <tbody id="teacherFbBody">
              <!-- Loaded Dynamically -->
            </tbody>
          </table>
        </div>
      </div>
    
@endsection