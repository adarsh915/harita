<?php
libxml_use_internal_errors(true);

function restoreAllPages($role) {
    $htmlDir = "d:/all_project/harita-project/Harita Music Academy Admin Panel/$role";
    $bladeDir = "d:/all_project/harita-project/harita/resources/views/$role";
    
    if (!is_dir($htmlDir) || !is_dir($bladeDir)) return;
    
    $files = scandir($htmlDir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $baseName = pathinfo($file, PATHINFO_FILENAME);
            $htmlPath = "$htmlDir/$file";
            $bladePath = "$bladeDir/$baseName.blade.php";
            
            $htmlContent = file_get_contents($htmlPath);
            
            // Extract styles
            preg_match('/<style>([\s\S]*?)<\/style>/i', $htmlContent, $styleMatches);
            $styleContent = isset($styleMatches[1]) ? trim($styleMatches[1]) : '';
            
            // Extract main content
            $startMarker = '<main class="main-content">';
            $startPos = strpos($htmlContent, $startMarker);
            if ($startPos === false) {
                echo "Skipped $role/$baseName: No main-content found\n";
                continue;
            }
            
            $headerEndMarker = '</header>';
            $headerEndPos = strpos($htmlContent, $headerEndMarker, $startPos);
            $contentStartPos = ($headerEndPos !== false) ? $headerEndPos + strlen($headerEndMarker) : $startPos + strlen($startMarker);
            
            $endMarker = '</main>';
            $endPos = strpos($htmlContent, $endMarker, $contentStartPos);
            if ($endPos === false) continue;
            
            $mainContent = substr($htmlContent, $contentStartPos, $endPos - $contentStartPos);
            
            $doc = new DOMDocument();
            $doc->loadHTML('<?xml encoding="utf-8" ?><div>' . $mainContent . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $xpath = new DOMXPath($doc);
            
            // Remove nodes strictly meant for other roles
            $nodesToLimit = $xpath->query("//*[@data-role-limit]");
            foreach ($nodesToLimit as $node) {
                $limitRole = $node->getAttribute('data-role-limit');
                if ($limitRole !== $role && $limitRole !== 'all') {
                    $node->parentNode->removeChild($node);
                }
            }
            
            // Specific ID cleanup (from settings/profile)
            $toRemoveIds = [];
            if ($baseName === 'settings') {
                if ($role === 'student') {
                    $toRemoveIds = ['teacherFields', 'adminFields', 'academyConfigSection', 'schedulingRulesSection'];
                } elseif ($role === 'teacher') {
                    $toRemoveIds = ['studentFields', 'adminFields', 'academyConfigSection', 'schedulingRulesSection'];
                }
            } elseif ($baseName === 'profile') {
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
            
            // Fix inline display:none toggle logic
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
            $bladeContent = "@extends('layouts.main')\n@section('page', '$baseName')\n";
            
            if (!empty($styleContent)) {
                $bladeContent .= "\n@push('styles')\n<style>\n$styleContent\n</style>\n@endpush\n";
            }
            
            $bladeContent .= "\n@section('content')\n" . trim($cleanHtml) . "\n@endsection\n";
            
            // Fix asset paths
            $bladeContent = str_replace('src="../assets/', 'src="{{ asset(\'admin-assets/assets/', $bladeContent);
            $bladeContent = preg_replace('/src="\{\{ asset\(\'admin-assets\/assets\/(.*?)\"/', 'src="{{ asset(\'admin-assets/assets/$1\') }}"', $bladeContent);
            
            // Edge cases: Some hrefs point to .html, change them to javascript:void(0) or real routes if obvious
            $bladeContent = preg_replace('/href="[^"]*\.html"/', 'href="#"', $bladeContent);
            
            file_put_contents($bladePath, $bladeContent);
            echo "Restored and cleaned $role/$baseName.blade.php\n";
        }
    }
}

restoreAllPages('student');
restoreAllPages('teacher');

echo "Done restoring all student/teacher pages\n";
?>
