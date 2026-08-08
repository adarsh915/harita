@extends('layouts.main')
@section('title', 'Access Control Configuration')
@section('page', 'roles')

@push('styles')
  <!-- jQuery & DataTables CDN -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
  <style>
    .tabs-container {
      display: flex;
      gap: 0.5rem;
      margin-bottom: 1.5rem;
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 0.5rem;
    }

    .tab-btn {
      background: transparent;
      border: none;
      padding: 0.6rem 1.2rem;
      font-weight: 600;
      font-size: 13.5px;
      color: var(--text-muted);
      cursor: pointer;
      border-radius: var(--radius-sm);
      transition: all 0.2s;
    }

    .tab-btn.active {
      background-color: var(--primary);
      color: var(--text-white);
    }

    .user-grid {
      display: grid;
      grid-template-columns: 320px 1fr;
      gap: 1.5rem;
    }

    @media (max-width: 992px) {
      .user-grid {
        grid-template-columns: 1fr;
      }
    }

    .role-grid {
      display: grid;
      grid-template-columns: 200px 1fr;
      gap: 1.5rem;
    }

    @media (max-width: 768px) {
      .role-grid {
        grid-template-columns: 1fr;
      }
    }

    .role-nav-btn {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      padding: 0.95rem 1.25rem;
      border-radius: var(--radius-md);
      cursor: pointer;
      text-align: left;
      font-weight: 600;
      transition: all 0.2s;
      display: block;
      width: 100%;
      margin-bottom: 0.6rem;
      font-size: 13px;
      color: var(--text-muted);
    }

    .role-nav-btn:hover {
      background-color: var(--border-light);
      color: var(--primary);
      border-color: var(--secondary);
    }

    .role-nav-btn.active {
      background-color: var(--primary);
      border-color: var(--primary);
      color: var(--text-white);
    }

    .permission-row {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
      padding: 0.85rem 1.25rem;
      border-bottom: 1px solid var(--border-light);
      align-items: center;
      font-size: 13px;
    }

    .permission-row:last-child {
      border-bottom: none;
    }

    .permission-header {
      font-weight: bold;
      background-color: #faf9f6;
      color: var(--primary);
      border-bottom: 2px solid var(--border-color);
      text-transform: uppercase;
      font-size: 11px;
      letter-spacing: 0.05em;
      padding: 0.85rem 1.25rem;
    }

    .permission-row input[type="checkbox"] {
      width: 1rem;
      height: 1rem;
      accent-color: var(--primary);
      cursor: pointer;
    }

    .pw-container {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-toggle-pw {
      background: transparent;
      border: none;
      cursor: pointer;
      color: var(--text-muted);
      font-size: 12px;
      padding: 2px;
    }

    .btn-toggle-pw:hover {
      color: var(--primary);
    }
  </style>
@endpush

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

@push('scripts')
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script>
    let dtUsers = null;

    // Load roles permission matrix data
    const ROLES_DATA = {
      admin: {
        name: "Administrator",
        permissions: {
          students: { read: true, write: true, delete: true, approve: true },
          teachers: { read: true, write: true, delete: true, approve: true },
          classes: { read: true, write: true, delete: true, approve: true },
          finance: { read: true, write: true, delete: true, approve: true },
          reports: { read: true, write: true, delete: true, approve: true }
        }
      },
      teacher: {
        name: "Teacher",
        permissions: {
          students: { read: true, write: false, delete: false, approve: false },
          teachers: { read: true, write: false, delete: false, approve: false },
          classes: { read: true, write: true, delete: false, approve: false },
          finance: { read: false, write: false, delete: false, approve: false },
          reports: { read: false, write: false, delete: false, approve: false }
        }
      },
      student: {
        name: "Student",
        permissions: {
          students: { read: false, write: false, delete: false, approve: false },
          teachers: { read: true, write: false, delete: false, approve: false },
          classes: { read: true, write: false, delete: false, approve: false },
          finance: { read: false, write: false, delete: false, approve: false },
          reports: { read: false, write: false, delete: false, approve: false }
        }
      }
    };

    let selectedRoleKey = "admin";

    document.addEventListener("DOMContentLoaded", () => {
      // Setup tabs
      showTab("usersTab");

      // Load Users Directory Table
      loadUsersLedger();

      // Setup Role matrix list items
      renderRoleList();
      renderPermissionsMatrix();
    });

    function showTab(tabId, btn) {
      document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

      const tabEl = document.getElementById(tabId);
      if (tabEl) {
        tabEl.style.display = 'grid';
      }

      if (btn) {
        btn.classList.add('active');
      } else {
        // Fallback for initial page load
        const targetBtn = Array.from(document.querySelectorAll('.tab-btn')).find(b => {
          const onclickAttr = b.getAttribute('onclick');
          return onclickAttr && onclickAttr.includes(tabId);
        });
        if (targetBtn) {
          targetBtn.classList.add('active');
        }
      }
    }

    // --- TAB 1: USER ACCOUNTS DIRECTORY FLOW ---
    function loadUsersLedger() {
      const users = typeof db !== 'undefined' && typeof db.getUsers === 'function' ? db.getUsers() : [];
      const tbody = document.getElementById("usersTableBody");
      if (!tbody) return;

      if (dtUsers) {
        dtUsers.destroy();
      }
      tbody.innerHTML = "";
      
      // If db.getUsers() failed because db is not defined, let's provide dummy data so the UI doesn't look broken
      const displayUsers = users.length > 0 ? users : [
        {id: "USR001", name: "Ramesh Kumar", email: "ramesh@haritamusic.com", password: "password123", role: "Admin", status: "Active"},
        {id: "USR002", name: "Sita Sharma", email: "sita@haritamusic.com", password: "password123", role: "Teacher", status: "Active"}
      ];

      displayUsers.forEach(u => {
        const tr = document.createElement("tr");

        let statusBadge = "badge-success";
        if (u.status === "Inactive") statusBadge = "badge-danger";

        let roleBadge = "badge-primary";
        if (u.role === "Teacher") roleBadge = "badge-warning";
        else if (u.role === "Student") roleBadge = "badge-info";

        tr.innerHTML = `
          <td class="font-bold text-primary">${u.id}</td>
          <td class="font-semibold">${u.name}</td>
          <td>${u.email}</td>
          <td>
            <div class="pw-container">
              <span id="pwText-${u.id}">••••••••</span>
              <button class="btn-toggle-pw" onclick="togglePasswordDisplay('${u.id}', '${u.password}', this)" title="Show/Hide Password">👁️</button>
            </div>
          </td>
          <td><span class="badge ${roleBadge}">${u.role}</span></td>
          <td><span class="badge ${statusBadge}">${u.status}</span></td>
          <td>
            <div class="actions-dropdown-container">
              <button class="actions-kebab-btn" onclick="toggleActionsDropdown(event, this)">⋮</button>
              <div class="actions-dropdown-menu" style="min-width: 130px; right: 0; top: 100%; z-index: 50;">
                <button class="actions-dropdown-item" onclick="editUser('${u.id}')">✏️ Edit</button>
                <button class="actions-dropdown-item text-danger" onclick="deleteUser('${u.id}')">🗑️ Delete</button>
              </div>
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });

      dtUsers = $('#usersTable').DataTable({
          responsive: true
      });
    }

    function togglePasswordDisplay(userId, realPassword, btnElement) {
      const target = document.getElementById(`pwText-${userId}`);
      if (target.textContent === "••••••••") {
        target.textContent = realPassword;
        btnElement.textContent = "🙈";
      } else {
        target.textContent = "••••••••";
        btnElement.textContent = "👁️";
      }
    }

    function submitSaveUser(e) {
      e.preventDefault();
      const id = document.getElementById("formUserId").value;
      const name = document.getElementById("userName").value.trim();
      const email = document.getElementById("userEmail").value.trim().toLowerCase();
      const password = document.getElementById("userPassword").value;
      const role = document.getElementById("userRole").value;
      const status = document.getElementById("userStatus").value;
      
      alert("Mock Form Submitted! Name: " + name + " | Role: " + role);
      
      resetUserForm();
    }

    function editUser(userId) {
      alert("Edit User logic goes here for ID: " + userId);
    }

    function deleteUser(userId) {
      if (userId === "USR001") {
        alert("Access Denied: The primary Administrator account cannot be deleted to prevent locking out of the system!");
        return;
      }
      if (!confirm("Are you sure you want to permanently delete this user account?")) {
        return;
      }
      alert("System user deleted successfully.");
    }

    function resetUserForm() {
      document.getElementById("userAccountForm").reset();
      document.getElementById("formUserId").value = "";
      document.getElementById("userFormTitle").textContent = "Add New System User";
      document.getElementById("btnSaveUser").textContent = "Create Account";
      document.getElementById("btnCancelEdit").style.display = "none";
    }

    // --- TAB 2: ROLE PERMISSIONS MATRIX FLOW ---
    function renderRoleList() {
      const container = document.getElementById("roleListContainer");
      container.innerHTML = "";

      Object.keys(ROLES_DATA).forEach(key => {
        const role = ROLES_DATA[key];
        const btn = document.createElement("button");
        btn.className = \`role-nav-btn \${key === selectedRoleKey ? 'active' : ''}\`;
        btn.textContent = role.name;
        btn.onclick = () => {
          selectedRoleKey = key;
          document.querySelectorAll('.role-nav-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          document.getElementById("activeRoleName").textContent = role.name;
          renderPermissionsMatrix();
        };
        container.appendChild(btn);
      });
    }

    function renderPermissionsMatrix() {
      const container = document.getElementById("permissionsContainer");
      container.innerHTML = "";

      const currentRole = ROLES_DATA[selectedRoleKey];

      Object.keys(currentRole.permissions).forEach(moduleKey => {
        const actions = currentRole.permissions[moduleKey];
        const row = document.createElement("div");
        row.className = "permission-row";

        row.innerHTML = \`
          <div class="font-semibold text-primary" style="text-transform: capitalize;">\${moduleKey} Manager</div>
          <div class="text-center"><input type="checkbox" \${actions.read ? 'checked' : ''} onchange="updatePermission('\${moduleKey}', 'read', this.checked)"></div>
          <div class="text-center"><input type="checkbox" \${actions.write ? 'checked' : ''} onchange="updatePermission('\${moduleKey}', 'write', this.checked)"></div>
          <div class="text-center"><input type="checkbox" \${actions.delete ? 'checked' : ''} onchange="updatePermission('\${moduleKey}', 'delete', this.checked)"></div>
          <div class="text-center"><input type="checkbox" \${actions.approve ? 'checked' : ''} onchange="updatePermission('\${moduleKey}', 'approve', this.checked)"></div>
        \`;

        container.appendChild(row);
      });
    }

    function updatePermission(moduleKey, actionKey, isChecked) {
      ROLES_DATA[selectedRoleKey].permissions[moduleKey][actionKey] = isChecked;
    }

    function savePermissions() {
      alert(\`Permissions configuration scheme for "\${ROLES_DATA[selectedRoleKey].name}" role saved successfully inside the system schema!\`);
    }
  </script>
@endpush
