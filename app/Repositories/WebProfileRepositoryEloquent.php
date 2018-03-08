<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WebProfileRepository;
use App\Models\WebProfile;
use App\Validators\WebProfileValidator;

/**
 * Class WebProfileRepositoryEloquent
 * @package namespace App\Repositories;
 */
class WebProfileRepositoryEloquent extends BaseRepository implements WebProfileRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WebProfile::class;
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
     * @throws \Exception
     */
    public function create(array $attributes)
    {
        $attributes['code'] = 'processing';

        \DB::beginTransaction();

        try {
            $model = parent::create($attributes);
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        \DB::commit();

        return $model;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function update(array $attributes, $id)
    {
        \DB::beginTransaction();

        try {
            $model = parent::update($attributes, $id);
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        \DB::commit();

        return $model;
    }

    /**
     * @param $id
     * @return int
     * @throws \Exception
     */
    public function delete($id)
    {
        \DB::beginTransaction();

        try {
            $result = parent::delete($id);
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        \DB::commit();

        return $result;
    }
}
