<?php
namespace App\Models;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model as Eloquent;
use MongoId;
use Yajra\Datatables\Datatables;
use MongoDB\BSON\ObjectId;

class Process extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    const LOCK = 1;
    const UNLOCK = 0;

    protected $fillable = [
        'script_id',
        'status',
    ];

    protected $table = 'processes';

    public function isSciptLock($scriptId)
    {
        $scriptInfo = $this->where('script_id', $scriptId)->where('status', self::LOCK)->get();
        return ($scriptInfo->count() > 0);
    }

    public function lockScript($scriptId)
    {
        $scriptInfo = $this->where('script_id', $scriptId)->get();
        if($scriptInfo->count() == 0) {
            return $this->create(['script_id' => $scriptId, 'status' => self::LOCK]);
        } else {
            $script = $this->where('script_id', $scriptId)->first();
            $script->status = self::LOCK;
            return $script->save();
        }
    }

    public function unlockScript($scriptId)
    {
        $script = $this->where('script_id', $scriptId)->first();
        $script->status = self::UNLOCK;
        return $script->save();
    }


}
