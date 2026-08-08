<?php
// Fix TeacherController
$c = file_get_contents('d:/all_project/harita-project/harita/app/Http/Controllers/Teacher/TeacherController.php');
$c = preg_replace("/view\('teacher\.([a-zA-Z0-9_-]+)\.index'/", "view('teacher.$1'", $c);
file_put_contents('d:/all_project/harita-project/harita/app/Http/Controllers/Teacher/TeacherController.php', $c);

// Fix StudentController
$c = file_get_contents('d:/all_project/harita-project/harita/app/Http/Controllers/Student/StudentController.php');
$c = preg_replace("/view\('student\.([a-zA-Z0-9_-]+)\.index'/", "view('student.$1'", $c);
file_put_contents('d:/all_project/harita-project/harita/app/Http/Controllers/Student/StudentController.php', $c);

echo "Reverted controllers view paths";
?>
