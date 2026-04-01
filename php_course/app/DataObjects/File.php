<?php

namespace App\DataObjects;

class File
{
    public function __construct(
        public readonly string $name,
        public readonly string $file_name,
        public readonly string $mime_type,
        public readonly string $path,
        public readonly string $disk,
        public readonly string $file_hash,
        public readonly int $size,
        public readonly ?string $collection = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'path' => $this->path,
            'disk' => $this->disk,
            'file_hash' => $this->file_hash,
            'size' => $this->size,
            'collection' => $this->collection,
        ];
    }
}
