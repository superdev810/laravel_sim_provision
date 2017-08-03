<?php
/**
 * HomeController File
 *
 * @author Md.Atiqul haque <md_atiqulhaque@yahoo.com>
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Models\GlobalSettings;
use App\User;
use Illuminate\Http\Request;
use Response;
use Validator;

class AddUserController extends BaseController
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('admin.user.index');
    }


    public function getFrom(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }
        return Response::json([
            'html' => view('admin.user.form')->render(),
            'status' => 'success'
        ]);
    }

    public function fromSubmit(Request $request)
    {

        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }

        $validator = $this->validateUser($request->all());


        if ($validator->fails()) {
            return Response::json([
                'html' => $validator->messages(),
                'status' => 'validation-error'
            ]);
        }

        if ($this->user->insert($request)) {
            return Response::json([
                'html' => "Data successfully inserted",
                'status' => 'success'
            ]);
        }

        return Response::json([
            'html' => "Data insertion failed. Submit the form again",
            'status' => 'error'
        ]);
    }

    public function getEditForm(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }


        $UserData = $this->user->find($request->get('id'));

        if (empty($UserData)) {
            return Response::json([
                'html' => "No data found",
                'status' => 'error'
            ]);
        }

        return Response::json([
            'html' => view('admin.user.form-edit')->with([
                'userData' => $UserData])->render(),
            'status' => 'success'
        ]);
    }

    public function editSubmit(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('dashboard', 'Direct access is denied.');
        }

        $validator = $this->validateUser($request->all(), true);


        if ($validator->fails()) {
            return Response::json([
                'html' => $validator->messages(),
                'status' => 'validation-error'
            ]);
        }

        if ($this->user->updateUser($request, $request->get('id'))) {
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


    protected function validateUser(array $data, $isEdit = false)
    {

        if($isEdit) {
            $rules = [
                'full_name'             => 'required|max:255',
            ];
        } else {
            $rules = [
                'full_name'        => 'required|max:255',
                'email'           => 'required|email|max:255|unique:users',
                'password'        => 'required|min:6',
            ];
        }
        return Validator::make($data, $rules);
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

        return $this->user->listDataTable();

    }
}