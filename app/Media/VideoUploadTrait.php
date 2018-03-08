<?php

namespace App\Media;

use Illuminate\Http\UploadedFile;
use Imagine\Image\Box;

trait VideoUploadTrait
{
    /**
     * @param $id
     * @param UploadedFile $file
     * @return mixed
     */
    public function uploadArchive($id, UploadedFile $file)
    {
        $model = $this->find($id);
        $name = $this->filename($model, $file, 'archive');

        if ($name) {
            $this->eraseArchive($model);
            $model->archive = $name;
            $model->save();
        }

        return $model;
    }

    /**
     * @param $model
     */
    protected function eraseArchive($model)
    {
        $storage = $model->getStorage();

        if ($storage->exists($model->archive_name)) {
            $storage->delete($model->archive_name);
        }
    }
}