<?php

namespace App\Media;

use Illuminate\Http\UploadedFile;
use Imagine\Image\Box;

trait ThumbnailUploadTrait
{
    /**
     * @param $id
     * @param UploadedFile $file
     * @return mixed
     */
    public function uploadThumbnail($id, UploadedFile $file)
    {
        $model = $this->find($id);
        $name = $this->filename($model, $file, 'thumbnail');

        if ($name) {
            $this->eraseThumbnail($model);
            $model->thumbnail = $name;
            $this->small($model);
            $model->save();
        }

        return $model;
    }

    /**
     * @param $model
     */
    protected function small($model)
    {
        $format = \ImageManager::format($model->thumbnail_file);
        $thumbnail = \ImageManager::open($model->thumbnail_file)->thumbnail(new Box(64, 36));

        $storage = $model->getStorage();
        $storage->put($model->thumbnail_small_name, $thumbnail->get($format));
    }

    /**
     * @param $model
     */
    protected function eraseThumbnail($model)
    {
        $storage = $model->getStorage();

        if ($storage->exists($model->thumbnail_name) && $model->thumbnail != $model->thumbnail_default) {
            $storage->delete([
                $model->thumbnail_name,
                $model->thumbnail_small_name,
            ]);
        }
    }
}