<?php
$bladeDir = "d:/all_project/harita-project/harita/resources/views";

$chartScripts = <<<EOT
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('admin-assets/js/charts.js') }}"></script>
EOT;

function fixChartScripts($dir) {
    global $chartScripts;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            
            // If the file uses canvas for charts, it needs chart.js
            if (strpos($content, '<canvas') !== false || strpos($content, 'ChartManager') !== false || strpos($content, 'renderReportsCharts') !== false) {
                // If it doesn't already have the JS...
                if (strpos($content, 'chart.js') === false) {
                    
                    // Inject right before the closing @endpush of scripts, or at the start of the inline script
                    if (strpos($content, "@push('scripts')") !== false) {
                        $content = str_replace("@push('scripts')", "@push('scripts')\n" . $chartScripts, $content);
                        file_put_contents($file->getPathname(), $content);
                        echo "Fixed Chart scripts in: " . $file->getPathname() . "\n";
                    }
                }
            }
        }
    }
}

fixChartScripts($bladeDir);
echo "Done\n";
?>
