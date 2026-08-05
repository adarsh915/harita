<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Harita Music Academy</title>
  <link rel="stylesheet" href="{{ asset('admin/css/') }}/style.css">
  <link rel="stylesheet" href="{{ asset('admin/css/') }}/dashboard-layout.css">
  <style>
    /* Unique Dashboard Accent Elements */
    .welcome-banner {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: var(--text-white);
      padding: 1.5rem;
      border-radius: var(--radius-lg);
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      position: relative;
      overflow: hidden;
      border: 1px solid var(--primary-light);
    }

    .welcome-banner::after {
      content: "";
      position: absolute;
      right: -50px;
      bottom: -50px;
      width: 150px;
      height: 150px;
      background: radial-gradient(circle, var(--secondary) 0%, rgba(201, 174, 135, 0) 70%);
      opacity: 0.15;
      pointer-events: none;
    }

    .welcome-text h2 {
      color: var(--secondary-light);
      font-size: 1.5rem;
      margin-bottom: 0.25rem;
    }

    .welcome-text p {
      color: rgba(255, 255, 255, 0.8);
      font-size: 0.85rem;
    }

    .stat-card-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.25rem;
      margin-bottom: 1.5rem;
    }

    @media (max-width: 1024px) {
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
      width: 38px;
      height: 38px;
      font-size: 1.15rem;
      border-radius: var(--radius-md);
      background-color: var(--border-light);
      color: var(--primary);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .stat-card:hover .stat-icon {
      background-color: var(--primary);
      color: var(--text-white);
      transform: scale(1.05);
      transition: all 0.3s;
    }

    .chart-container {
      background-color: var(--bg-card);
      border-radius: var(--radius-md);
      border: 1px solid var(--border-color);
      padding: 1.25rem;
      box-shadow: var(--shadow-sm);
      height: 250px;
    }

    /* Student-Specific Ref Styles */
    .student-dashboard-layout {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      gap: 1.25rem;
      margin-bottom: 1.5rem;
    }

    @media (max-width: 1200px) {
      .student-dashboard-layout {
        grid-template-columns: 1fr;
      }
    }

    .student-card {
      background-color: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 1.25rem;
      box-shadow: var(--shadow-sm);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .student-card-banner {
      display: flex;
      align-items: center;
      gap: 1.25rem;
      background: linear-gradient(135deg, rgba(20, 85, 61, 0.02) 0%, rgba(201, 174, 135, 0.05) 100%);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 1rem;
    }

    .student-card-banner img {
      width: 70px;
      height: 70px;
      border-radius: var(--radius-round);
      object-fit: cover;
      border: 2px solid var(--secondary);
    }

    .student-class-box {
      background-color: var(--border-light);
      border-left: 4px solid var(--primary);
      padding: 0.85rem;
      border-radius: 0 var(--radius-md) var(--radius-md) 0;
      margin-bottom: 0.75rem;
    }

    .teacher-mini-profile {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin-top: 0.85rem;
      padding-top: 0.85rem;
      border-top: 1px solid var(--border-color);
    }

    .achievement-badge-container {
      display: flex;
      gap: 0.85rem;
      justify-content: space-around;
      margin-top: 0.85rem;
    }

    .achievement-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .achievement-circle {
      width: 44px;
      height: 44px;
      border-radius: var(--radius-round);
      border: 2px solid var(--secondary);
      background-color: var(--bg-main);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--secondary-dark);
      font-weight: 700;
      font-size: 0.85rem;
      margin-bottom: 0.35rem;
      box-shadow: var(--shadow-sm);
    }

    .recording-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.65rem 1rem;
      border-bottom: 1px solid var(--border-light);
    }

    .recording-item:last-child {
      border-bottom: none;
    }

    .btn-play {
      background-color: var(--border-light);
      border: none;
      width: 28px;
      height: 28px;
      border-radius: var(--radius-round);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--primary);
      transition: all 0.2s;
    }

    .btn-play:hover {
      background-color: var(--primary);
      color: var(--text-white);
    }
  </style>
</head>

<body>

  <!-- PRELOADER -->
  <div id="preloader" class="preloader-overlay">
    <div class="preloader-content">
      <img src="{{ asset('admin/assets/') }}/logo.png" class="preloader-logo" alt="Harita Logo">
      <div class="preloader-spinner"></div>
    </div>
  </div>

  <div class="app-container">

    <!-- SIDEBAR NAV -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="sidebar-logo">
          <img src="{{ asset('admin/assets/') }}/logo.png" width="36" height="36" alt="Harita Logo" style="object-fit: contain;">
          <div class="sidebar-brand-container">
            <h2 class="sidebar-brand-name">Harita</h2>
            <span class="sidebar-brand-sub">Music Academy</span>
          </div>
          <button class="desktop-sidebar-toggle-btn" onclick="toggleSidebarCollapse()" title="Toggle Sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="12" x2="21" y2="12" />
              <line x1="3" y1="6" x2="21" y2="6" />
              <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
          </button>
        </div>
      </div>

      <ul class="sidebar-menu">
        <li class="sidebar-item" id="nav-dashboard" class="sidebar-item active">
          <a href="dashboard.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
              <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="sidebar-item" id="nav-students">
          <a href="students.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
              <circle cx="9" cy="7" r="4" />
              <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
              <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
            <span>Student Master</span>
          </a>
        </li>
        <li class="sidebar-item" id="nav-teachers">
          <a href="teachers.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
              <circle cx="12" cy="7" r="4" />
            </svg>
            <span>Teacher Master</span>
          </a>
        </li>
        <li class="sidebar-item" id="nav-credits">
          <a href="credits.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10" />
              <line x1="12" y1="8" x2="12" y2="16" />
              <line x1="8" y1="12" x2="16" y2="12" />
            </svg>
            <span>Credit Management</span>
          </a>
        </li>
        <li class="sidebar-item" id="nav-booking">
          <a href="class-booking.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
              <line x1="16" y1="2" x2="16" y2="6" />
              <line x1="8" y1="2" x2="8" y2="6" />
              <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            <span>Class Booking</span>
          </a>
        </li>
        <li class="sidebar-item" id="nav-leaves">
          <a href="leaves.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
              <polyline points="14 2 14 8 20 8" />
              <line x1="9" y1="15" x2="15" y2="15" />
              <line x1="9" y1="19" x2="15" y2="19" />
              <line x1="9" y1="11" x2="11" y2="11" />
            </svg>
            <span>Leave Approval</span>
          </a>
        </li>
        <li class="sidebar-item" id="nav-roles">
          <a href="roles.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
            <span>Access Control</span>
          </a>
        </li>
        <li class="sidebar-item" id="nav-sales">
          <a href="sales.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="20" x2="18" y2="10" />
              <line x1="12" y1="20" x2="12" y2="4" />
              <line x1="6" y1="20" x2="6" y2="14" />
            </svg>
            <span>Sales Dashboard</span>
          </a>
        </li>
        <li class="sidebar-item" id="nav-reports">
          <a href="reports.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21.21 15.89A10 10 0 1 1 8 2.83" />
              <path d="M22 12A10 10 0 0 0 12 2v10z" />
            </svg>
            <span>Reports Feed</span>
          </a>
        </li>
        <li class="sidebar-item" id="nav-profile">
          <a href="profile.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
              <circle cx="12" cy="7" r="4" />
            </svg>
            <span>My Profile</span>
          </a>
        </li>
        <li class="sidebar-item" id="nav-settings">
          <a href="settings.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="3" />
              <path
                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
            </svg>
            <span>Settings</span>
          </a>
        </li>
      </ul>




      <div class="sidebar-footer"
        style="padding: 1rem 0.75rem; display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; border-top: 1px solid #f1f5f9;">
        <div class="sidebar-user-card"
          style="margin-bottom: 0; display: flex; align-items: center; gap: 0.5rem; flex: 1; min-width: 0;">
          <div class="avatar" style="flex-shrink: 0;">AD</div>
          <div class="sidebar-user-info"
            style="min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
            <div class="sidebar-user-name"
              style="font-weight: 600; font-size: 13.5px; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
              Administrator</div>
            <div class="sidebar-user-role" style="font-size: 11px; color: var(--primary);">Super Admin</div>
          </div>
        </div>
        <a href="{{ route('login') }}" title="Log Out"
          style="color: var(--danger) !important; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; transition: background 0.2s; flex-shrink: 0;"
          onmouseover="this.style.background='var(--danger-bg)'" onmouseout="this.style.background='transparent'">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <polyline points="16 17 21 12 16 7" />
            <line x1="21" y1="12" x2="9" y2="12" />
          </svg>
        </a>
      </div>
    </aside>

    <!-- HEADER -->
    <header class="header">
      <div class="header-left">
        <button class="menu-toggle">☰</button>
        <div class="header-title-container">
          <span class="header-pre-title">Welcome back</span>
          <h1 class="header-title">Dashboard Overview</h1>
        </div>
      </div>

      <div class="header-right">
        <!-- Notification Dropdown -->
        <div class="header-profile-dropdown">
          <button class="header-icon-btn" data-toggle="dropdown" data-target="notificationDropdown">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
              <path d="M13.73 21a2 2 0 0 1-3.46 0" />
            </svg>
            <span class="badge-dot"></span>
          </button>
          <div id="notificationDropdown" class="dropdown-menu notification-dropdown">
            <div class="dropdown-header">Academy Notifications</div>
            <div class="notification-item">
              <div class="notification-item-icon">🔔</div>
              <div class="notification-item-content">
                <div class="notification-item-title">Leave Request pending</div>
                <div>Teacher Meera Sharma applied for 3 days of leave.</div>
                <div class="notification-item-time">10 minutes ago</div>
              </div>
            </div>
            <div class="notification-item">
              <div class="notification-item-icon">💳</div>
              <div class="notification-item-content">
                <div class="notification-item-title">Payment Received</div>
                <div>Aria Sharma bought Tabla 20-Class Package.</div>
                <div class="notification-item-time">2 hours ago</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="header-profile-dropdown">
          <button class="header-profile-trigger" data-toggle="dropdown" data-target="profileDropdown">
            <div class="avatar">AD</div>
          </button>
          <div id="profileDropdown" class="dropdown-menu">
            <div class="dropdown-header">User Menu</div>
            <a href="profile.html" class="dropdown-item">My Profile</a>
            <a href="settings.html" class="dropdown-item">Settings</a>
            <div style="border-top: 1px solid var(--border-color); margin: 0.25rem 0;"></div>
            <a href="{{ route('login') }}" class="dropdown-item" style="color: var(--danger)">Log Out</a>
          </div>
        </div>
      </div>
    </header>

    <!-- MAIN MAIN CONTENT -->
    <main class="main-content">
        @yield('content')
    </main>
  </div>

  <script src="{{ asset('admin/js/') }}/app.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('admin/js/') }}/charts.js"></script>
  <script>
    // Draw Charts when on Dashboard
    document.addEventListener("DOMContentLoaded", () => {
      renderDashboardCharts();
      populateDynamicMetrics();
    });

    function onRoleChange() {
      renderDashboardCharts();
      populateDynamicMetrics();
    }

    function populateDynamicMetrics() {
      const role = db.getCurrentRole();

      if (role === 'admin') {
        const students = db.getStudents();
        const teachers = db.getTeachers();
        const classes = db.getClasses();
        const sales = db.getSales();

        const totalSales = sales.reduce((acc, curr) => acc + curr.amount, 0);

        document.getElementById('adminTotalStudents').textContent = students.length;
        document.getElementById('adminTotalTeachers').textContent = teachers.length;
        document.getElementById('adminTodayClasses').textContent = classes.filter(c => c.status === 'Scheduled').length;
        document.getElementById('adminMonthlySales').textContent = "₹" + totalSales.toLocaleString('en-IN');
      }

      else if (role === 'teacher') {
        const classes = db.getClasses();
        const scheduleContainer = document.getElementById('teacherTodaySchedule');
        scheduleContainer.innerHTML = "";

        const meeraClasses = classes.filter(c => c.teacherName === "Meera Sharma" && c.status !== "Completed");

        if (meeraClasses.length === 0) {
          scheduleContainer.innerHTML = "<div class='text-muted p-2'>No scheduled classes for today.</div>";
        } else {
          meeraClasses.forEach(cls => {
            const dateObj = new Date(cls.dateTime);
            const timeStr = dateObj.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

            const div = document.createElement('div');
            div.className = "student-class-box";
            div.innerHTML = `
              <div class="font-semibold">${cls.studentName} - ${cls.instrument}</div>
              <div class="text-muted" style="font-size: 0.75rem;">Time: ${timeStr}</div>
              <div class="d-flex gap-2 mt-2">
                <button class="btn btn-primary btn-sm p-1 px-2" style="font-size: 0.7rem;" onclick="alert('Starting class session...')">Start Class</button>
                <button class="btn btn-secondary btn-sm p-1 px-2" style="font-size: 0.7rem;" onclick="window.location.href='class-booking.html'">Reschedule</button>
              </div>
            `;
            scheduleContainer.appendChild(div);
          });
        }

        ChartManager.drawProgressRing("teacherAvailabilityProgress", 90, "#059669");
        renderCalendarWidget();
      }

      else if (role === 'student') {
        ChartManager.drawProgressRing("studentProgressRing", 75, "#10b981");
        renderCalendarWidget();
      }
    }

    function renderDashboardCharts() {
      const role = db.getCurrentRole();
      if (role === 'admin') {
        ChartManager.drawLineChart("revenueLineChart", [22000, 29000, 31000, 25000, 41000], ["Mar", "Apr", "May", "Jun", "Jul"]);
        ChartManager.drawBarChart("instrumentBarChart", [15, 8, 12, 5, 9], ["Vocal", "Sitar", "Violin", "Flute", "Tabla"]);
        ChartManager.drawLineChart("studentsEnrolledChart", [12, 18, 25, 38, 50], ["Mar", "Apr", "May", "Jun", "Jul"]);
        ChartManager.drawBarChart("teachersOnboardedChart", [4, 8, 12, 18, 25], ["Mar", "Apr", "May", "Jun", "Jul"]);
      }
    }

    function renderCalendarWidget() {
      const container = document.getElementById("dashboardCalendar");
      if (!container) return;

      container.innerHTML = "";

      const startDay = 3;
      const totalDays = 31;

      const daysHeaders = ["S", "M", "T", "W", "T", "F", "S"];
      daysHeaders.forEach(day => {
        const div = document.createElement("div");
        div.className = "calendar-day-header";
        div.textContent = day;
        container.appendChild(div);
      });

      for (let i = 0; i < startDay; i++) {
        const div = document.createElement("div");
        div.className = "calendar-day-cell text-muted";
        div.innerHTML = "";
        container.appendChild(div);
      }

      for (let day = 1; day <= totalDays; day++) {
        const div = document.createElement("div");
        div.className = "calendar-day-cell";
        div.textContent = day;

        if (day === 24) {
          div.classList.add("today");
        }

        if (day === 24 || day === 26) {
          div.classList.add("active-class");
        }

        container.appendChild(div);
      }
    }
  </script>
</body>

</html>