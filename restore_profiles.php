<?php
libxml_use_internal_errors(true);

function restoreProfile($role, $type) {
    $htmlPath = "d:/all_project/harita-project/Harita Music Academy Admin Panel/$role/$type.html";
    $bladePath = "d:/all_project/harita-project/harita/resources/views/$role/$type.blade.php";
    
    if (!file_exists($htmlPath)) {
        return;
    }
    
    $htmlContent = file_get_contents($htmlPath);
    
    // Extract styles
    preg_match('/<style>([\s\S]*?)<\/style>/i', $htmlContent, $styleMatches);
    $styleContent = isset($styleMatches[1]) ? trim($styleMatches[1]) : '';
    
    // Extract main content
    $startMarker = '<main class="main-content">';
    $startPos = strpos($htmlContent, $startMarker);
    if ($startPos === false) return;
    
    $headerEndMarker = '</header>';
    $headerEndPos = strpos($htmlContent, $headerEndMarker, $startPos);
    $contentStartPos = ($headerEndPos !== false) ? $headerEndPos + strlen($headerEndMarker) : $startPos + strlen($startMarker);
    
    $endMarker = '</main>';
    $endPos = strpos($htmlContent, $endMarker, $contentStartPos);
    if ($endPos === false) return;
    
    $mainContent = substr($htmlContent, $contentStartPos, $endPos - $contentStartPos);
    
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="utf-8" ?><div>' . $mainContent . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($doc);
    
    // Elements to remove based on data-role-limit or id
    
    // Remove nodes that are strictly for other roles
    $nodesToLimit = $xpath->query("//*[@data-role-limit]");
    foreach ($nodesToLimit as $node) {
        $limitRole = $node->getAttribute('data-role-limit');
        if ($limitRole !== $role) {
            $node->parentNode->removeChild($node);
        }
    }
    
    // Remove by specific IDs just in case they don't have data-role-limit
    $toRemoveIds = [];
    if ($type === 'settings') {
        if ($role === 'student') {
            $toRemoveIds = ['teacherFields', 'adminFields', 'academyConfigSection', 'schedulingRulesSection'];
        } elseif ($role === 'teacher') {
            $toRemoveIds = ['studentFields', 'adminFields', 'academyConfigSection', 'schedulingRulesSection'];
        }
    } elseif ($type === 'profile') {
        if ($role === 'student') {
            $toRemoveIds = ['teacherDetails', 'adminDetails'];
        } elseif ($role === 'teacher') {
            $toRemoveIds = ['studentDetails', 'adminDetails'];
        }
    }
    
    foreach ($toRemoveIds as $id) {
        $nodes = $xpath->query("//*[@id='$id']");
        foreach ($nodes as $node) {
            if ($node->parentNode) {
                $node->parentNode->removeChild($node);
            }
        }
    }
    
    // Fix inline display:none that the JS would normally toggle
    $nodesWithStyle = $xpath->query("//*[@style]");
    foreach ($nodesWithStyle as $node) {
        $style = $node->getAttribute('style');
        $style = preg_replace('/display\s*:\s*(none|block)\s*;?/', '', $style);
        if (trim($style) === '') {
            $node->removeAttribute('style');
        } else {
            $node->setAttribute('style', trim($style));
        }
    }
    
    $cleanHtml = $doc->saveHTML($doc->documentElement);
    $cleanHtml = preg_replace('/^<div[^>]*>(.*)<\/div>$/is', '$1', $cleanHtml);
    $cleanHtml = str_replace('<?xml encoding="utf-8" ?>', '', $cleanHtml);
    
    // Build the blade template
    $bladeContent = "@extends('layouts.main')\n@section('page', '$type')\n";
    
    if (!empty($styleContent)) {
        $bladeContent .= "\n@push('styles')\n<style>\n$styleContent\n</style>\n@endpush\n";
    }
    
    $bladeContent .= "\n@section('content')\n" . trim($cleanHtml) . "\n@endsection\n";
    
    // Fix image paths
    $bladeContent = str_replace('src="../assets/', 'src="{{ asset(\'admin-assets/assets/', $bladeContent);
    $bladeContent = preg_replace('/src="\{\{ asset\(\'admin-assets\/assets\/(.*?)\"/', 'src="{{ asset(\'admin-assets/assets/$1\') }}"', $bladeContent);
    
    file_put_contents($bladePath, $bladeContent);
    echo "Restored and cleaned $role/$type.blade.php\n";
}

restoreProfile('student', 'settings');
restoreProfile('student', 'profile');
restoreProfile('teacher', 'settings');
restoreProfile('teacher', 'profile');

echo "Done\n";
?>
