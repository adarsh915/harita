@extends('layouts.student')
@section('content')

      <div class="feedback-grid">

        <!-- Feedback Form -->
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold" style="font-family: var(--font-serif); font-size: 1.25rem;">Submit New Feedback
            </h4>
          </div>
          <div class="card-body p-4">
            <form id="feedbackForm" onsubmit="submitFeedbackForm(event)">
              <div class="form-group mb-3">
                <label class="form-label font-semibold">Feedback Category</label>
                <select id="fbCategory" class="form-control" required onchange="toggleCategoryTarget()">
                  <option value="Mentor">Mentor (Teacher)</option>
                  <option value="System">System (App & Performance)</option>
                  <option value="Academy">Academy (Overall Facility)</option>
                </select>
              </div>

              <div class="form-group mb-3" id="mentorSelectGroup">
                <label class="form-label font-semibold">Select Teacher</label>
                <select id="fbTarget" class="form-control">
                  <option value="Meera Sharma">Meera Sharma</option>
                  <option value="Pandit Ravi Sen">Pandit Ravi Sen</option>
                </select>
              </div>

              <div class="form-group mb-3">
                <label class="form-label font-semibold">Star Rating</label>
                <div class="star-rating-container" id="starRating">
                  <span class="star-item" data-value="1" onclick="setRating(1)">★</span>
                  <span class="star-item" data-value="2" onclick="setRating(2)">★</span>
                  <span class="star-item" data-value="3" onclick="setRating(3)">★</span>
                  <span class="star-item" data-value="4" onclick="setRating(4)">★</span>
                  <span class="star-item" data-value="5" onclick="setRating(5)">★</span>
                </div>
                <input type="hidden" id="fbRating" value="5" required>
              </div>

              <div class="form-group mb-3">
                <label class="form-label font-semibold">Your Review Message</label>
                <textarea id="fbMessage" class="form-control" rows="4" placeholder="Tell us about your experience..."
                  required></textarea>
              </div>

              <button type="submit" class="btn btn-primary w-100">Submit Review</button>
            </form>
          </div>
        </div>

        <!-- Feedback Log History -->
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold" style="font-family: var(--font-serif); font-size: 1.25rem;">My Feedback History
            </h4>
          </div>
          <div class="card-body p-3">
            <table class="table display responsive nowrap" id="fbHistoryTable" style="width:100%">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Category</th>
                  <th>Target</th>
                  <th>Rating</th>
                  <th>Message</th>
                </tr>
              </thead>
              <tbody id="fbHistoryBody">
                <!-- Loaded Dynamically -->
              </tbody>
            </table>
          </div>
        </div>

      </div>
    
@endsection