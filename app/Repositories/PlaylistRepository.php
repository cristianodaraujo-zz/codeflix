<?php

namespace App\Repositories;

use Illuminate\Http\UploadedFile;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PlaylistRepository
 * @package namespace App\Repositories;
 */
interface PlaylistRepository extends RepositoryInterface
{
    public function uploadThumbnail($id, UploadedFile $file);
}
