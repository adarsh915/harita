<?php
$htmlBase = 'd:/all_project/harita-project/Harita Music Academy Admin Panel';
$bladeBase = 'd:/all_project/harita-project/harita/resources/views';

function syncStylesForFolder($folder) {
    global $htmlBase, $bladeBase;
    
    $htmlDir = "$htmlBase/$folder";
    $bladeDir = "$bladeBase/$folder";
    
    if (!is_dir($htmlDir) || !is_dir($bladeDir)) return;
    
    $files = scandir($htmlDir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $baseName = pathinfo($file, PATHINFO_FILENAME);
            $htmlPath = "$htmlDir/$file";
            $bladePath = "$bladeDir/$baseName.blade.php";
            
            if (file_exists($bladePath)) {
                $htmlContent = file_get_contents($htmlPath);
                preg_match('/<style>([\s\S]*?)<\/style>/i', $htmlContent, $matches);
                
                if (isset($matches[1])) {
                    $styleContent = trim($matches[1]);
                    if (empty($styleContent)) continue;
                    
                    $bladeContent = file_get_contents($bladePath);
                    
                    // Remove existing injected style if it somehow got malformed (cleanup)
                    // But actually we just check if @push('styles') is there
                    if (!str_contains($bladeContent, '@push(\'styles\')')) {
                        $pushBlock = "\n@push('styles')\n<style>\n$styleContent\n</style>\n@endpush\n";
                        $bladeContent = str_replace('@section(\'content\')', $pushBlock . "\n@section('content')", $bladeContent);
                        file_put_contents($bladePath, $bladeContent);
                        echo "Added styles to $folder/$baseName.blade.php\n";
                    }
                }
            }
        }
    }
}

syncStylesForFolder('student');
syncStylesForFolder('teacher');
syncStylesForFolder('admin');

echo "Done\n";
?>
