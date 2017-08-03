<?php

namespace App\Repositories;

use App\Contracts\Repositories\ReligionRepository;
use App\Models\Group;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Yajra\Datatables\Datatables;


/**
 * Class GroupRepository
 * @package namespace App\Repositories;
 */
class GroupRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Group::class;
    }

    public function insert(Request $request, $userId)
    {
        return $this->create([
            'user_id' => $userId,
            'name' => $request->get('name'),
            'descriptions' => $request->get('descriptions')
        ]);

    }

    public function getByUserId($userId)
    {
        return $this->findByField('user_id', $userId);
    }

    public function listDataTable()
    {

        $group = \DB::table('groups');


        return Datatables::of($group)
            ->addColumn('action', function ($groupData) {
                return '<button  id="edit-' . $groupData->id . '" class="edit-item btn btn-sm blue"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
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
