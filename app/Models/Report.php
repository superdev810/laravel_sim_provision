<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class Report extends Model
{

    protected $fillable = [
        "network",
        "existing_new_subscribe",
        "sim_stater_pack",
        "last_4_digit_of_sim",
        "sim_number",
        "address_id"
    ];

    protected $table = 'reports';

    public function createReport($data)
    {
        return $this->create([
            "network" =>$data["network"],
            "existing_new_subscribe"=>$data["existing_new_subscribe"],
            "sim_stater_pack"=>$data["sim_stater_pack"],
            "last_4_digit_of_sim"=>$data["last_4_digit_of_sim"],
            "sim_number"=>$data["sim_number"],
            "address_id" =>$data["address_id"]
        ]);
    }


    public function listDataTable()
    {
        $enroll = \DB::table('reports')
            ->join('address_info', 'address_info.id', '=', 'reports.address_id')
            ->select(
                'reports.id',
                'address_info.full_name as full_name',
                'address_info.id_number as id_number',
                'address_info.address_1 as address_1',
                'address_info.sumame as sumame',
                'address_info.contact_no as contact_no',
                'reports.sim_number as sim_number');


        return Datatables::of($enroll)
            ->addColumn('action', function ($enrollData) {
                return '<button  id="edit-' . $enrollData->id . '" class="edit-item btn btn-sm btn-success"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
            })->make(true);
    }


    public function countByDate()
    {
        return $this->groupBy(DB::raw('CAST(created_at AS DATE)'))->select('created_at', DB::raw('count(*) as total'))
            ->get();
    }

}
