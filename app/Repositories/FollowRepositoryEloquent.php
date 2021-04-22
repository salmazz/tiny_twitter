<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FollowRepository;
use App\Entities\Follow;
use App\Validators\FollowValidator;

/**
 * Class FollowRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FollowRepositoryEloquent extends BaseRepository implements FollowRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Follow::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
