<?php

namespace App\Media;

trait VideoPathTrait
{
    use ThumbnailPathTrait;

    public function getThumbnailFolderAttribute()
    {
        return "video/{$this->id}";
    }

    public function getArchiveFolderAttribute()
    {
        return "video/{$this->id}";
    }

    public function getThumbnailDefaultAttribute()
    {
        return env('VIDEO_NO_THUMBNAIL');
    }

    public function getArchivePathAttribute()
    {
        return $this->isLocalDriver()
            ? route('admin.videos.archive-path', ['video' => $this->id])
            : $this->archive_file;
    }

    public function getThumbnailPathAttribute()
    {
        return $this->isLocalDriver()
            ? route('admin.videos.thumbnail-path', ['video' => $this->id])
            : $this->thumbnail_file;
    }

    public function getThumbnailSmallPathAttribute()
    {
        return $this->isLocalDriver()
            ? route('admin.videos.thumbnail-small-path', ['video' => $this->id])
            : $this->thumbnail_small_file;
    }

    public function getArchiveNameAttribute()
    {
        return $this->archive ? "{$this->archive_folder}/{$this->archive}" : false;
    }

    public function getArchiveFileAttribute()
    {
        return $this->archive_name ? $this->getRootPath($this->getStorage(), $this->archive_name) : false;
    }
}