<?php

namespace App\Repositories;

use App\Models\Plan;
use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Subscription;

/**
 * Class SubscriptionRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SubscriptionRepositoryEloquent extends BaseRepository implements SubscriptionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subscription::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * @param array $attributes
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes)
    {
        $attributes['expires_at'] = $this->expireOn(
            app(PlanRepository::class)->find($attributes['plan_id'])
        );

        return parent::create($attributes);
    }

    protected function expireOn(Plan $plan)
    {
        if ($plan->duration == Plan::DURATION_YEARLY) {
            return Carbon::now()->addYear(1)->format('Y-m-d');
        } else {
            return Carbon::now()->addMonth(1)->format('Y-m-d');
        }
    }
}
