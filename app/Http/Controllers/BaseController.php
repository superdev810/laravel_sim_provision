<?php

namespace App\Http\Controllers;

use Redirect;
use Session;

class BaseController extends Controller
{

    public function redirectSuccess($route, $message)
    {
        Session::flash('flash-message-success', $message);
        return Redirect::route($route);
    }

    /**
     * @param $route
     * @param $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectFailure($route, $message)
    {
        Session::flash('flash-message-error', $message);
        return Redirect::route($route);
    }

    protected function redirectToPreviousUrlForFailure($message)
    {
        Session::flash('flash-message-error', $message);
        return Redirect::back();
    }
}
