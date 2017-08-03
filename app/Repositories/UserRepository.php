<?php

namespace App\Repositories;

use App\User;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;


/**
 * Class UserRepository
 * @package namespace App\Repositories;
 */
class UserRepository extends BaseRepository
{
    const ACTIVE = 1;
    const DEACTIVE = 0;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }


    public function insert(Request $request)
    {
        //dd($request->get('country_id'));
        return $this->create([
            'fullname'  =>  $request->get('fullname'),
            'email'     =>  $request->get('email'),
            'password'  =>  bcrypt($request->get('password')),
            'status'    =>  self::ACTIVE,
            'timezone'  =>  $request->get('timezone'),
            'country_id'=>  $request->get('country_id')
        ]);

    }

    public function updateUser($data, $id)
    {
        return $this->update($data, $id);
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
