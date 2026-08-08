<?php

$viewsDir = 'd:/all_project/harita-project/harita/resources/views/admin';
$files = glob("$viewsDir/*.blade.php");

$routeMap = [
    'dashboard.html' => 'admin.dashboard',
    'class-booking.html' => 'admin.class-booking',
    'credits.html' => 'admin.credits',
    'demos.html' => 'admin.demos',
    'feedbacks.html' => 'admin.feedbacks',
    'leaves.html' => 'admin.leaves',
    'payroll.html' => 'admin.payroll',
    'profile.html' => 'admin.profile',
    'referrals.html' => 'admin.referrals',
    'reports.html' => 'admin.reports',
    'roles.html' => 'admin.roles',
    'sales.html' => 'admin.sales',
    'settings.html' => 'admin.settings',
    'students.html' => 'admin.students',
    'teachers.html' => 'admin.teachers',
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Replace href="xyz.html" with route
    foreach ($routeMap as $html => $route) {
        $content = str_replace('href="' . $html . '"', 'href="{{ route(\'' . $route . '\') }}"', $content);
    }
    
    // Also replace href="../login.html" with just "/" or a route
    $content = str_replace('href="../login.html"', 'href="/"', $content);
    
    file_put_contents($file, $content);
    echo "Updated routes in " . basename($file) . "\n";
}

// Now patch app.js
$appJs = 'd:/all_project/harita-project/harita/public/admin-assets/js/app.js';
$jsContent = file_get_contents($appJs);

// 1. Fix setupSidebarNavigation active class logic
$oldActiveLogic = 'const href = link.getAttribute("href");
    if (href === pageName || (pageName === "" && href === "dashboard.html")) {
      item.classList.add("active");
    } else {
      item.classList.remove("active");
    }';

$newActiveLogic = 'const href = link.getAttribute("href");
    if (href && window.location.href.includes(href)) {
      item.classList.add("active");
    } else {
      item.classList.remove("active");
    }';
$jsContent = str_replace($oldActiveLogic, $newActiveLogic, $jsContent);

// 2. Fix role visibility logic
$oldRoleLogic = 'const page = link.getAttribute("href");
    
    // Admin only pages
    if (["students.html", "teachers.html", "sales.html", "roles.html", "reports.html", "credits.html", "demos.html"].includes(page)) {';

$newRoleLogic = 'const page = link.getAttribute("href") || "";
    
    // Admin only pages
    if (page.includes("students") || page.includes("teachers") || page.includes("sales") || page.includes("roles") || page.includes("reports") || page.includes("credits") || page.includes("demos")) {';
$jsContent = str_replace($oldRoleLogic, $newRoleLogic, $jsContent);

// 3. Fix dynamically inserted DOM links for role logic in setupSidebarNavigation
// From: <a href="referrals.html" class="sidebar-item-link">
// To: <a href="/admin/referrals" class="sidebar-item-link">
$jsContent = str_replace('<a href="referrals.html"', '<a href="/admin/referrals"', $jsContent);
$jsContent = str_replace('<a href="feedback.html"', '<a href="/admin/feedbacks"', $jsContent);
$jsContent = str_replace('<a href="feedbacks.html"', '<a href="/admin/feedbacks"', $jsContent);
$jsContent = str_replace('<a href="payroll.html"', '<a href="/admin/payroll"', $jsContent);
$jsContent = str_replace('<a href="demos.html"', '<a href="/admin/demos"', $jsContent);

file_put_contents($appJs, $jsContent);
echo "Patched app.js\n";

?>
