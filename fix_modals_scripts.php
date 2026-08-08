<?php
libxml_use_internal_errors(true);

function extractModalsAndScripts($role) {
    $htmlDir = "d:/all_project/harita-project/Harita Music Academy Admin Panel/$role";
    $bladeDir = "d:/all_project/harita-project/harita/resources/views/$role";
    
    if (!is_dir($htmlDir) || !is_dir($bladeDir)) return;
    
    $files = scandir($htmlDir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $baseName = pathinfo($file, PATHINFO_FILENAME);
            $htmlPath = "$htmlDir/$file";
            
            // Check for flat file or folder index
            $bladePath = "$bladeDir/$baseName.blade.php";
            if (!file_exists($bladePath)) {
                $bladePath = "$bladeDir/$baseName/index.blade.php";
                if (!file_exists($bladePath)) {
                    // Try exact name mismatch, e.g. class-booking -> class_bookings?
                    // Just skip if we can't find it easily for now
                    if ($baseName === 'class-booking') $bladePath = "$bladeDir/class-booking/index.blade.php";
                    else if (!file_exists($bladePath)) continue;
                }
            }
            if (!file_exists($bladePath)) continue;
            
            $htmlContent = file_get_contents($htmlPath);
            
            $mainEndMarker = '</main>';
            $mainEndPos = strpos($htmlContent, $mainEndMarker);
            if ($mainEndPos === false) continue;
            
            $bodyEndMarker = '</body>';
            $bodyEndPos = strpos($htmlContent, $bodyEndMarker, $mainEndPos);
            if ($bodyEndPos === false) continue;
            
            $afterMain = substr($htmlContent, $mainEndPos + strlen($mainEndMarker), $bodyEndPos - ($mainEndPos + strlen($mainEndMarker)));
            
            $scripts = [];
            $afterMain = preg_replace_callback('/<script\b[^>]*>([\s\S]*?)<\/script>/i', function($matches) use (&$scripts) {
                if (strpos($matches[0], 'app.js') === false) {
                    $scripts[] = $matches[0];
                }
                return '';
            }, $afterMain);
            
            $modalsHtml = trim(preg_replace('/<!--[\s\S]*?-->/', '', $afterMain));
            
            preg_match_all('/<link[^>]+href="([^"]+)"[^>]*>/i', $htmlContent, $linkMatches);
            $extraStyles = [];
            foreach ($linkMatches[1] as $href) {
                if (strpos($href, 'datatables') !== false) {
                    $extraStyles[] = '<link rel="stylesheet" href="' . $href . '">';
                }
            }
            
            $bladeContent = file_get_contents($bladePath);
            
            if (!empty($extraStyles)) {
                $stylesString = implode("\n", $extraStyles);
                if (strpos($bladeContent, '@push(\'styles\')') !== false) {
                    if (strpos($bladeContent, 'datatables') === false) {
                        $bladeContent = str_replace('@push(\'styles\')', "@push('styles')\n" . $stylesString, $bladeContent);
                    }
                } else {
                    $bladeContent = "@push('styles')\n$stylesString\n@endpush\n\n" . $bladeContent;
                }
            }
            
            if (!empty($modalsHtml) && strpos($bladeContent, '@push(\'modals\')') === false) {
                if (strlen(strip_tags($modalsHtml)) > 5 || strpos($modalsHtml, '<div') !== false) {
                    $modalsHtml = str_replace('src="../assets/', 'src="{{ asset(\'admin-assets/assets/', $modalsHtml);
                    $modalsHtml = preg_replace('/src="\{\{ asset\(\'admin-assets\/assets\/(.*?)\"/', 'src="{{ asset(\'admin-assets/assets/$1\') }}"', $modalsHtml);
                    $bladeContent .= "\n\n@push('modals')\n" . trim($modalsHtml) . "\n@endpush\n";
                }
            }
            
            if (!empty($scripts) && strpos($bladeContent, '@push(\'scripts\')') === false) {
                $scriptsString = implode("\n\n", $scripts);
                $bladeContent .= "\n\n@push('scripts')\n" . trim($scriptsString) . "\n@endpush\n";
            }
            
            if ($bladeContent !== file_get_contents($bladePath)) {
                file_put_contents($bladePath, $bladeContent);
                echo "Added missing modals/scripts/styles to $role/$baseName\n";
            }
        }
    }
}

extractModalsAndScripts('admin');

echo "Done\n";
?>
