<?php
/**
 * SimRegistrationController File
 *
 * @author Md.Atiqul haque <md_atiqulhaque@yahoo.com>
 */
namespace App\Http\Controllers\User;


use App\Events\ReporcessRegistration;
use App\Http\Controllers\BaseController;
use App\Lib\Api;
use App\Lib\File\ImageUtility;
use App\Lib\SoapApi;
use App\Lib\Uploader\FileUpload;
use App\Lib\Url;
use App\Models\Contact;
use App\Models\SimInfo;
use App\Models\UserDomain;
use App\Models\UserFile;
use App\Models\AddressInfo;
use Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Response;
use Validator;

class SimRegistrationController extends BaseController
{

    protected $userFile;
    protected $simInfo;

    public function __construct(UserFile $userFile,SimInfo $siminfo)
    {
        $this->userFile = $userFile;
        $this->simInfo = $siminfo;
    }

    public function index()
    {
        return view('user.registration.index');
    }


    public function submitApi(Request $request)
    {
        $url = 'https://www.ricaonline.co.za/ricaregistrationservice/registrationservice.asmx?WSDL';
        $soapApi = new SoapApi($url, true);

        $networkList = ['MTN', 'Vodacom', 'CellC', 'Telkom', 'Virgin'];

        $user = Array(
            'groupName' => '9SMART',
            'password' => Array('_' => 'halo0104'),
            'Agent' => 'QKCAB',
            'network' => 'MTN, Vodacom, CellC, Telkom, Virgin',
            'operatorID' => 'Mobile Tablet App'
        );

        $countrycode = '27';

        $info = Array();



        $info['MSISDNnetwork'] = $networkList[$request->get('MSISDNnetwork')];
        $info['last4SIM'] = $request->get('last4SIM');
        $info['referenceNumber'] = $request->get('referenceNumber');
        $info['existing'] = false;
        $info['referenceType'] = 'StarterPackRef';
        $info['networkOptIn'] = '';
        $info['retailerOptIn'] = '';
        $info['portDate'] = '';
        $info['proofOfAddress'] = '';
        $info['portMsisdn'] = '';
        $info['portInCheck'] = 'false';


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

        $response = $soapApi->registerMSISDN($user, $info);

        return Response::json([
            'html' => $response,
            'status' => 'success'
        ]);

    }

    public function bulkRegistration(Request $request)
    {
        $fileId = $request->get('fileId');
        if(!empty($fileId)){
            Event::fire(new ReporcessRegistration($fileId));
            return Response::json([
                'html' => "Successfully start reprocess",
                'status' => 'success'
            ]);
        } else {
            return Response::json([
                'html' => "Reprocess start failed. Invalid File id",
                'status' => 'error'
            ]);

        }


    }
}