<?php
$viewsDir = 'd:/all_project/harita-project/harita/resources/views';

function refactorView($srcFile, $destDir, $pageName, $title) {
    if (!file_exists($srcFile)) {
        echo "Source file $srcFile not found, skipping.\n";
        return;
    }

    $content = file_get_contents($srcFile);

    // Extract styles
    preg_match('/<style>(.*?)<\/style>/s', $content, $styleMatches);
    $styles = isset($styleMatches[1]) ? trim($styleMatches[1]) : '';

    // Extract scripts
    preg_match('/<script>(.*?)<\/script>/s', $content, $scriptMatches);
    $scripts = isset($scriptMatches[1]) ? trim($scriptMatches[1]) : '';

    // Extract main content
    if (preg_match('/<main class="main-content">(.*?)<\/main>/s', $content, $contentMatches)) {
        $mainContent = trim($contentMatches[1]);
        // Strip the footer if it's there
        $mainContent = preg_replace('/<!-- Developed by Sitesoch footer -->(.*?)<\/footer>/s', '', $mainContent);
    } else {
        // Fallback for different container names
        preg_match('/<!-- ==========================================\s*ADMIN VIEW CONTAINER\s*========================================== -->(.*?)<!-- ==========================================\s*TEACHER VIEW CONTAINER\s*========================================== -->/s', $content, $contentMatches);
        $mainContent = isset($contentMatches[1]) ? trim($contentMatches[1]) : '';
        if (!$mainContent) {
            // fallback generic
            preg_match('/<div class="app-container">.*?<aside.*?<\/aside>.*?<header.*?<\/header>\s*(.*?)<\/div>/s', $content, $contentMatches);
            $mainContent = isset($contentMatches[1]) ? trim($contentMatches[1]) : $content;
        }
    }

    // Remove empty preloader
    $mainContent = preg_replace('/<!-- PRELOADER -->.*?<\/div>\s*<\/div>/s', '', $mainContent);

    // Extract modals
    preg_match_all('/<!-- (.*?) Modal -->(.*?)<!-- End (.*?) Modal -->/s', $mainContent, $modalMatches, PREG_SET_ORDER);
    $modalsHtml = '';
    foreach ($modalMatches as $match) {
        $modalsHtml .= "\n" . $match[0] . "\n";
        $mainContent = str_replace($match[0], '', $mainContent);
    }
    
    // Also extract modals just using <div id=".*?Modal"
    preg_match_all('/<div id="[a-zA-Z0-9]+Modal"[^>]*>.*?<\/div>\s*<\/div>\s*<\/div>/s', $mainContent, $modalMatches2);
    foreach ($modalMatches2[0] as $match) {
        if (!str_contains($modalsHtml, substr($match, 0, 50))) { // avoid double extraction
            $modalsHtml .= "\n" . $match . "\n";
            $mainContent = str_replace($match, '', $mainContent);
        }
    }

    $newBlade = "@extends('layouts.main')\n@section('title', '$title')\n@section('page', '$pageName')\n";

    if ($styles) {
        $newBlade .= "\n@push('styles')\n<style>\n$styles\n</style>\n@endpush\n";
    }

    $newBlade .= "\n@section('content')\n$mainContent\n@endsection\n";

    if ($modalsHtml) {
        $newBlade .= "\n@push('modals')\n$modalsHtml\n@endpush\n";
    }

    if ($scripts) {
        $newBlade .= "\n@push('scripts')\n<script>\n$scripts\n</script>\n@endpush\n";
    }

    if (!is_dir($destDir)) {
        mkdir($destDir, 0777, true);
    }
    
    file_put_contents("$destDir/index.blade.php", $newBlade);
    unlink($srcFile);
    echo "Refactored $srcFile to $destDir/index.blade.php\n";
}

$files = [
    'class-booking' => ['name' => 'Class Booking', 'page' => 'class-booking'],
    'credits'       => ['name' => 'Credit Management', 'page' => 'credits'],
    'demos'         => ['name' => 'Demo Classes', 'page' => 'demos'],
    'feedbacks'     => ['name' => 'Feedbacks', 'page' => 'feedbacks'],
    'leaves'        => ['name' => 'Leaves', 'page' => 'leaves'],
    'payroll'       => ['name' => 'Payroll', 'page' => 'payroll'],
    'profile'       => ['name' => 'Profile', 'page' => 'profile'],
    'referrals'     => ['name' => 'Referrals', 'page' => 'referrals'],
    'reports'       => ['name' => 'Reports', 'page' => 'reports'],
    'roles'         => ['name' => 'Access Control', 'page' => 'roles'],
    'sales'         => ['name' => 'Sales', 'page' => 'sales'],
    'settings'      => ['name' => 'Settings', 'page' => 'settings'],
    'students'      => ['name' => 'Students', 'page' => 'students'],
    'teachers'      => ['name' => 'Teachers', 'page' => 'teachers'],
];

foreach ($files as $file => $meta) {
    refactorView(
        "$viewsDir/admin/$file.blade.php",
        "$viewsDir/admin/$file",
        $meta['page'],
        $meta['name']
    );
}
