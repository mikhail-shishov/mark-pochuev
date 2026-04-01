<?php

namespace App\Services\Contracts;

use App\DataObjects\File;
use App\Models\Media;
use Illuminate\Http\UploadedFile;

interface UploadServiceContract
{
    public function upload(UploadedFile $file, string $collection = null): Media;

    public function delete(Media $media): void;
}
