<?php

namespace App\Services;

use App\DataObjects\File;
use App\Models\Media;
use App\Services\Contracts\UploadServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService implements UploadServiceContract
{
    public function upload(UploadedFile $file, string $collection = null): Media
    {
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $mimeType = $file->getClientMimeType();
        $size = $file->getSize();
        $disk = config('filesystems.default');
        $fileHash = hash_file('sha256', $file->getRealPath());

        $path = $file->storeAs('media', $fileName, $disk);

        $fileDataObject = new File(
            name: $name,
            file_name: $fileName,
            mime_type: $mimeType,
            path: $path,
            disk: $disk,
            file_hash: $fileHash,
            size: $size,
            collection: $collection,
        );

        return Media::create($fileDataObject->toArray());
    }

    public function delete(Media $media): void
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();
    }
}
