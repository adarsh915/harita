<?php
function extractAndAppendStyle($htmlPath, $bladePath) {
    if (!file_exists($htmlPath) || !file_exists($bladePath)) {
        return;
    }
    
    $htmlContent = file_get_contents($htmlPath);
    preg_match('/<style>([\s\S]*?)<\/style>/i', $htmlContent, $matches);
    
    if (isset($matches[1])) {
        $styleContent = trim($matches[1]);
        if (empty($styleContent)) return;
        
        $bladeContent = file_get_contents($bladePath);
        
        if (!str_contains($bladeContent, '@push(\'styles\')')) {
            $pushBlock = "\n@push('styles')\n<style>\n$styleContent\n</style>\n@endpush\n";
            $bladeContent = str_replace('@section(\'content\')', $pushBlock . "\n@section('content')", $bladeContent);
            file_put_contents($bladePath, $bladeContent);
            echo "Added styles to " . basename($bladePath) . "\n";
        }
    }
}

$baseHtml = 'd:/all_project/harita-project/Harita Music Academy Admin Panel';
$baseBlade = 'd:/all_project/harita-project/harita/resources/views';

$htmlFiles = [
    'admin/class-booking.html' => 'admin/class-booking/index.blade.php',
    'admin/dashboard.html' => 'admin/dashboard/index.blade.php',
    'admin/demos.html' => 'admin/demos/index.blade.php',
    'admin/payroll.html' => 'admin/payroll/index.blade.php',
    'admin/profile.html' => 'admin/profile/index.blade.php',
    'admin/reports.html' => 'admin/reports/index.blade.php',
    'admin/roles.html' => 'admin/roles/index.blade.php',
    'admin/sales.html' => 'admin/sales/index.blade.php',
    'admin/students.html' => 'admin/students/index.blade.php',
    
    'student/dashboard.html' => 'student/dashboard.blade.php',
    'student/feedback.html' => 'student/feedbacks.blade.php',
    'student/my-classes.html' => 'student/my-classes.blade.php',
    'student/profile.html' => 'student/profile.blade.php',
    'student/referrals.html' => 'student/referrals.blade.php',
    
    'teacher/dashboard.html' => 'teacher/dashboard.blade.php',
    'teacher/my-classes.html' => 'teacher/my-classes.blade.php',
    'teacher/payroll.html' => 'teacher/payroll.blade.php',
    'teacher/profile.html' => 'teacher/profile.blade.php',
    'teacher/referrals.html' => 'teacher/referrals.blade.php',
];

foreach ($htmlFiles as $html => $blade) {
    extractAndAppendStyle("$baseHtml/$html", "$baseBlade/$blade");
}

echo "Done extracting all styles\n";
?>
