<?php

$src = 'd:/all_project/harita-project/harita/resources/views/admin/dashboard.blade.php';
$content = file_get_contents($src);

// Extract styles
preg_match('/<style>(.*?)<\/style>/s', $content, $styleMatches);
$styles = isset($styleMatches[1]) ? $styleMatches[1] : '';

// Extract scripts
preg_match('/<script src="https:\/\/cdn\.jsdelivr\.net\/npm\/chart\.js"><\/script>\s*<script src="{{ asset\(\'admin-assets\/js\/charts\.js\'\) }}"><\/script>\s*<script>(.*?)<\/script>/s', $content, $scriptMatches);
$scripts = isset($scriptMatches[1]) ? $scriptMatches[1] : '';

// Extract main content
preg_match('/<!-- ==========================================\s*ADMIN VIEW CONTAINER\s*========================================== -->(.*?)<!-- ==========================================\s*TEACHER VIEW CONTAINER\s*========================================== -->/s', $content, $contentMatches);
$mainContent = isset($contentMatches[1]) ? $contentMatches[1] : '';

$newBlade = <<<'BLADE'
@extends('layouts.main')
@section('title', 'Dashboard')
@section('page', 'dashboard')

@push('styles')
<style>
BLADE;
$newBlade .= "\n" . $styles . "\n</style>\n@endpush\n\n@section('content')\n";
$newBlade .= $mainContent;
$newBlade .= <<<'BLADE'
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('admin-assets/js/charts.js') }}"></script>
<script>
BLADE;
$newBlade .= "\n" . $scripts . "\n</script>\n@endpush\n";

$destDir = 'd:/all_project/harita-project/harita/resources/views/admin/dashboard';
if (!is_dir($destDir)) {
    mkdir($destDir, 0777, true);
}
file_put_contents("$destDir/index.blade.php", $newBlade);
unlink($src);

echo "Dashboard refactored successfully!";
?>
