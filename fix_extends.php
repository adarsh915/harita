<?php
function updateExtends($dir) {
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = "$dir/$file";
        if (is_dir($path)) {
            updateExtends($path);
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $content = file_get_contents($path);
            $newContent = str_replace(
                ["@extends('layouts.student')", "@extends('layouts.teacher')"],
                "@extends('layouts.main')",
                $content
            );
            
            // Also, let's make sure they have a @section('page') so sidebar highlighting works, 
            // if it doesn't already exist.
            if (!str_contains($newContent, "@section('page'")) {
                // Infer page from filename (e.g., profile.blade.php -> profile)
                $page = str_replace('.blade.php', '', basename($path));
                $newContent = preg_replace(
                    "/@extends\('layouts\.main'\)/",
                    "@extends('layouts.main')\n@section('page', '$page')",
                    $newContent
                );
            }
            
            if ($content !== $newContent) {
                file_put_contents($path, $newContent);
                echo "Updated $path\n";
            }
        }
    }
}

updateExtends('d:/all_project/harita-project/harita/resources/views/student');
updateExtends('d:/all_project/harita-project/harita/resources/views/teacher');
echo "Done";
?>
