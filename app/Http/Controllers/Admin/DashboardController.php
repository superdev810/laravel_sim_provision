<?php
/**
 * HomeController File
 *
 * @author Md.Atiqul haque <md_atiqulhaque@yahoo.com>
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('home');
    }
}