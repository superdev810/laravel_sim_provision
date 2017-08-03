<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'auth'], function() {
    Route::get('/','DashboardController@index')->name('Dashboard');
    Route::get('/home-chart-sim','DashboardController@chartsim')->name('home-chart-sim');
    Route::get('/home-chart-contact','DashboardController@chartcontact')->name('home-chart-contact');
    Route::get('/download/file/{type}','DashboardController@download')->name('download-address');

});

Route::auth();



Route::group(['middleware' => ['web']], function () {
    Route::get('/admin/login','Auth\Admin\AuthController@showLoginForm');
    Route::post('/admin/login','Auth\Admin\AuthController@login');
    Route::get('/admin/logout','Auth\Admin\AuthController@logout');
    Route::get('/admin', 'Admin\DashboardController@index')->name('AdminDashboard');
});



Route::group(['prefix' => 'admin','middleware' => ['admin']], function() {
    Route::get('/user','Admin\AddUserController@index')->name('add-user');
    Route::get('/user/list','Admin\AddUserController@listData')->name('user-list');
    Route::get('/user/form','Admin\AddUserController@getFrom')->name('user-add-form');
    Route::post('/user/form/submit','Admin\AddUserController@fromSubmit')->name('user-add-submit');
    Route::post('/user/edit/form','Admin\AddUserController@getEditForm')->name('user-edit-form');
    Route::post('/user/edit/submit','Admin\AddUserController@editSubmit')->name('user-edit-submit');
});


Route::group(['prefix' => 'user','middleware' => ['auth']], function() {

    Route::get('/contact-file','User\ContactController@index')->name('contact');
    Route::get('/contact-list-page','User\ContactController@listPage')->name('contact-list-page');
    Route::get('/contact-upload/form','User\ContactController@getBulkFrom')->name('contact-form');
    Route::get('/contact-list','User\ContactController@listData')->name('contact-list');
    Route::get('/contact-file-list','User\ContactController@listFileData')->name('contact-file-list');
    Route::post('/contact-upload/upload','User\ContactController@upload')->name('upload-contact');


    Route::get('/sim-file','User\SimController@index')->name('sim-contact');

    Route::get('/sim-file-details/{file_id}','User\SimController@getFileDetails')->name('sim-file-details');
    Route::get('/sim-list-page','User\SimController@listPage')->name('sim-list-page');
    Route::get('/sim-upload/form','User\SimController@getBulkFrom')->name('sim-contact-form');
    Route::get('/sim-list','User\SimController@listSimContact')->name('all-sim-list');
    Route::get('/sim-file-detilas-list','User\SimController@fileSimContactList')->name('sim-file-details-list');
    Route::get('/sim-file-list','User\SimController@listFile')->name('sim-file-list');
    Route::post('/sim-upload/upload','User\SimController@upload')->name('sim-upload-contact');
    Route::post('/sim-contact/remove','User\SimController@removeSimContact')->name('delete-sim-contact');
    Route::post('/sim-contact-file/remove','User\SimController@removeSimContactFile')->name('delete-sim-file');

    Route::get('/report','User\ReportController@index')->name('report');


    Route::get('/report-success-list','User\ReportController@listSuccessReport')->name('report-success-list');


    Route::get('/report/failed','User\ReportController@failed')->name('report-failed');

    Route::get('/report/retry','User\ReportController@retry')->name('report-retry');

    Route::get('/report/pending','User\ReportController@pending')->name('report-pending');

    Route::get('/report-failed-list','User\ReportController@listFailedReport')->name('report-failed-list');

    Route::get('/report-retry-list','User\ReportController@listRetryReport')->name('report-retry-list');

    Route::get('/report-pending-list','User\ReportController@listPendingReport')->name('report-pending-list');


    Route::get('/registration/page','User\SimRegistrationController@index')->name('registration-page');

    Route::post('/registration/bulk','User\SimRegistrationController@bulkRegistration')->name('reprocess-sim-file');

    Route::post('/registration/submit','User\SimRegistrationController@submitApi')->name('registration-submit');
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


});




