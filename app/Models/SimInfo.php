<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class SimInfo extends Model
{
    const PROCESS_PENDING = 0;
    const PROCESS_SUCCESS = 1;
    const PROCESS_FAILED = 2;
    const PROCESS_RETRY = 3;

    protected $fillable = [
        "network",
        "existing_new_subscribe",
        "sim_stater_pack",
        "last_4_digit_of_sim",
        "sim_number",
        "process_flag",
        "process_date",
        "response_code",
        "retry",
        "file_id",
        'message'
    ];

    protected $table = 'sim_info';

    public function listDataTableByStatus($status = self::PROCESS_PENDING)
    {
        $simcData = \DB::table('sim_info')
            ->join('user_files', 'sim_info.file_id', '=', 'user_files.id')
            ->where('process_flag', $status)
            ->select(
                'sim_info.id',
                'sim_info.network as network',
                'sim_info.last_4_digit_of_sim as last_4_digit_of_sim',
                'sim_info.sim_number as sim_number',
                'sim_info.existing_new_subscribe as existing_new_subscribe',
                'sim_info.sim_stater_pack as sim_stater_pack',
                'sim_info.process_flag as process_flag',
                'sim_info.process_date as process_date',
                'sim_info.retry as retry',
                'sim_info.response_code as response_code',
                'sim_info.message as message',
                'user_files.file_name as file_name');

        return Datatables::of($simcData)->addColumn('action', function ($groupData) {
            return '<button  id="delete-' . $groupData->id . '" class="delete-item btn btn-sm red">Delete</button>';
        })->make(true);
    }


    public function listDataTable()
    {
        $simcData = \DB::table('sim_info')
            ->join('user_files', 'sim_info.file_id', '=', 'user_files.id')
            ->select(
                'sim_info.id',
                'sim_info.network as network',
                'sim_info.last_4_digit_of_sim as last_4_digit_of_sim',
                'sim_info.sim_number as sim_number',
                'sim_info.sim_stater_pack as sim_stater_pack',
                'sim_info.process_flag as process_flag',
                'sim_info.process_date as process_date',
                'sim_info.message as message',
                'sim_info.response_code as response_code',
                'user_files.file_name as file_name');

        return Datatables::of($simcData)->addColumn('action', function ($groupData) {
            return '<button  id="delete-' . $groupData->id . '" class="delete-item btn btn-sm red">Delete</button>';
        })->make(true);
    }

    public function listDataTableByFileId($file_id)
    {

        $simcData = \DB::table('sim_info')
            ->join('user_files', function ($join) use ($file_id) {
                $join->on('sim_info.file_id', '=', 'user_files.id')
                    ->where('user_files.id', '=', $file_id);
            })
            ->select(
                'sim_info.id',
                'sim_info.network as network',
                'sim_info.last_4_digit_of_sim as last_4_digit_of_sim',
                'sim_info.sim_number as sim_number',
                'sim_info.existing_new_subscribe as existing_new_subscribe',
                'sim_info.sim_stater_pack as sim_stater_pack',
                'sim_info.process_date as process_date',
                'sim_info.process_flag as process_flag',
                'sim_info.message as message',
                'sim_info.response_code as response_code',
                'user_files.file_name as file_name');

        return Datatables::of($simcData)->addColumn('action', function ($groupData) {
            return '<button  id="delete-' . $groupData->id . '" class="delete-item btn btn-sm red">Delete</button>';
        })->make(true);
    }

    public function getSimGroupByProcessFlag()
    {
        return DB::table('sim_info')
            ->select('process_flag', DB::raw('count(*) as total'))
            ->groupBy('process_flag')
            ->get();
    }


    public function countByDate()
    {
        return $this->groupBy(DB::raw('CAST(created_at AS DATE)'))->select('created_at', DB::raw('count(*) as total'))
            ->get();
    }

    public function getByFileId($file_id)
    {
        return $this->where('file_id', $file_id)->get();
    }

    public function updateDependOnResponse($pesponse, $sim, $ApiData)
    {
        $sim->response_code = empty($sim->response_code) ? $pesponse->errorCode->_ : $sim->response_code . '::' . $pesponse->errorCode->_;
        $sim->message = empty($sim->message) ?
            $pesponse->messageDetails :
            $sim->message . '------' . $pesponse->messageDetails;
        $sim->process_flag = self::PROCESS_FAILED;
        $sim->process_date = date('Y-m-d H:i:s');
        return $sim->save();
    }


}
