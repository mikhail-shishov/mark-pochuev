<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Services\Contracts\UploadServiceContract;
use Illuminate\Http\JsonResponse;

class UploadController extends Controller
{
    public function __construct(
        protected UploadServiceContract $uploadService,
    ) {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(UploadRequest $request): JsonResponse
    {
        $media = $this->uploadService->upload(
            file: $request->file('file'),
            collection: $request->input('collection'),
        );

        return new JsonResponse(
            data: $media,
            status: 201,
        );
    }
}
