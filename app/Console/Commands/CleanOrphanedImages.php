<?php

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanOrphanedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:clean {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned images that are not referenced in any page content';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        $this->info('Scanning for orphaned images...');
        $this->newLine();

        // Get all images in storage
        $allImages = Storage::disk('public')->files('page-images');

        if (empty($allImages)) {
            $this->info('No images found in storage.');
            return 0;
        }

        $this->info('Found ' . count($allImages) . ' images in storage.');

        // Get all page content
        $pages = Page::all();
        $usedImages = [];

        // Extract image URLs from all page content
        foreach ($pages as $page) {
            if (empty($page->content)) {
                continue;
            }

            // Find all image src attributes in the content
            preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $page->content, $matches);

            if (!empty($matches[1])) {
                foreach ($matches[1] as $imageUrl) {
                    // Extract the path from the URL
                    // Expected format: http://localhost:8000/storage/page-images/filename.jpg
                    if (preg_match('/\/storage\/page-images\/([^"\'?\s]+)/', $imageUrl, $pathMatch)) {
                        $usedImages[] = 'page-images/' . $pathMatch[1];
                    }
                }
            }
        }

        $usedImages = array_unique($usedImages);
        $this->info('Found ' . count($usedImages) . ' images referenced in page content.');
        $this->newLine();

        // Find orphaned images
        $orphanedImages = array_diff($allImages, $usedImages);

        if (empty($orphanedImages)) {
            $this->info('✅ No orphaned images found. All images are in use!');
            return 0;
        }

        $this->warn('Found ' . count($orphanedImages) . ' orphaned images:');
        $this->newLine();

        $totalSize = 0;
        foreach ($orphanedImages as $image) {
            $size = Storage::disk('public')->size($image);
            $totalSize += $size;
            $this->line('  • ' . basename($image) . ' (' . $this->formatBytes($size) . ')');
        }

        $this->newLine();
        $this->info('Total size: ' . $this->formatBytes($totalSize));
        $this->newLine();

        if ($isDryRun) {
            $this->warn('DRY RUN MODE: No files were deleted.');
            $this->info('Run without --dry-run to actually delete these files.');
            return 0;
        }

        // Ask for confirmation
        if (!$this->confirm('Do you want to delete these ' . count($orphanedImages) . ' orphaned images?', false)) {
            $this->info('Cancelled. No files were deleted.');
            return 0;
        }

        // Delete orphaned images
        $deletedCount = 0;
        foreach ($orphanedImages as $image) {
            if (Storage::disk('public')->delete($image)) {
                $deletedCount++;
            }
        }

        $this->newLine();
        $this->info('✅ Successfully deleted ' . $deletedCount . ' orphaned images.');
        $this->info('💾 Freed up ' . $this->formatBytes($totalSize) . ' of storage space.');

        return 0;
    }

    /**
     * Format bytes to human readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
