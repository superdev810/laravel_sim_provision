<?php

namespace App\Repositories;

use App\Contracts\Repositories\ReligionRepository;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Group;
use App\Models\Package;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Yajra\Datatables\Datatables;


/**
 * Class ContactRepository
 * @package namespace App\Repositories;
 */
class ContactRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contact::class;
    }

    public function insert(Request $request, $userId)
    {
        return $this->create([
            'user_id'               =>  $userId,
            'group_id'              =>  $request->get('group_id'),
            'email'                 =>  $request->get('email'),
            'first_name'            =>  $request->get('first_name'),
            'last_name'             =>  $request->get('last_name'),
            'contact'               =>  $request->get('contact'),
            'country_id'            =>  $request->get('country_id'),
            'zip'                   =>  $request->get('zip')
        ]);

    }

    public function listDataTable()
    {
        $contact = \DB::table('contacts')
            ->join('groups', 'groups.id', '=', 'contacts.group_id')
            ->select(
                'contacts.id',
                'contacts.first_name as first_name',
                'contacts.last_name as last_name',
                'contacts.email as email',
                'contacts.zip as zip',
                'contacts.contact as contact',
                'groups.name as group');

        return Datatables::of($contact)
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
