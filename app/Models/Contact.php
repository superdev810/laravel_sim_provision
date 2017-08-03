<?php
namespace App\Models;


use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Yajra\Datatables\Datatables;
use MongoDB\BSON\ObjectId;

class Contact extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_file',
        'first_name',
        'last_name',
        'email',
        'street',
        'city',
        'state',
        'zip',
        'phone',
        'gender',
        'optin_date',
        'optin_time',
        'ip_address',
        'mobile',
        'custom_field_1',
        'custom_field_2',
        'custom_field_3',
        'custom_field_4',
        'custom_field_5',
    ];

    protected $collection = 'contact';

    public function listDataTable()
    {
        $domainEmails = $this->where('user', new ObjectId(Auth::id()))->get();
        return Datatables::of($domainEmails)
            ->addColumn('action', function ($groupData) {
                return '<button  id="edit-' . $groupData->id . '" class="edit-item btn btn-sm blue"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
            })->make(true);
    }
}
