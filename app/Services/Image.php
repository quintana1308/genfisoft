<?php

namespace App\Services;

class Image
{
    public static function compressImage($file, $typeFile, $targetFile)
    {
        if (strpos($typeFile, 'image/') === false) return null;

        switch ($typeFile) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = @imagecreatefromjpeg($file->getRealPath());
                if (!$image) return null;
                imagejpeg($image, $targetFile, 30);
                break;

            case 'image/png':
                $image = @imagecreatefrompng($file->getRealPath());
                if (!$image) return null;

                $width = imagesx($image);
                $height = imagesy($image);
                $compressedImage = imagecreatetruecolor($width, $height);
                imagealphablending($compressedImage, false);
                imagesavealpha($compressedImage, true);
                $transparentColor = imagecolorallocatealpha($compressedImage, 255, 255, 255, 127);
                imagefilledrectangle($compressedImage, 0, 0, $width, $height, $transparentColor);
                imagecopy($compressedImage, $image, 0, 0, 0, 0, $width, $height);
                imagepng($compressedImage, $targetFile, 6);
                break;

            case 'image/gif':
            case 'image/webp':
                $image = @imagecreatefromstring(file_get_contents($file->getRealPath()));
                if (!$image) return null;
                if ($typeFile === 'image/gif') {
                    imagegif($image, $targetFile);
                } else {
                    imagewebp($image, $targetFile);
                }
                break;

            default:
                return null;
        }

        imagedestroy($image);
        return $targetFile;
    }
}
