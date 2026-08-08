<?php
$bladeDir = "d:/all_project/harita-project/harita/resources/views";

$fullcalendarScript = <<<EOT
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
EOT;

function fixFullCalendarScripts($dir) {
    global $fullcalendarScript;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            
            // Check if page uses FullCalendar
            if (strpos($content, 'FullCalendar.Calendar') !== false) {
                // Check if script is missing
                if (strpos($content, 'fullcalendar@6.1.15') === false) {
                    
                    if (strpos($content, "@push('scripts')") !== false) {
                        $content = str_replace("@push('scripts')", "@push('scripts')\n" . $fullcalendarScript, $content);
                    } else {
                        $content .= "\n@push('scripts')\n" . $fullcalendarScript . "\n@endpush\n";
                    }
                    
                    file_put_contents($file->getPathname(), $content);
                    echo "Injected FullCalendar JS in: " . $file->getPathname() . "\n";
                }
            }
        }
    }
}

fixFullCalendarScripts($bladeDir);
echo "Done\n";
?>
