<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Illuminate\Support\Str;

class ImageService
{
    protected $imageManager;

    public function __construct()
    {
        // Initialize the ImageManager with GD driver
        $this->imageManager = new ImageManager(new GdDriver());
    }

    /**
     * Compress and resize an image
     *
     * @param string $imagePath
     * @param int $maxWidth
     * @param int $maxHeight
     * @param int $quality
     * @return string
     */
    public function compressImage($imagePath, $maxWidth = 1200, $maxHeight = 1200, $quality = 80)
    {
        try {
            // Check if file exists
            if (!file_exists($imagePath)) {
                throw new \Exception("Image file does not exist: " . $imagePath);
            }
            
            // Read the image
            $image = $this->imageManager->read($imagePath);
            
            // Get original dimensions
            $originalWidth = $image->width();
            $originalHeight = $image->height();
            
            // Only resize if the image is larger than the maximum dimensions
            if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                // Resize the image while maintaining aspect ratio
                $image->scaleDown($maxWidth, $maxHeight);
            }
            
            // Get the image extension
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            
            // Save the compressed image based on extension
            switch (strtolower($extension)) {
                case 'jpg':
                case 'jpeg':
                    $image->toJpeg($quality);
                    break;
                case 'png':
                    // For PNG, we don't use quality parameter as it's lossless
                    $image->toPng();
                    break;
                case 'webp':
                    $image->toWebp($quality);
                    break;
                default:
                    // Default to JPEG for other formats
                    $image->toJpeg($quality);
                    break;
            }
            
            // Save the image back to the same path
            $image->save($imagePath);
            
            return $imagePath;
        } catch (\Exception $e) {
            \Log::error('Image compression failed: ' . $e->getMessage());
            throw $e; // Re-throw to be handled by caller
        }
    }

    /**
     * Convert image to WebP format for better compression
     *
     * @param string $imagePath
     * @param int $quality
     * @return string
     */
    public function convertToWebP($imagePath, $quality = 80)
    {
        try {
            // Check if file exists
            if (!file_exists($imagePath)) {
                throw new \Exception("Image file does not exist: " . $imagePath);
            }
            
            // Read the image
            $image = $this->imageManager->read($imagePath);
            
            // Generate new path with .webp extension
            $webpPath = pathinfo($imagePath, PATHINFO_DIRNAME) . '/' . 
                        pathinfo($imagePath, PATHINFO_FILENAME) . '.webp';
            
            // Convert to WebP
            $image->toWebp($quality)->save($webpPath);
            
            // Delete original file only if conversion was successful and files are different
            if (file_exists($webpPath) && $webpPath !== $imagePath) {
                unlink($imagePath);
            }
            
            return $webpPath;
        } catch (\Exception $e) {
            \Log::error('Image conversion to WebP failed: ' . $e->getMessage());
            throw $e; // Re-throw to be handled by caller
        }
    }

    /**
     * Process image with compression and optional WebP conversion
     *
     * @param string $imagePath
     * @param bool $convertToWebP
     * @param int $maxWidth
     * @param int $maxHeight
     * @param int $quality
     * @return string
     */
    public function processImage($imagePath, $convertToWebP = true, $maxWidth = 1200, $maxHeight = 1200, $quality = 80)
    {
        // First compress the image
        $compressedPath = $this->compressImage($imagePath, $maxWidth, $maxHeight, $quality);
        
        // Optionally convert to WebP for better compression
        if ($convertToWebP) {
            return $this->convertToWebP($compressedPath, $quality);
        }
        
        return $compressedPath;
    }
    
    /**
     * Get image information for logging/debugging
     *
     * @param string $imagePath
     * @return array
     */
    public function getImageInfo($imagePath)
    {
        if (!file_exists($imagePath)) {
            return ['error' => 'File does not exist'];
        }
        
        try {
            $image = $this->imageManager->read($imagePath);
            return [
                'width' => $image->width(),
                'height' => $image->height(),
                'filesize' => filesize($imagePath),
                'mime' => mime_content_type($imagePath),
                'extension' => pathinfo($imagePath, PATHINFO_EXTENSION)
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}