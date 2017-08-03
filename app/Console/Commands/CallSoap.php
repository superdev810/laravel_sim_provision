<?php
namespace App\Console\Commands;

use App\Lib\SoapApi;
use Illuminate\Console\Command;

class CallSoap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'soap:registration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $url = 'https://www.ricaonline.co.za/ricaregistrationservice/registrationservice.asmx?WSDL';
        $soapApi = new SoapApi($url, true);

        $group = '9SMART';
        $password = 'halo0104';
        $agent = 'QKCAB';

        $network = 'MTN, Vodacom, CellC, Telkom, Virgin';

        $user = Array(
            'groupName' => $group,
            'password' => Array('_' => $password),
            'Agent' => $agent,
            'network' => $network,
            'operatorID' => 'Mobile Tablet App'
        );

        $countrycode = '27';

        $info = Array();

        $info['MSISDNnetwork'] = 'MTN';
        $info['last4SIM'] = '0060';
        $info['referenceNumber'] = 'A650081576';

        $info['existing'] = false;
        $info['referenceType'] = 'StarterPackRef';
        $info['networkOptIn'] = '';
        $info['retailerOptIn'] = '';
        $info['portDate'] = '';
        $info['proofOfAddress'] = '';
        $info['portInCheck'] = 'false';
        $info['portMsisdn'] = '';
        $info['idInfo'] = Array();
        $info['idInfo']['countryCode'] = $countrycode;
        $info['idInfo']['IDNumber'] = '7103180405081';
        $info['idInfo']['IDType'] = 'N';
        $info['idInfo']['companyName'] = '';
        $info['idInfo']['businessRegistration'] = '';

        $info['firstName'] = 'James';
        $info['lastName'] = 'Bond';
        $info['contactNo'] = Array();
        $info['contactNo']['countryCode'] = $countrycode;
        $info['contactNo']['areaCode'] = '(0)';

        $info['addressIndividual'] = Array();
        $info['addressIndividual']['addressLine1'] = '325 rivonia';
        $info['addressIndividual']['addressLine2'] = '';
        $info['addressIndividual']['addressLine3'] = '';
        $info['addressIndividual']['countryCode'] = $countrycode;
        $info['addressIndividual']['postalCode'] = '4567';
        $info['addressIndividual']['region'] = '';
        $info['addressIndividual']['suburb'] = 'Sandton';
        $info['addressIndividual']['cityTown'] = 'South Africa';

        $info['firstName'] = 'James';


        $soapApi->registerMSISDN($user, $info);
    }
}
