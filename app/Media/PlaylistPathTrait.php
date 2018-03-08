<?php

namespace App\Media;

trait PlaylistPathTrait
{
    use ThumbnailPathTrait;

    public function getThumbnailFolderAttribute()
    {
        return "playlist/{$this->id}";
    }

    public function getThumbnailDefaultAttribute()
    {
        return env('PLAYLIST_NO_THUMBNAIL');
    }

    public function getThumbnailPathAttribute()
    {
        return $this->isLocalDriver()
            ? route('admin.playlists.thumbnail-path', ['playlist' => $this->id])
            : $this->thumbnail_file;
    }

    public function getThumbnailSmallPathAttribute()
    {
        return $this->isLocalDriver()
            ? route('admin.playlists.thumbnail-small-path', ['playlist' => $this->id])
            : $this->thumbnail_small_file;
    }
}