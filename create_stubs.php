<?php
$base = 'd:/all_project/harita-project/harita/resources/views';

$teacherFiles = ['my-classes', 'leaves', 'payroll', 'feedbacks', 'referrals', 'profile', 'settings'];
$studentFiles = ['my-classes', 'feedbacks', 'referrals', 'profile', 'settings'];

function createStub($path, $role, $page) {
    if (!file_exists($path)) {
        $title = ucfirst($role) . ' ' . ucfirst(str_replace('-', ' ', $page));
        $content = "@extends('layouts.main')\n@section('title', '$title')\n@section('page', '$page')\n\n@section('content')\n<div class=\"card p-4 text-center mt-4\">\n  <h3>$title</h3>\n  <p class=\"text-muted\">This module is currently under construction.</p>\n</div>\n@endsection\n";
        file_put_contents($path, $content);
    }
}

foreach ($teacherFiles as $file) {
    createStub("$base/teacher/$file.blade.php", 'Teacher', $file);
}

foreach ($studentFiles as $file) {
    createStub("$base/student/$file.blade.php", 'Student', $file);
}

echo "Created stub files";
?>
