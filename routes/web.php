<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('test', function () {
    $username = config('database.connections.mysql.username');
    $password = config('database.connections.mysql.password');
    $host = config('database.connections.mysql.host');
    $database = config('database.connections.mysql.database');
    $directory = storage_path() . "/backup/";
    $to = Illuminate\Support\Facades\Config::get('mail.from.address');
    // Delete old file
    array_map('unlink', array_filter((array) glob($directory . "*.sql")));
    // Expert
    $filename = $database . "-" . date('YmdHis') . ".sql";
    $command = "mysqldump --user=" . $username . " --password=" . $password . " --host=" . $host . " " . $database . " > " . $directory . $filename;
    exec($command);
    // Download
    $isOk = is_file($directory . $filename);
    if ($isOk) {
        $attachment['file'] = $directory . $filename;
        $attachment['filename'] = $filename;
        Illuminate\Support\Facades\Mail::to($to)->send(new App\Mail\BackupMail($attachment));
    }
});

Route::group(['namespace' => 'General'], function () {
    // Redirect to
    Route::get('/home', 'HomeController@index')->name('home');
    // Welcome
    Route::get('/', 'WelcomeController@index')->name('welcome');
    // Map
    Route::get('/map', 'MapController@index')->name('map');
    Route::post('/get-member', 'MapController@getMemberAjax')->name('get-member');
    // Upper Map
    Route::get('/up-map', 'UpperMapController@index')->name('uppermap');
    // Introduction
    Route::get('/introduction', 'IntroductionController@introduction')->name('introduction');
    // Teaching
    Route::get('/teaching', 'IntroductionController@teaching')->name('teaching');
    // Filter
    Route::get('/filter', 'FilterController@filter')->name('filter');
    // Propose
    Route::get('/propose/{memberId}', 'ProposeController@index')->name('propose');
    Route::post('/send', 'ProposeController@send')->name('propose.send');
    // Statistic
    Route::get('/statistic', 'StatisticController@index')->name('statistic');
    //Guide
    Route::get('/guide', 'GuideController@index')->name('guide');
    //Extra
    Route::group(['prefix' => 'phai-truong'], function () {
        Route::get('/', function () {
            return redirect()->route('map', ['base' => '3']);
        });
        Route::get('/chi-8', function () {
            return redirect()->route('map', ['base' => '7']);
        });
    });
});

/**
 * Register the typical authentication routes for an application.
 * Replacing: Auth::routes();
 */
Route::group(['namespace' => 'Auth'], function () {
    // Authentication Routes...
    Route::get('login', 'AuthenticatedSessionController@create')->name('login');
    Route::post('login', 'AuthenticatedSessionController@store');
    Route::post('logout', 'AuthenticatedSessionController@destroy')->name('logout')->middleware('auth');

    // Password Reset Routes...
    Route::get('password/reset', 'PasswordResetLinkController@create')->name('password.request');
    Route::post('password/email', 'PasswordResetLinkController@store')->name('password.email');
    Route::get('password/reset/{token}', 'NewPasswordController@create')->name('password.reset');
    Route::post('password/reset', 'NewPasswordController@store');
});
// Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
//     ->name('password.request');

// Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
//     ->name('password.email');

// Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
//     ->name('password.reset');

// Route::post('reset-password', [NewPasswordController::class, 'store'])
//     ->name('password.store');

/**
 * Requires authentication.
 */
Route::group(['middleware' => 'auth'], function () {

    /**
     * Dashboard. Common access.
     * // Matches The "/dashboard/*" URLs
     */
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard', 'as' => 'dashboard::'], function () {
        /**
         * Dashboard Index
         * // Route named "dashboard::index"
         */
        Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);
    });

    /**
     * // Matches The "/admin/*" URLs
     */
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin::'], function () {
        /**
         * Admin Access
         */
        Route::group(['middleware' => 'admin'], function () {
            /**
             * Admin Index
             * // Route named "admin::index"
             */
            Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);

            /**
             * Manage users.
             * // Routes name "admin::users.*"
             */
            Route::resource('users', 'UsersController');
            Route::get('users/password/change', ['as' => 'users.change-password', 'uses' => 'UsersController@showChangePasswordForm']);
            Route::post('users/password/change', ['as' => 'users.change-password.process', 'uses' => 'UsersController@changePassword']);

            /**
             * Manage members.
             * // Routes name "admin::members.*"
             */
            Route::resource('members', 'MembersController');

            /**
             * Constant
             * // Route named "admin::constants.*"
             */
            Route::resource('constants', 'ConstantsController');

            /**
             * Classify
             * // Route named "admin::classifies.*"
             */
            Route::resource('classifies', 'ClassifiesController');
            Route::post('/branch', ['as' => 'classifies.branch', 'uses' => 'ClassifiesController@addBranch']);

            /**
             * Proposes
             * // Route named "admin::proposes"
             */
            Route::get('proposes', ['as' => 'proposes', 'uses' => 'ProposesController@index']);
            Route::post('proposes/{id}/process', ['as' => 'proposes.process', 'uses' => 'ProposesController@markAsProcess']);
            Route::post('proposes/{id}/delete', ['as' => 'proposes.delete', 'uses' => 'ProposesController@delete']);

            /**
             * Log
             * // Route named "admin::logs"
             */
            Route::get('logs', ['as' => 'logs', 'uses' => 'LogsController@index']);
            Route::post('logs/delete', ['as' => 'logs.delete', 'uses' => 'LogsController@delete']);

            /**
             * Command
             * // Route named "admin::command"
             */
            Route::get('command', ['as' => 'command', 'uses' => 'CommandController@index']);
            Route::post('command', ['as' => 'command.do', 'uses' => 'CommandController@execute']);
        });
    });
});
