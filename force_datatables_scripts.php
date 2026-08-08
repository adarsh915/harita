<?php
$bladeDir = "d:/all_project/harita-project/harita/resources/views";

$datatablesScripts = <<<EOT
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
EOT;

function fixDatatablesScripts($dir) {
    global $datatablesScripts;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            
            // If the file uses datatables CSS, it MUST need datatables JS
            if (strpos($content, 'jquery.dataTables.min.css') !== false) {
                // If it doesn't already have the JS...
                if (strpos($content, 'jquery.dataTables.min.js') === false) {
                    
                    // Inject right after @push('scripts')
                    if (strpos($content, "@push('scripts')") !== false) {
                        $content = str_replace("@push('scripts')", "@push('scripts')\n" . $datatablesScripts, $content);
                        file_put_contents($file->getPathname(), $content);
                        echo "Fixed Datatables scripts in: " . $file->getPathname() . "\n";
                    }
                }
            }
        }
    }
}

fixDatatablesScripts($bladeDir);
echo "Done\n";
?>
