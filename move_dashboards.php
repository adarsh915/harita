<?php
$base = 'd:/all_project/harita-project/harita/resources/views';

if (file_exists("$base/teacher/dashboard/index.blade.php")) {
    rename("$base/teacher/dashboard/index.blade.php", "$base/teacher/dashboard.blade.php");
    rmdir("$base/teacher/dashboard");
}

if (file_exists("$base/student/dashboard/index.blade.php")) {
    rename("$base/student/dashboard/index.blade.php", "$base/student/dashboard.blade.php");
    rmdir("$base/student/dashboard");
}

echo "Moved dashboards";
?>
