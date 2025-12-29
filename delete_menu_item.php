<?php

use App\Models\Menu;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$menu = Menu::where('label', 'About Me')->orWhere('url', 'LIKE', '%about-me%')->first();

if ($menu) {
    echo "Deleting menu item: " . $menu->label . " (" . $menu->url . ")\n";
    $menu->delete();
    echo "Menu item deleted successfully.\n";
} else {
    echo "No 'About Me' menu item found.\n";
}
