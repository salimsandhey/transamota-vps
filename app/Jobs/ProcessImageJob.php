<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\ImageService;

class ProcessImageJob implements ShouldQueue
{
    use Queueable;

    protected $imagePath;
    protected $convertToWebP;
    protected $maxWidth;
    protected $maxHeight;
    protected $quality;

    /**
     * Create a new job instance.
     *
     * @param string $imagePath
     * @param bool $convertToWebP
     * @param int $maxWidth
     * @param int $maxHeight
     * @param int $quality
     */
    public function __construct($imagePath, $convertToWebP = true, $maxWidth = 1200, $maxHeight = 1200, $quality = 80)
    {
        $this->imagePath = $imagePath;
        $this->convertToWebP = $convertToWebP;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
        $this->quality = $quality;
    }

    /**
     * Execute the job.
     */
    public function handle(ImageService $imageService): void
    {
        try {
            // Process the image
            $imageService->processImage(
                $this->imagePath,
                $this->convertToWebP,
                $this->maxWidth,
                $this->maxHeight,
                $this->quality
            );
        } catch (\Exception $e) {
            \Log::error('Background image processing failed: ' . $e->getMessage());
        }
    }
}