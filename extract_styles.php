<?php
function extractAndAppendStyle($htmlPath, $bladePath) {
    if (!file_exists($htmlPath) || !file_exists($bladePath)) {
        echo "Missing files: $htmlPath\n";
        return;
    }
    
    $htmlContent = file_get_contents($htmlPath);
    preg_match('/<style>([\s\S]*?)<\/style>/i', $htmlContent, $matches);
    
    if (isset($matches[1])) {
        $styleContent = trim($matches[1]);
        $bladeContent = file_get_contents($bladePath);
        
        if (!str_contains($bladeContent, '@push(\'styles\')')) {
            $pushBlock = "\n@push('styles')\n<style>\n$styleContent\n</style>\n@endpush\n";
            $bladeContent = str_replace('@section(\'content\')', $pushBlock . "\n@section('content')", $bladeContent);
            file_put_contents($bladePath, $bladeContent);
            echo "Added styles to " . basename($bladePath) . "\n";
        } else {
            echo "Styles already exist in " . basename($bladePath) . "\n";
        }
    } else {
        echo "No styles found in " . basename($htmlPath) . "\n";
    }
}

$baseHtml = 'd:/all_project/harita-project/Harita Music Academy Admin Panel';
$baseBlade = 'd:/all_project/harita-project/harita/resources/views';

extractAndAppendStyle("$baseHtml/student/dashboard.html", "$baseBlade/student/dashboard.blade.php");
extractAndAppendStyle("$baseHtml/teacher/dashboard.html", "$baseBlade/teacher/dashboard.blade.php");

echo "Done\n";
?>
