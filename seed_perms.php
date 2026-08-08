<?php

use Spatie\Permission\Models\Permission;

$perms = [
    'dashboard.view', 
    'students.manage', 
    'teachers.manage', 
    'credits.view', 
    'classes.view', 
    'leaves.view', 
    'users.manage', 
    'sales.manage', 
    'reports.view', 
    'bookings.create'
];

foreach ($perms as $p) {
    Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
}

echo "Permissions seeded successfully.\n";
