<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasPhoto
{

    /**
     * Update the room's photo.
     *
     * @param \Illuminate\Http\UploadedFile $photo
     * @return void
     */
    public function updatePhoto(UploadedFile $photo)
    {
        tap($this->photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'photo_path' => $photo->storePublicly(
                    'room-photos', ['disk' => $this->photoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->photoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the room's photo.
     *
     * @return void
     */
    public function deletePhoto()
    {
        if (is_null($this->photo_path)) {
            return;
        }

        Storage::disk($this->photoDisk())->delete($this->photo_path);
    }

    /**
     * Get the URL to the room's photo.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo_path
            ? Storage::disk($this->photoDisk())->url($this->photo_path)
            : "https://cdn1.epicgames.com/ue/product/Screenshot/HighresScreenshot000001920-1920x1080-01dc0f45d35815bde586d413fee09cb7.jpg?resize=1&w=1920";
    }

    /**
     * Get the disk that room photos should be stored on.
     *
     * @return string
     */
    protected function photoDisk()
    {
        return 'public';
    }
}
