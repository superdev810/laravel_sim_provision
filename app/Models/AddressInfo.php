<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class AddressInfo extends Model
{
    protected $fillable = [
        "full_name",
        "sumame",
        "indentification_type",
        "id_nationality",
        "id_number",
        "password_number",
        "address_1",
        "city_town",
        "country",
        "suburb",
        "postal_code",
        "contact_no",
        "proof_of_address",
        "file_id"
    ];

    protected $table = 'address_info';

    public function listDataTable()
    {
        $simcData = \DB::table('address_info')
            ->join('user_files', 'address_info.file_id', '=', 'user_files.id')
            ->select(
                'address_info.id',
                'address_info.full_name as full_name',
                'address_info.sumame as sumame',
                'address_info.indentification_type as indentification_type',
                'address_info.id_nationality as id_nationality',
                'address_info.address_1 as address_1',
                'address_info.city_town as city_town',
                'address_info.country as country',
                'address_info.id_number as id_number',
                'address_info.postal_code as postal_code',
                'address_info.contact_no as contact_no',
                'address_info.proof_of_address as proof_of_address',
                'user_files.file_name as file_name');


        return Datatables::of($simcData)->make(true);
    }


    public function countByDate()
    {
        return $this->groupBy(DB::raw('CAST(created_at AS DATE)'))->select('created_at', DB::raw('count(*) as total'))
            ->get();
    }


    public function getByRandomly()
    {
        return  DB::table('address_info')
            ->inRandomOrder()
            ->first();
    }

    public function getCountAll()
    {
        return DB::table('address_info')->count();
    }
}
