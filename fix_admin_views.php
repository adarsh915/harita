<?php
$file = 'd:/all_project/harita-project/harita/app/Http/Controllers/Admin/AdminController.php';
$c = file_get_contents($file);
$c = preg_replace("/view\('admin\.([a-zA-Z0-9_-]+)'/", "view('admin.$1.index'", $c);
// wait, admin.dashboard.index is already there. It might become admin.dashboard.index.index.
$c = preg_replace("/view\('admin\.([a-zA-Z0-9_-]+)\.index\.index'/", "view('admin.$1.index'", $c);
file_put_contents($file, $c);
echo "Updated AdminController";
?>
