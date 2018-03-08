<?php

namespace App\Repositories;

use Illuminate\Http\UploadedFile;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface VideoRepository
 * @package namespace App\Repositories;
 */
interface VideoRepository extends RepositoryInterface
{
    public function uploadThumbnail($id, UploadedFile $file);
    public function uploadArchive($id, UploadedFile $file);
}
