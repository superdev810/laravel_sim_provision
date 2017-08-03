<?php
namespace App\Http\Controllers\User;


use App\Http\Controllers\BaseController;
use App\Lib\File\ImageUtility;
use App\Lib\Uploader\FileUpload;
use App\Models\UserFile;
use App\Models\AddressInfo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use Validator;
use League\Csv\Reader;

class ContactController extends BaseController
{

    protected $userFile;

    public function __construct(UserFile $userFile)
    {
        $this->userFile = $userFile;
    }

    public function index()
    {
        return view('user.contact.index');
    }

    public function listPage()
    {
        return view('user.contact.list-page');
    }

    public function getBulkFrom(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }
        return Response::json([
            'html' => view('user.contact.form')->render(),
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
        $result = $this->fileUpload($utility->getFileDirectories(Auth::id(), true));
        $path = $utility->getFileDirectories(Auth::id() . '/' . $result['uuid'] . '/' . $result['uploadName'], true);

        if (empty($result['error'])) {
            try {
                $this->userFile->insert([
                    'uploadName' => $result['uploadName'],
                    'uuid' => $result['uuid'],
                    'agent' => "",
                    'group' => "",
                    'password' => "",
                    'file_type' => UserFile::ADDRESS,
                    'total_contact' => (int)$utility->lineCount($path),
                ]);
            } catch (QueryException $e) {
                $utility->deleteUserUploadFile($path);
                return Response::json(['error' => $e->errorInfo]);
            }

            return Response::json($result);
        } else {
            return Response::json($result);
        }
    }


    public function fileUpload($paths, $fileName = null)
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


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function listData(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('AdminDashboard', 'Direct access is denied.');
        }
        $contact = new AddressInfo();

        return $contact->listDataTable();

    }


    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listFileData(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('AdminDashboard', 'Direct access is denied.');
        }
        return (new UserFile())->listDataTable(UserFile::ADDRESS);

    }
}