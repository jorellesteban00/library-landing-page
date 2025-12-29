<?php

use App\Models\Page;
use App\Models\Menu;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$page = Page::find(1);
if ($page) {
    $page->title = 'About Me';
    $page->slug = 'about-me';
    $page->is_published = true;
    $page->content = '<h1>About Us</h1><p>Welcome to our library. We are dedicated to providing the best resources to our community.</p>';
    $page->save();
    echo "Page updated.\n";
} else {
    // Create if missing
    $page = Page::create([
        'title' => 'About Me',
        'slug' => 'about-me',
        'is_published' => true,
        'content' => '<h1>About Us</h1><p>Welcome to our library.</p>'
    ]);
    echo "Page created.\n";
}

$menu = Menu::where('url', '/pages/about-me')->first();
if ($menu) {
    $menu->label = 'About Me';
    $menu->save();
    echo "Menu updated.\n";
}
