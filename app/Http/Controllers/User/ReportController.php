<?php
/**
 * DomainController File
 *
 * @author Md.Atiqul haque <md_atiqulhaque@yahoo.com>
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\BaseController;
use App\Lib\Api;
use App\Lib\File\ImageUtility;
use App\Lib\Uploader\FileUpload;
use App\Lib\Url;
use App\Models\Contact;
use App\Models\Report;
use App\Models\SimInfo;
use App\Models\UserDomain;
use App\Models\UserFile;
use App\Models\AddressInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Response;
use Validator;
use MongoDB\BSON\ObjectId;

class ReportController extends BaseController
{

    protected $report;
    protected $sim;
    protected $simInfo;

    /**
     * @param Report $report
     * @param SimInfo $sim
     */
    public function __construct(Report $report, SimInfo $sim)
    {
        $this->report = $report;
        $this->sim    = $sim;
    }

    public function index()
    {
        return view('user.report.success');
    }

    public function failed()
    {
        return view('user.report.failed');
    }

    public function pending()
    {
        return view('user.report.pending');
    }

    public function retry()
    {
        return view('user.report.retry');
    }



    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listSuccessReport(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('AdminDashboard', 'Direct access is denied.');
        }
        return $this->report->listDataTable();

    }


    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listFailedReport(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('AdminDashboard', 'Direct access is denied.');
        }
        return $this->sim->listDataTableByStatus(SimInfo::PROCESS_FAILED);

    }


    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listRetryReport(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('AdminDashboard', 'Direct access is denied.');
        }

        return $this->sim->listDataTableByStatus(SimInfo::PROCESS_RETRY);

    }

    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listPendingReport(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('AdminDashboard', 'Direct access is denied.');
        }
        return $this->sim->listDataTableByStatus(SimInfo::PROCESS_PENDING);
    }
}