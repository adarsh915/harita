<?php
// Fix Student Profile
$path = 'd:/all_project/harita-project/harita/resources/views/student/profile.blade.php';
if (file_exists($path)) {
    $c = file_get_contents($path);
    // Remove tabs
    $c = preg_replace('/<!-- Tab Buttons.*?<\/div>/s', '', $c, 1);
    // Remove Admin View
    $c = preg_replace('/<!-- =+.*?ADMIN PROFILE VIEW.*?<\/div>\s*<\/div>/s', '', $c);
    // Remove Teacher View
    $c = preg_replace('/<!-- =+.*?TEACHER PROFILE VIEW.*?<\/div>\s*<\/div>/s', '', $c);
    // Unhide Student View
    $c = str_replace('<div id="studentProfileView" class="profile-grid-layout tab-content" style="display:none;">', '<div id="studentProfileView" class="profile-grid-layout tab-content">', $c);
    // Fix Hero text
    $c = str_replace('Super Admin of Harita Music Academy', 'Student of Harita Music Academy', $c);
    file_put_contents($path, $c);
}

// Fix Teacher Profile
$path = 'd:/all_project/harita-project/harita/resources/views/teacher/profile.blade.php';
if (file_exists($path)) {
    $c = file_get_contents($path);
    $c = preg_replace('/<!-- Tab Buttons.*?<\/div>/s', '', $c, 1);
    $c = preg_replace('/<!-- =+.*?ADMIN PROFILE VIEW.*?<\/div>\s*<\/div>/s', '', $c);
    $c = preg_replace('/<!-- =+.*?STUDENT PROFILE VIEW.*?<\/div>\s*<\/div>/s', '', $c);
    $c = str_replace('<div id="teacherProfileView" class="profile-grid-layout tab-content" style="display:none;">', '<div id="teacherProfileView" class="profile-grid-layout tab-content">', $c);
    $c = str_replace('Super Admin of Harita Music Academy', 'Teacher at Harita Music Academy', $c);
    file_put_contents($path, $c);
}

// Fix Student Settings
$path = 'd:/all_project/harita-project/harita/resources/views/student/settings.blade.php';
if (file_exists($path)) {
    $c = file_get_contents($path);
    // Remove Admin only cards
    $c = preg_replace('/<!-- ACADEMY PROFILE.*?<\/div>\s*<\/div>/s', '', $c);
    $c = preg_replace('/<!-- SCHEDULING RULES.*?<\/div>\s*<\/div>/s', '', $c);
    // Remove Teacher specific fields
    $c = preg_replace('/<!-- Teacher-specific Fields -->.*?<\/div>\s*<\/div>/s', '', $c);
    file_put_contents($path, $c);
}

// Fix Teacher Settings
$path = 'd:/all_project/harita-project/harita/resources/views/teacher/settings.blade.php';
if (file_exists($path)) {
    $c = file_get_contents($path);
    $c = preg_replace('/<!-- ACADEMY PROFILE.*?<\/div>\s*<\/div>/s', '', $c);
    $c = preg_replace('/<!-- SCHEDULING RULES.*?<\/div>\s*<\/div>/s', '', $c);
    // Unhide teacher fields
    $c = str_replace('<div id="teacherFields" style="display: none;', '<div id="teacherFields" style="display: block;', $c);
    file_put_contents($path, $c);
}

echo "Profiles and Settings Fixed";
?>
