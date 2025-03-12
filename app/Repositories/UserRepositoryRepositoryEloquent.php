<?php

namespace App\Repositories;

use App\Criteria\UserCriteriaCriteria;
use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserRepositoryRepository;
use App\Entities\UserRepository;
use App\Validators\UserRepositoryValidator;

/**
 * Class UserRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryRepositoryEloquent extends BaseRepository implements UserRepositoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(UserCriteriaCriteria::class));
    }

}
