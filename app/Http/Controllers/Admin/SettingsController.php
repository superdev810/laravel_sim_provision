<?php
/**
 * HomeController File
 *
 * @author Md.Atiqul haque <md_atiqulhaque@yahoo.com>
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Models\GlobalSettings;
use Illuminate\Http\Request;
use Response;
use Validator;

class SettingsController extends BaseController
{

    protected $settings;

    public function __construct(GlobalSettings $settings)
    {
        $this->settings = $settings;
    }

    public function index()
    {
        return view('admin.settings.index');
    }


    public function getFrom(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }
        return Response::json([
            'html' => view('admin.settings.form')->render(),
            'status' => 'success'
        ]);
    }

    public function getEditForm(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }


        $settingsData = $this->settings->find($request->get('id'));

        if (empty($settingsData)) {
            return Response::json([
                'html' => "No data found",
                'status' => 'error'
            ]);
        }

        return Response::json([
            'html' => view('admin.settings.form')->with([
                'settingData' => $settingsData])->render(),
            'status' => 'success'
        ]);
    }

    public function editSubmit(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('dashboard', 'Direct access is denied.');
        }

        $validator = $this->validateSettings($request->all());


        if ($validator->fails()) {
            return Response::json([
                'html' => $validator->messages(),
                'status' => 'validation-error'
            ]);
        }

        if ($this->settings->updateSettings($request, $request->get('id'))) {
            return Response::json([
                'html' => "Data successfully updated",
                'status' => 'success'
            ]);
        }

        return Response::json([
            'html' => "Data insertion failed.Submit the form again",
            'status' => 'error'
        ]);
    }


    protected function validateSettings(array $data)
    {
        return Validator::make($data, [
            'default_domain_per_user' => 'required',
            'per_hour_limit' => 'required',
            'per_day_limit' => 'required'
        ]);
    }


    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listData(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('AdminDashboard', 'Direct access is denied.');
        }

        return $this->settings->listDataTable();

    }
}