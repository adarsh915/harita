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
      border-radius: var(--radius-lg);
      padding: 1.1rem;
      box-shadow: var(--shadow-sm);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .student-card-banner {
      display: flex;
      align-items: center;
      gap: 1.25rem;
      background-color: var(--bg-card);
      background: linear-gradient(135deg, rgba(13, 148, 136, 0.02) 0%, rgba(20, 85, 61, 0.05) 100%);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-lg);
      padding: 1.1rem;
      box-shadow: var(--shadow-sm);
      position: relative;
    }

    .student-card-banner img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      border: 2.5px solid var(--primary);
      z-index: 2;
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
        <li class="sidebar-item" id="nav-classes">
          <a href="my-classes.html" class="sidebar-item-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
              <circle cx="9" cy="7" r="4" />
              <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
              <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
            <span>My Classes</span>
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
            <span>My Credits</span>
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

      <!-- Sidebar Philosophy Card -->
      <div class="sidebar-promo-card"
        style="padding: 1.15rem 1rem; text-align: left; background: linear-gradient(135deg, #f0fdf4 0%, #d1fae5 100%); border: 1px solid #a7f3d0; margin: 1rem 0.75rem; border-radius: var(--radius-md);">
        <span class="sidebar-promo-icon"
          style="font-size: 1.5rem; margin-bottom: 0.25rem; display: inline-block;">✨</span>
        <h4 class="sidebar-promo-title"
          style="font-weight: 700; font-size: 0.85rem; color: var(--primary-dark); margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.5px;">
          Academy Mission</h4>
        <p class="sidebar-promo-desc"
          style="font-size: 11px; color: #065f46; line-height: 1.45; margin-bottom: 0; font-weight: 500;">
          Harita Music Academy, learning is more than just practicing notes and melodies.</p>
      </div>


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

  <!-- jQuery & DataTables Script dependencies -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="{{ asset('admin/js/') }}/app.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('admin/js/') }}/charts.js"></script>
  <script>
    let dtTransactions = null;

    // Initialize transaction log in storage if not exists
    if (!localStorage.getItem("harita_credit_logs")) {
      const defaultLogs = [
        { time: "2026-07-22 10:30", name: "Aria Sharma", action: "+20 Credits", reason: "Tabla Intermediate 20-Class Package" },
        { time: "2026-07-20 16:15", name: "Ananya Iyer", action: "+10 Credits", reason: "Vocal Basic 10-Class Package" },
        { time: "2026-07-18 19:40", name: "Rohan Malhotra", action: "+12 Credits", reason: "Sitar Advanced 12-Class Package" },
        { time: "2026-07-15 14:00", name: "Sarah Fernandez", action: "-1 Credit", reason: "Violin Class Completed" }
      ];
      localStorage.setItem("harita_credit_logs", JSON.stringify(defaultLogs));
    }

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

        // document.getElementById('adminTotalStudents').textContent = students.length;
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
                <button class="btn btn-secondary btn-sm p-1 px-2" style="font-size: 0.7rem;" onclick="window.location.href='my-classes.html'">Reschedule</button>
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
        loadCreditLogs();
      }
    }

    function renderDashboardCharts() {
      const role = db.getCurrentRole();
      if (role === 'admin') {
        ChartManager.drawLineChart("revenueLineChart", [22000, 29000, 31000, 25000, 41000], ["Mar", "Apr", "May", "Jun", "Jul"]);
        ChartManager.drawBarChart("instrumentBarChart", [15, 8, 12, 5, 9], ["Vocal", "Sitar", "Violin", "Flute", "Tabla"]);
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
    function loadCreditLogs() {
      const role = db.getCurrentRole();
      const tbody = document.getElementById("transactionTableBody");
      if (!tbody) return;

      if (dtTransactions) {
        dtTransactions.destroy();
      }
      tbody.innerHTML = "";

      let logs = JSON.parse(localStorage.getItem("harita_credit_logs")) || [];

      // Filter by current student name (Ananya Iyer) if role is student
      if (role === 'student') {
        logs = logs.filter(log => log.name.includes("Ananya") || log.name === "Ananya Iyer");
      }

      logs.forEach(log => {
        const tr = document.createElement("tr");
        const actionClass = log.action.startsWith('+') ? 'text-success' : 'text-danger';
        const qty = log.action.replace(/[+\-\sCredits]/g, '');

        tr.innerHTML = `
          <td>${log.time}</td>
          <td class="font-semibold">${log.name}</td>
          <td class="font-bold ${actionClass}">${log.action}</td>
          <td>${qty}</td>
          <td>${log.reason}</td>
        `;
        tbody.appendChild(tr);
      });

      dtTransactions = setupDataTable("transactionsTable");
    }
    
    function showTeacherProfileModal(teacherName) {
      const modal = document.getElementById("teacherProfileModal");
      const body = document.getElementById("teacherProfileModalBody");
      if (!modal || !body) return;

      const teachers = db.getTeachers() || [];
      let tch = teachers.find(t => t.name === teacherName || t.name.includes(teacherName));

      if (!tch) {
        tch = {
          name: teacherName,
          instruments: ["Sitar", "Vocal"],
          bio: "Senior classical music mentor at Harita Music Academy.",
          certifications: "Academy Mentor",
          youtube: ""
        };
      }

      // Helper function to extract embed URL
      const getEmbedUrl = (url) => {
        if (!url) return null;
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        if (match && match[2].length === 11) {
          return "https://www.youtube.com/embed/" + match[2];
        }
        return null;
      };

      const embedUrl = getEmbedUrl(tch.youtube);
      let youtubeHtml = "";
      if (embedUrl) {
        youtubeHtml = `
          <div class="mt-3" style="border-top: 1px solid var(--border-light); padding-top: 0.75rem;">
            <h4 class="font-bold" style="font-size: 0.85rem; margin-bottom: 0.4rem; color: var(--primary);">Featured Performance</h4>
            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
              <iframe src="${embedUrl}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
        `;
      } else {
        youtubeHtml = `
          <div class="mt-3 p-3 text-center text-muted" style="border: 1px dashed var(--border-color); border-radius: var(--radius-md); font-size: 0.8rem; background: var(--bg-body);">
            🎥 No featured performance video uploaded yet.
          </div>
        `;
      }

      body.innerHTML = `
        <div class="text-center mb-3">
          <div class="avatar avatar-lg mx-auto" style="width: 70px; height: 70px; font-size: 1.5rem; line-height: 70px; border-radius: 50%; background: var(--primary-light); color: var(--text-main); font-weight: bold; margin-bottom: 0.5rem; border: 2.5px solid var(--primary); display: flex; align-items: center; justify-content: center; margin-left: auto !important; margin-right: auto !important; float: none !important;">
            ${tch.name.split(' ').map(n => n[0]).join('')}
          </div>
          <h3 class="font-bold text-serif" style="font-size: 1.35rem; margin-bottom: 0.25rem;">${tch.name}</h3>
          <span class="badge badge-success" style="font-size: 0.75rem;">Academy Mentor</span>
        </div>
        <div class="info-list-item" style="display:flex; justify-content:space-between; padding:0.65rem 0; border-bottom:1px solid var(--border-light); font-size:0.85rem;">
          <span class="text-muted">Specialization</span>
          <span class="font-bold">${tch.instruments ? tch.instruments.join(", ") : (tch.instrument || "Vocal")}</span>
        </div>
        <div class="info-list-item" style="display:flex; justify-content:space-between; padding:0.65rem 0; border-bottom:1px solid var(--border-light); font-size:0.85rem;">
          <span class="text-muted">Expertise Level</span>
          <span class="font-semibold text-primary">${tch.level || "Senior Faculty / Acharya"}</span>
        </div>
        <div class="info-list-item" style="display:flex; justify-content:space-between; padding:0.65rem 0; border-bottom:1px solid var(--border-light); font-size:0.85rem;">
          <span class="text-muted">Certifications</span>
          <span class="font-semibold">${tch.certifications || "Academy Accredited"}</span>
        </div>
        <div class="mt-3" style="font-size: 0.82rem; line-height: 1.5; color: var(--text-muted); text-align: justify; border-top: 1px solid var(--border-light); padding-top: 0.75rem;">
          <b>Biography:</b> ${tch.bio || "Meera Sharma carries over 15 years of performance and pedagogy experience. Her teaching model follows direct Guru-Shishya tradition, helping students build technical mastery and soul-deep connection."}
        </div>
        ${youtubeHtml}
        <button class="btn btn-secondary w-100 mt-4" onclick="closeTeacherProfileModal()">Close Bio</button>
      `;

      modal.classList.add("show");
    }

    function closeTeacherProfileModal() {
      const modal = document.getElementById("teacherProfileModal");
      if (modal) modal.classList.remove("show");
    }
  </script>

  
  
  <!-- Teacher Profile Modal -->
  <div id="teacherProfileModal" class="modal-backdrop">
    <div class="modal" style="max-width: 550px;">
      <div class="modal-header">
        <h3 class="font-semibold text-serif">Mentor Biography</h3>
        <button class="modal-close" onclick="closeTeacherProfileModal()">×</button>
      </div>
      <div class="modal-body p-4" id="teacherProfileModalBody">
        <!-- Loaded dynamically -->
      </div>
    </div>
  </div>
</body>

</html>