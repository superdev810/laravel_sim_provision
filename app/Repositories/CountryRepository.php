<?php

namespace App\Repositories;

use App\Models\Country;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;


/**
 * Class CountryRepository
 * @package namespace App\Repositories\Eloquent;
 */
class CountryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Country::class;
    }


    public function getAll()
    {
        return $this->all()->pluck('name','id');
    }
    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
