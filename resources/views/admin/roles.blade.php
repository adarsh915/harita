@extends('layouts.admin')
@section('content')


      <!-- TABS CONTAINER -->
      <div class="tabs-container">
        <button class="tab-btn active" onclick="showTab('usersTab', this)">👥 User Accounts</button>
        <button class="tab-btn" onclick="showTab('permissionsTab', this)">🔑 Role Permissions</button>
      </div>

      <!-- TAB 1: USERS MANAGEMENT -->
      <div id="usersTab" class="tab-content user-grid slide-up">

        <!-- Left: Form to Add/Edit User -->
        <div class="card p-3">
          <h4 class="font-semibold mb-3 text-serif" id="userFormTitle">Add New System User</h4>
          <form id="userAccountForm" onsubmit="submitSaveUser(event)">
            <input type="hidden" id="formUserId">

            <div class="form-group mb-3">
              <label class="form-label" for="userName">Full Name / Username</label>
              <input type="text" id="userName" class="form-control" placeholder="e.g. Ramesh Kumar" required>
            </div>

            <div class="form-group mb-3">
              <label class="form-label" for="userEmail">Email ID (Login Username)</label>
              <input type="email" id="userEmail" class="form-control" placeholder="e.g. ramesh@haritamusic.com"
                required>
            </div>

            <div class="form-group mb-3">
              <label class="form-label" for="userPassword">Login Password</label>
              <input type="text" id="userPassword" class="form-control" placeholder="Minimum 6 characters" required>
            </div>

            <div class="form-group mb-3">
              <label class="form-label" for="userRole">Assigned Access Role</label>
              <select id="userRole" class="form-control" required>
                <option value="Admin">Admin (Full Control)</option>
                <option value="Teacher">Teacher (Mentor Panel)</option>
                <option value="Student">Student (Learning Center)</option>
              </select>
            </div>

            <div class="form-group mb-3">
              <label class="form-label" for="userStatus">Account Status</label>
              <select id="userStatus" class="form-control" required>
                <option value="Active">Active / Enabled</option>
                <option value="Inactive">Inactive / Disabled</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2" id="btnSaveUser">Create Account</button>
            <button type="button" class="btn btn-secondary w-100" id="btnCancelEdit" style="display: none;"
              onclick="resetUserForm()">Cancel Edit</button>
          </form>
        </div>

        <!-- Right: Registered Users Ledger Table -->
        <div class="card p-3" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
          <h4 class="font-semibold mb-3 text-serif">Registered Accounts Directory</h4>
          <table class="table display responsive nowrap" id="usersTable" style="width:100%">
            <thead>
              <tr>
                <th data-priority="7">User ID</th>
                <th data-priority="1">Name</th>
                <th data-priority="3">Email ID</th>
                <th data-priority="4">Password</th>
                <th data-priority="2">Role</th>
                <th data-priority="5">Status</th>
                <th data-priority="1" style="width: 80px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody id="usersTableBody">
              <!-- Populated via Javascript -->
            </tbody>
          </table>
        </div>

      </div>

      <!-- TAB 2: ROLE PERMISSIONS MATRIX -->
      <div id="permissionsTab" class="tab-content role-grid slide-up" style="display: none;">
        <!-- Sidebar Select Roles (Rendered dynamically) -->
        <div id="roleListContainer">
          <!-- Populated via Javascript -->
        </div>

        <!-- Permission Matrix Card -->
        <div class="card">
          <div class="card-header">
            <h4 class="font-semibold text-serif"><span id="activeRoleName">Administrator</span> - Module Access matrix
            </h4>
            <button class="btn btn-primary btn-sm" onclick="savePermissions()">Save Permission Schema</button>
          </div>
          <div class="card-body p-0">
            <div class="permission-row permission-header">
              <div>Module Area</div>
              <div class="text-center">Read</div>
              <div class="text-center">Write</div>
              <div class="text-center">Delete</div>
              <div class="text-center">Approve</div>
            </div>
            <div id="permissionsContainer">
              <!-- Rendered via JS -->
            </div>
          </div>
        </div>
      </div>

    
@endsection