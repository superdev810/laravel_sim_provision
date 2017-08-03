<?php namespace App\Models;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model as Eloquent;
use MongoId;
use Yajra\Datatables\Datatables;
use MongoDB\BSON\ObjectId;

class UserFile extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    const SUCCESS = "success";
    const PROCESSING = "processing";
    const PENDING = "pending";
    const FAILED = "failed";
    const CHUNK_UPLOAD = 1000;
    const ADDRESS = 1;
    const SIM = 2;

    protected $fillable = [
        'user_id',
        'file_name',
        'file_type',
        'uuid',
        'agent',
        'group',
        'password',
        'total_contact',
        'status',
    ];

    protected $table = 'user_files';

    public function insert($fileInfo)
    {
        return $this->create([
            'user_id' => Auth::id(),
            'file_name' => $fileInfo['uploadName'],
            'uuid' => $fileInfo['uuid'],
            'status' => self::PENDING,
            'file_type' => $fileInfo['file_type'],
            'group' => $fileInfo['group'],
            'agent' => $fileInfo['agent'],
            'password' => $fileInfo['password'],
            'total_contact' => (int)$fileInfo['total_contact'],
        ]);
    }


    public function listDataTable($file_type)
    {
        $data = $this->where('user_id', Auth::id())->where('file_type', $file_type);

        return Datatables::of($data)->addColumn('action', function ($enrollData) {
            $button = '<a href="'.route('sim-file-details',['fileId' => $enrollData->id]).'"   class="show-item btn btn-sm btn-success">View Details</a>';
            $button .= '<button  id="delete-' . $enrollData->id . '" class="delete-item btn btn-sm red">Delete</button>';
            $button .= '<button  id="reprocess-' . $enrollData->id . '" class="reprocess-item btn btn-sm green">Re-process</button>';
            return $button;
        })->make(true);
    }

    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function getPendingFile()
    {
        return $this->where('status', self::PENDING)->first();
    }

}
