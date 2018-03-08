<?php

namespace App\Repositories;

use App\Media\FileUploadTrait;
use App\Media\ThumbnailUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Playlist;

/**
 * Class PlaylistRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PlaylistRepositoryEloquent extends BaseRepository implements PlaylistRepository
{
    use ThumbnailUploadTrait, FileUploadTrait;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Playlist::class;
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
     * @return mixed
     */
    public function create(array $attributes)
    {
        $attributes['thumbnail'] = env('PLAYLIST_NO_THUMBNAIL');
        Model::unguard();

        $model = parent::create(array_except($attributes, 'thumbnail_file'));

        $this->uploadThumbnail($model->id, $attributes['thumbnail_file']);
    }


    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $model = parent::update(array_except($attributes, 'thumbnail_file'), $id);

        if (isset($attributes['thumbnail_file'])) {
            $this->uploadThumbnail($model->id, $attributes['thumbnail_file']);
        }

        return $model;
    }
}
