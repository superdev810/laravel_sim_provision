<?php

namespace App\Repositories;

use App\Models\Package;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Yajra\Datatables\Datatables;


/**
 * Class PackageRepository
 * @package namespace App\Repositories;
 */
class PackageRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Package::class;
    }

    public function listDataTable()
    {

        $enroll = \DB::table('packages');


        return Datatables::of($enroll)
            ->addColumn('action', function ($enrollData) {
                return '<button  id="edit-' . $enrollData->id . '" class="edit-item btn btn-sm blue"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
            })->make(true);
    }
    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
