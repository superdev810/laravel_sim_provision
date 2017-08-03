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
use App\Models\SimInfo;
use App\Models\UserDomain;
use App\Models\UserFile;
use App\Models\AddressInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Validator;

class SimController extends BaseController
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
        return view('user.sim.index');
    }

    public function listPage()
    {
        return view('user.sim.list-page');
    }

    public function removeSimContact(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }

        $response = SimInfo::destroy($request->get('ids'));

        if(!empty ($response)) {
            return Response::json([
                'html' => "Data remove successfully",
                'status' => 'success'
            ]);
        } else {
            return Response::json([
                'html' => "Delete error found",
                'status' => 'error'
            ]);
        }
    }

    public function removeSimContactFile(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }
       // dd($request->all());
        $userFile = UserFile::find($request->get('ids'));
        if(!empty($userFile)) {
            if($userFile->status == UserFile::SUCCESS || $userFile->status == UserFile::FAILED) {
                $response = SimInfo::where('file_id',$request->get('ids'))->delete();

                $utility = new ImageUtility();
                $path = $utility->getFileDirectories(Auth::id() . '/' . $userFile['uuid'] . '/' . $userFile['uploadName'], true);
                $utility->deleteUserUploadFile($path);
                $userFile->delete();
                if(!empty ($response)) {
                    return Response::json([
                        'html' => "Data remove successfully",
                        'status' => 'success'
                    ]);
                } else {
                    return Response::json([
                        'html' => "Delete error found",
                        'status' => 'error'
                    ]);
                }
            } else {
                return Response::json([
                    'html' => "You can only remove file which status is SUCCESS Or FAILED ",
                    'status' => 'error'
                ]);
            }
        } else {
            return Response::json([
                'html' => "Delete error found: Invalid file.",
                'status' => 'error'
            ]);
        }



    }

    public function getBulkFrom(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }
        return Response::json([
            'html' => view('user.contact.form-sim')->render(),
            'status' => 'success'
        ]);
    }


    public function upload(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }
        $utility = new ImageUtility();
        if (!$this->isFileExist($utility->getFileDirectories(Auth::id(), true), $utility)) {
            return Response::json(['error' => "File already exist"]);
        }
        $result = $this->fileUpload($utility->getFileDirectories(Auth::id(), true),null);
        $path = $utility->getFileDirectories(Auth::id() . '/' . $result['uuid'] . '/' . $result['uploadName'], true);

        if (empty($result['error'])) {
            try {
                $this->userFile->insert([
                    'uploadName' => $result['uploadName'],
                    'uuid' => $result['uuid'],
                    'agent' => $request->get('agent'),
                    'group' => $request->get('group'),
                    'password' => $request->get('password'),
                    'file_type' => UserFile::SIM,
                    'total_contact' => (int)$utility->lineCount($path),
                ]);
                return Response::json($result);
            } catch (QueryException $e) {
                $utility->deleteUserUploadFile($path);
                return Response::json(['error' => $e->errorInfo]);
            }
        } else {
            return Response::json($result);
        }
    }


    public function fileUpload($paths, $fileName)
    {
        return (new FileUpload())->doUpload([
            'path' => $paths,
            'fileName' => $fileName,
        ]);
    }

    public function isFileExist($paths, $fileUtility)
    {
        $allFiles = $fileUtility->getAllFiles($paths);
        $uploadFile = (new FileUpload())->getFileName();

        foreach ($allFiles as $eachFile) {
            if ($eachFile->getFilename() === $uploadFile) {
                return false;
            }
        }
        return true;

    }


    public function getFileDetails($file_id)
    {
        $file = $this->userFile->find($file_id);
        if(empty($file)){
            return $this->redirectFailure('Dashboard', 'Invalid file');
        }

        return view('user.sim.list-by-file',compact('file'));
    }
    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listSimContact(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('AdminDashboard', 'Direct access is denied.');
        }
        return $this->simInfo->listDataTable();

    }


    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileSimContactList(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('AdminDashboard', 'Direct access is denied.');
        }
        return $this->simInfo->listDataTableByFileId($request->get('file_id'));

    }

    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listFile(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('AdminDashboard', 'Direct access is denied.');
        }
        return (new UserFile())->listDataTable(UserFile::SIM);

    }
}