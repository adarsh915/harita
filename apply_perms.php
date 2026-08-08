<?php
$f = 'd:/all_project/harita-project/harita/resources/views/admin/class-booking/index.blade.php';
$c = file_get_contents($f);
$c = str_replace('<!-- BOOKING PANEL (Admins & Teachers) -->', "@can('bookings.create')\n      <!-- BOOKING PANEL (Admins & Teachers) -->", $c);
$c = str_replace('<!-- Student view warning helper -->', "@endcan\n\n      <!-- Student view warning helper -->", $c);
file_put_contents($f, $c);
echo "Permissions added successfully!";
