<?php

use App\Models\Page;
use App\Models\Menu;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$output = "";
$output .= "--- PAGES ---\n";
foreach (Page::all() as $p) {
    if ($p) {
        $output .= "ID: {$p->id} | Title: {$p->title} | Slug: [{$p->slug}] | Published: {$p->is_published}\n";
    }
}

$output .= "\n--- MENUS ---\n";
foreach (Menu::all() as $m) {
    if ($m) {
        $output .= "ID: {$m->id} | Label: {$m->label} | URL: [{$m->url}]\n";
    }
}

file_put_contents(__DIR__ . '/debug_output.txt', $output);
