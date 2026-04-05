<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get the appropriate image path, checking for WebP version first
     *
     * @param string $imagePath
     * @return string
     */
    public static function getImagePath($imagePath)
    {
        // If the path already points to a WebP file, return as is
        if (pathinfo($imagePath, PATHINFO_EXTENSION) === 'webp') {
            return $imagePath;
        }
        
        // Check if a WebP version exists
        $webpPath = pathinfo($imagePath, PATHINFO_DIRNAME) . '/' . 
                   pathinfo($imagePath, PATHINFO_FILENAME) . '.webp';
        
        $fullWebpPath = storage_path('app/public/' . $webpPath);
        if (file_exists($fullWebpPath)) {
            return $webpPath;
        }
        
        // Return original path if no WebP version exists
        return $imagePath;
    }
    
    /**
     * Get image URL with WebP fallback
     *
     * @param string $imagePath
     * @return string
     */
    public static function getImageUrl($imagePath)
    {
        return '/storage/' . self::getImagePath($imagePath);
    }
}