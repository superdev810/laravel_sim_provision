<?php
/**
 * HomeController File
 *
 * @author Md.Atiqul haque <md_atiqulhaque@yahoo.com>
 */

namespace App\Http\Controllers;


use App\Models\AddressInfo;
use App\Models\Report;
use App\Models\SimInfo;
use App\Models\UserFile;
use App\User;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::guard('admins')->user()) {
            return view('home');

        } else {
            $simObject = new SimInfo();
            $status = [];
            $statusObject = $simObject->getSimGroupByProcessFlag();

            foreach ($statusObject as $each) {
                $status[$each->process_flag] = $each->total;
            }



            return view('home', [
                'totalSimeFile' => (new User())->getTotalByFileType(UserFile::SIM),
                'totalAddressFile' => (new User())->getTotalByFileType(UserFile::ADDRESS),
                'totalSim' => SimInfo::count(),
                'simStatus' => $status,
                'totalAddress' => AddressInfo::count(),
                'totalSuccess' => Report::count()
            ]);
        }
    }


    public function chartsim(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }
        foreach((new SimInfo())->countByDate() as $each){
            $mapData[] = array('',$each->total);
            $mapMonth[] = $each->created_at->toFormattedDateString();
        }
        return Response::json(array($mapData, $mapMonth));
    }

    public function chartcontact(Request $request)
    {
        if (!$request->ajax()) {
            return $this->redirectFailure('Admindashboard', 'Direct access is denied.');
        }
        foreach((new AddressInfo())->countByDate() as $each){
            $mapData[] = array('',$each->total);
            $mapMonth[] = $each->created_at->toFormattedDateString();
        }
        return Response::json(array($mapData, $mapMonth));
    }


    public function download($type = 1)
    {

        $file= public_path().(($type == 1) ? "/UserData.csv"  : "/SimInformation.csv") ;

        $headers = array(
            'Content-Type: text/csv',
        );

        return Response::download($file, ($type == 1) ? "UserData.csv" : "SimInformation.csv" , $headers);
    }
}