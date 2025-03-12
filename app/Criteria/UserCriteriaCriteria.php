<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserCriteriaCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserCriteriaCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if(!empty(request()->query()['name'])){
            $model = $model->where('name', request()->query('name'));
        }
        if(!empty(request()->query()['email'])) {
            $model = $model->where('email', request()->query('email'));
        }
        return $model;

    }
}
