<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductImage;
use App\Jobs\ProcessImageJob;

class ProcessExistingImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-existing-images {--batch=50 : Number of images to process in each batch} {--convert : Convert images to WebP format}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process existing images with compression and optional WebP conversion';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $batchSize = $this->option('batch');
        $convertToWebP = $this->option('convert');
        
        $this->info("Starting image processing with batch size: {$batchSize}");
        $this->info($convertToWebP ? "Converting images to WebP format" : "Compressing images without format conversion");
        
        // Get all product images
        $totalImages = ProductImage::count();
        $this->info("Found {$totalImages} images to process");
        
        if ($totalImages === 0) {
            $this->info("No images found to process");
            return;
        }
        
        // Process images in batches
        $processed = 0;
        $failed = 0;
        
        ProductImage::chunk($batchSize, function ($images) use (&$processed, &$failed, $convertToWebP) {
            foreach ($images as $image) {
                try {
                    $fullPath = storage_path('app/public/' . $image->image_path);
                    
                    // Check if file exists
                    if (!file_exists($fullPath)) {
                        $this->warn("File not found: {$image->image_path}");
                        $failed++;
                        continue;
                    }
                    
                    // Dispatch job to process the image
                    ProcessImageJob::dispatch($fullPath, $convertToWebP, 1200, 1200, 80);
                    $processed++;
                    
                    // Update progress
                    if ($processed % 10 === 0) {
                        $this->info("Processed {$processed} images...");
                    }
                } catch (\Exception $e) {
                    $this->error("Failed to process image {$image->id}: " . $e->getMessage());
                    $failed++;
                }
            }
        });
        
        $this->info("Processing complete!");
        $this->info("Successfully processed: {$processed} images");
        $this->info("Failed to process: {$failed} images");
        $this->info("Total images: {$totalImages}");
    }
}