<?php

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$user = User::where('email', 'admin@prodesa.id')->first();
echo 'User: '.$user->name.PHP_EOL;
echo 'Role: '.$user->role.PHP_EOL;
echo 'Has Super Admin role: '.($user->hasRole('Super Admin') ? 'YES' : 'NO').PHP_EOL;
echo 'Can letter.view: '.($user->can('letter.view') ? 'YES' : 'NO').PHP_EOL;
echo 'Can setting.manage: '.($user->can('setting.manage') ? 'YES' : 'NO').PHP_EOL;
echo 'Can user.view: '.($user->can('user.view') ? 'YES' : 'NO').PHP_EOL;
echo 'Permissions count: '.$user->getAllPermissions()->count().PHP_EOL;
