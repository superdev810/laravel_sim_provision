<?php

namespace App\Console\Commands;

use App\Lib\SoapApi;
use App\Models\AddressInfo;
use App\Models\Report;
use App\Models\SimInfo;
use App\Models\UserFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RegisterSimInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sim:register {fileId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registration sim file data';

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
        Log::error("Start with file id : " . empty($this->argument('fileId')));

        $address = new AddressInfo();

        if ($address->getCountAll() > 0) {
            $simObject = new SimInfo();
            $report = new Report();

            $simInfo = $simObject->getByFileId((int)$this->argument('fileId'));
            $file = UserFile::find((int)$this->argument('fileId'));

            foreach ($simInfo as $each) {

                $addressData = $address->getByRandomly();

                $response = $this->processData($file, $each, $addressData);

                Log::info("Api Data",$response);

                if (empty($response["Api"])) continue;

                if (!empty($response["Api"]->registerMSISDNReturn->resultCode) && $response["Api"]->registerMSISDNReturn->resultCode == "Success") {

                    $resultReport = $report->createReport([
                        'network' => $each->network,
                        'existing_new_subscribe' => $each->existing_new_subscribe,
                        'sim_stater_pack' => $each->sim_stater_pack,
                        'last_4_digit_of_sim' => $each->last_4_digit_of_sim,
                        'last_4_digit_of_sim' => $each->last_4_digit_of_sim,
                        'address_id' => $addressData->id
                    ]);

                    if ($resultReport) {
                        $each->delete();
                    }
                    sleep(1);

                } else if (!empty($response["Api"]->registerMSISDNReturn->resultCode) && $response["Api"]->registerMSISDNReturn->resultCode == "Failure") {
                    $simObject->updateDependOnResponse($response["Api"]->registerMSISDNReturn, $each,$response["ApiData"]);
                }
            }
        }
    }


    public function processData($file, $simData, $addressData)
    {
        Log::info("Curl send...");

        $url = 'https://www.ricaonline.co.za/ricaregistrationservice/registrationservice.asmx?WSDL';

        $soapApi = new SoapApi($url, true);



        $user = Array(
            'groupName' => 'DXVNC',
            'password' => Array('_' => 'KA7Q3M6D'),
            'Agent' => 'BRSXM',
            'network' => 'MTN, Vodacom, CellC, Telkom, Virgin',
            'operatorID' => 'Mobile Tablet App'
        );

        $countrycode = 'ZAF';

        $info = Array();


        $info['MSISDNnetwork'] = $simData->network;
        $info['last4SIM'] = $simData->last_4_digit_of_sim;
        $info['referenceNumber'] = $simData->sim_number;
        $info['existing'] = 'false';
        $info['referenceType'] = 'StarterPackRef';
        $info['networkOptIn'] = '';
        $info['retailerOptIn'] = '';
        $info['proofOfAddress'] = '';
       


        $info['idInfo'] = Array();
        $info['idInfo']['countryCode'] = $countrycode;
        $info['idInfo']['IDNumber'] = $addressData->id_number;
        $info['idInfo']['IDType'] = 'N';
        $info['idInfo']['companyName'] = '';
        $info['idInfo']['businessRegistration'] = '';

        $info['firstName'] = $addressData->full_name;
        $info['lastName'] = $addressData->sumame;
        $info['contactNo'] = Array();
        $info['contactNo']['countryCode'] = $countrycode;
        $info['contactNo']['areaCode'] = '(0)';

        $info['addressIndividual'] = Array();
        $info['addressIndividual']['addressLine1'] = $addressData->address_1;
        $info['addressIndividual']['addressLine2'] = '';
        $info['addressIndividual']['addressLine3'] = '';
        $info['addressIndividual']['countryCode'] = $countrycode;
        $info['addressIndividual']['postalCode'] = $addressData->postal_code;
        $info['addressIndividual']['region'] = '';
        $info['addressIndividual']['suburb'] = $addressData->suburb;
        $info['addressIndividual']['cityTown'] = $addressData->city_town;
        $response = null;

        try {
            $response = $soapApi->registerMSISDN($user, $info);
        } catch (\Exception $e) {
            Log::error($e);
        }

        return ["Api" => $response,"ApiData" => array_merge($user,$info)];
    }
}
