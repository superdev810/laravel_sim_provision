<?php

namespace App\Console\Commands;

use App\Lib\File\ImageUtility;
use App\Models\AddressInfo;
use App\Models\Process;
use App\Models\SimInfo;
use App\Models\UserFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ProcessCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process user uploaded CSV file';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $userFileObj = new UserFile();
        $file = $userFileObj->getPendingFile();

        if (!empty($file)) {
            $fileId = $file->id;
            $fileType = $file->file_type;
            $process = new Process();

            if (!$process->isSciptLock($fileType)) {
                $process->lockScript($fileType);
                $file->status = UserFile::PROCESSING;
                $file->save();
                $utility = new ImageUtility();
                $path = $utility->getFileDirectories($file->user_id . '/' . $file->uuid . '/' . $file->file_name, true);

                if ($fileType === UserFile::ADDRESS) {
                    $this->processAddressFile($path, $fileId, $fileType, $file);
                } elseif ($fileType === UserFile::SIM) {
                    $this->processSimFile($path, $fileId, $fileType, $file);
                }
                $process->unlockScript($fileType);
            }
        }
        Log::info('Process user uploaded file successfully!');

    }


    public function processAddressFile($path, $fileId, $fileType, $file)
    {

        try {
            Excel::filter('chunk')->load($path)->chunk(UserFile::CHUNK_UPLOAD, function ($results) use ($fileId, $fileType) {

                $insertedData = array();
                $csvResult = $results->toArray();

                foreach ($csvResult as $key => $eachRow) {
                    $insertedData[] = [
                        "file_id" => $fileId,
                        "full_name" => !empty($eachRow[0]) ? $eachRow[0] : '',
                        "sumame" => !empty($eachRow[1]) ? $eachRow[1] : '',
                        "indentification_type" => !empty($eachRow[2]) ? $eachRow[2] : '',
                        "id_nationality" => !empty($eachRow[3]) ? $eachRow[3] : '',
                        "id_number" => !empty($eachRow[4]) ? $eachRow[4] : '',
                        "password_number" => !empty($eachRow[5]) ? $eachRow[5] : '',
                        "address_1" => !empty($eachRow[6]) ? $eachRow[6] : '',
                        "city_town" => !empty($eachRow[7]) ? $eachRow[7] : '',
                        "country" => !empty($eachRow[8]) ? $eachRow[8] : '',
                        "suburb" => !empty($eachRow[9]) ? $eachRow[9] : '',
                        "postal_code" => !empty($eachRow[10]) ? $eachRow[10] : '',
                        "proof_of_address" => !empty($eachRow[11]) ? $eachRow[11] : '',
                        "contact_no" => !empty($eachRow[12]) ? $eachRow[12] : '',
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
                AddressInfo::insert($insertedData);
            });
            $file->status = UserFile::SUCCESS;
            $file->save();

        } catch (\Exception $e) {
            $file->status = UserFile::FAILED;
            $file->save();
            Log::error($e->getMessage());
        }
    }


    public function processSimFile($path, $fileId, $fileType, $file)
    {
        try {

            $insertedData = [];
            $allData = Excel::setValueBinder(new MyValueBinder())->load($path)->get();

            foreach ($allData as $eachRow) {

                $insertedData[] = [
                    "network" => !empty($eachRow[0]) ? $eachRow[0] : '',
                    "existing_new_subscribe" => !empty($eachRow[1]) ? $eachRow[1] : '',
                    "sim_stater_pack" => !empty($eachRow[2]) ? $eachRow[2] : '',
                    "sim_number" => !empty($eachRow[3]) ? $eachRow[3] : '',
                    "last_4_digit_of_sim" => !empty($eachRow[4]) ? $eachRow[4] : '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'process_date' => "",
                    'process_flag' => SimInfo::PROCESS_PENDING,
                    "file_id" => $fileId,
                ];
                SimInfo::insert($insertedData);
                $insertedData = [];
            }

            $file->status = UserFile::SUCCESS;
            $file->save();
            Artisan::call('sim:register', ['fileId' => $fileId]);

        } catch (\Exception $e) {
            $file->status = UserFile::FAILED;
            $file->save();
            Log::error($e->getMessage());
        }
    }
}
