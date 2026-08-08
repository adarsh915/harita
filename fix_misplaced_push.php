<?php
$bladeDir = "d:/all_project/harita-project/harita/resources/views";

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($bladeDir));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        
        // Check if @push('styles') appears BEFORE @extends
        $pushPos = strpos($content, "@push('styles')");
        $extendsPos = strpos($content, "@extends");
        
        if ($pushPos !== false && $extendsPos !== false && $pushPos < $extendsPos) {
            // Extract the whole @push('styles') ... @endpush block that is before @extends
            if (preg_match('/(@push\(\'styles\'\)[\s\S]*?@endpush)\s*(@extends)/', $content, $matches)) {
                $blockToMove = trim($matches[1]);
                // Remove it from the top
                $content = str_replace($matches[1], '', $content);
                // Clean up any stray newlines at the very top
                $content = ltrim($content);
                
                // Inject it right after @section('page'... or @extends
                if (preg_match('/(@section\(\'page\'[^\n]*\n)/', $content, $secMatches)) {
                    $content = str_replace($secMatches[1], $secMatches[1] . "\n" . $blockToMove . "\n", $content);
                } else {
                    $content = preg_replace('/(@extends[^\n]*\n)/', "$1\n" . $blockToMove . "\n", $content);
                }
                
                file_put_contents($file->getPathname(), $content);
                echo "Moved @push('styles') in: " . $file->getPathname() . "\n";
            }
        }
    }
}
echo "Done\n";
?>
