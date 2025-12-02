<?php

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * Upload and resize an image
     */
    public function upload(UploadedFile $file, string $directory = 'uploads'): array
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $directory . '/' . $fileName;

        // Store original
        $fullPath = $file->storeAs($directory, $fileName, 'public');

        // Create resized versions
        $this->createThumbnail($file, $directory, $fileName);
        $this->createMedium($file, $directory, $fileName);

        return [
            'file_name' => $fileName,
            'file_path' => $fullPath,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ];
    }

    /**
     * Create thumbnail (150x150)
     */
    protected function createThumbnail(UploadedFile $file, string $directory, string $fileName)
    {
        $image = Image::read($file);
        $image->cover(150, 150);

        Storage::disk('public')->put(
            $directory . '/thumb_' . $fileName,
            $image->encode()
        );
    }

    /**
     * Create medium size (400x400)
     */
    protected function createMedium(UploadedFile $file, string $directory, string $fileName)
    {
        $image = Image::read($file);
        $image->scale(width: 400);

        Storage::disk('public')->put(
            $directory . '/medium_' . $fileName,
            $image->encode()
        );
    }

    /**
     * Delete image and all its versions
     */
    public function delete(string $filePath): void
    {
        $directory = dirname($filePath);
        $fileName = basename($filePath);

        // Delete all versions
        Storage::disk('public')->delete([
            $filePath,
            $directory . '/thumb_' . $fileName,
            $directory . '/medium_' . $fileName,
        ]);
    }
}
