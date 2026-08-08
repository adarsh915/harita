<?php

function fixDashboard($role) {
    $src = "d:/all_project/harita-project/harita/resources/views/$role/dashboard.blade.php";
    $dest = "d:/all_project/harita-project/harita/resources/views/$role/dashboard/index.blade.php";

    if (!file_exists($src)) return;

    $content = file_get_contents($src);
    
    // Extract the main container
    preg_match('/<div id=".*?DashboardView".*?>(.*?)<!-- Developed by Sitesoch footer/s', $content, $matches);
    
    if (isset($matches[1])) {
        $html = trim($matches[1]);
        // Remove the closing div of the container since we stripped it in the regex above (wait, regex stopped at footer)
        // Let's be safer:
        preg_match('/<div id=".*?DashboardView"[^>]*>(.*?)<\/div>\s*<!-- Developed by Sitesoch/s', $content, $matches2);
        if (isset($matches2[1])) {
            $html = trim($matches2[1]);
        } else {
             // fallback
             $html = preg_replace('/^.*?<div id=".*?DashboardView"[^>]*>/s', '', $content);
             $html = preg_replace('/<\/div>\s*<!-- ==========================================.*?$/s', '', $html);
             $html = preg_replace('/<\/div>\s*<!-- Developed by Sitesoch.*?$/s', '', $html);
        }

        $newBlade = "@extends('layouts.main')\n@section('title', '" . ucfirst($role) . " Dashboard')\n@section('page', 'dashboard')\n\n@section('content')\n" . $html . "\n@endsection\n";
        file_put_contents($dest, $newBlade);
        echo "Fixed $role dashboard\n";
        unlink($src);
    }
}

fixDashboard('student');
fixDashboard('teacher');
