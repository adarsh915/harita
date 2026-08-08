<?php

$staticDir = 'd:/all_project/harita-project/Harita Music Academy Admin Panel/admin';
$viewsDir = 'd:/all_project/harita-project/harita/resources/views/admin';

$files = glob("$staticDir/*.html");

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Fix asset links
    // From: href="../css/style.css" -> href="{{ asset('admin-assets/css/style.css') }}"
    $content = preg_replace('/href="\.\.\/css\/(.*?\.css)"/', 'href="{{ asset(\'admin-assets/css/$1\') }}"', $content);
    
    // From: src="../js/app.js" -> src="{{ asset('admin-assets/js/app.js') }}"
    $content = preg_replace('/src="\.\.\/js\/(.*?\.js)"/', 'src="{{ asset(\'admin-assets/js/$1\') }}"', $content);
    
    // From: src="../assets/logo.png" -> src="{{ asset('admin-assets/assets/logo.png') }}"
    $content = preg_replace('/src="\.\.\/assets\/(.*?)"/', 'src="{{ asset(\'admin-assets/assets/$1\') }}"', $content);
    
    // Write to blade (We are NOT replacing href="students.html" because we will use .html in routes!)
    $basename = basename($file, '.html');
    file_put_contents("$viewsDir/$basename.blade.php", $content);
    echo "Processed $basename.blade.php\n";
}

// Restore app.js
copy('d:/all_project/harita-project/Harita Music Academy Admin Panel/js/app.js', 'd:/all_project/harita-project/harita/public/admin-assets/js/app.js');
echo "Restored app.js\n";

?>
