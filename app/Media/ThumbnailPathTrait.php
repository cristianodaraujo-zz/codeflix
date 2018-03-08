<?php

namespace App\Media;

trait ThumbnailPathTrait
{
    use VideoStorageTrait;

    public function getThumbnailNameAttribute()
    {
        return $this->thumbnail ? "{$this->thumbnail_folder}/{$this->thumbnail}" : false;
    }

    public function getThumbnailSmallNameAttribute()
    {
        if (! $this->thumbnail) {
            return false;
        }

        list($name, $extension) = explode('.', $this->thumbnail);

        return "{$this->thumbnail_folder}/{$name}-small.{$extension}";
    }

    public function getThumbnailFileAttribute()
    {
        return $this->thumbnail_name ? $this->getRootPath($this->getStorage(), $this->thumbnail_name) : false;
    }

    public function getThumbnailSmallFileAttribute()
    {
        return $this->thumbnail_name ? $this->getRootPath($this->getStorage(), $this->thumbnail_small_name) : false;
    }
}