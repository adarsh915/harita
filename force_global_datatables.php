<?php
$bladeDir = "d:/all_project/harita-project/harita/resources/views";

$datatablesCSS = <<<EOT
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
EOT;

$datatablesJS = <<<EOT
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
EOT;

function forceGlobalDatatables($dir) {
    global $datatablesCSS, $datatablesJS;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            
            // Does this page actually initialize a datatable?
            if (stripos($content, '.DataTable(') !== false || stripos($content, 'setupDataTable(') !== false) {
                $modified = false;
                
                // Check if CSS is missing
                if (stripos($content, 'jquery.dataTables.min.css') === false) {
                    if (strpos($content, "@push('styles')") !== false) {
                        $content = str_replace("@push('styles')", "@push('styles')\n" . $datatablesCSS, $content);
                    } else {
                        // Create it right after @section('page'...)
                        $content = preg_replace('/(@section\(\'page\'.*\n)/', "$1\n@push('styles')\n" . $datatablesCSS . "\n@endpush\n", $content);
                    }
                    $modified = true;
                }
                
                // Check if JS is missing
                if (stripos($content, 'jquery.dataTables.min.js') === false) {
                    if (strpos($content, "@push('scripts')") !== false) {
                        $content = str_replace("@push('scripts')", "@push('scripts')\n" . $datatablesJS, $content);
                    } else {
                        $content .= "\n@push('scripts')\n" . $datatablesJS . "\n@endpush\n";
                    }
                    $modified = true;
                }
                
                if ($modified) {
                    file_put_contents($file->getPathname(), $content);
                    echo "Forced DataTables CSS/JS in: " . $file->getPathname() . "\n";
                }
            }
        }
    }
}

forceGlobalDatatables($bladeDir);
echo "Done\n";
?>
