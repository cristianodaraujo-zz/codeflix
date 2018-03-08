<?php

namespace App\Repositories;

use App\Media\FileUploadTrait;
use App\Media\ThumbnailUploadTrait;
use App\Media\VideoUploadTrait;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Video;

/**
 * Class VideoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class VideoRepositoryEloquent extends BaseRepository implements VideoRepository
{
    use ThumbnailUploadTrait, VideoUploadTrait, FileUploadTrait;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Video::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $model = parent::update($attributes, $id);

        if (isset($attributes['categories'])) {
            $model->categories()->sync($attributes['categories']);
        }

        return $model;
    }
}
