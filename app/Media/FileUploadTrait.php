<?php

namespace App\Media;

use Illuminate\Http\UploadedFile;

trait FileUploadTrait
{

    /**
     * @param $model
     * @param UploadedFile $file
     * @return string
     */
    protected function filename($model, UploadedFile $file, $type)
    {
        $storage = $model->getStorage();
        $name = md5(time() ."{$model->id}-{$file->getClientOriginalName()}") .".{$file->guessExtension()}";
        $result = $storage->putFileAs($model->{"{$type}_folder"}, $file, $name);

        return $result ? $name : $result;
    }

}