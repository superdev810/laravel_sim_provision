<?php

namespace App;
use App\Models\GlobalSettings;
use App\Models\UserFile;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Yajra\Datatables\Facades\Datatables;


class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'password','active','email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $table = 'users';

    const ACTIVE = true;
    const IN_ACTIVE = false;

    public function listDataTable()
    {
        $settings = $this->all();
        return Datatables::of($settings)
            ->addColumn('action', function ($groupData) {
                return '<button  id="edit-' . $groupData->id . '" class="edit-item btn btn-sm blue"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
            })->make(true);
    }


    public function insert(Request $request)
    {
        return $this->create([
            'full_name'  => $request->get('full_name'),
            'email'     => $request->get('email'),
            'password'  => bcrypt($request->get('password')),
            'active'    => self::ACTIVE
        ]);
    }

    public function updateUser(Request $request, $userId)
    {
        return $this->find($userId)->update($request->all());
    }

    public function userFiles()
    {
        return $this->hasMany('App\Models\UserFile');
    }

    public function getTotalByFileType($fileType)
    {
        $result = $this->with(['userFiles'=>function($query) use($fileType){
            $query->where('file_type',$fileType);
        }])->first();

        return $result->userFiles->count();
    }
}
