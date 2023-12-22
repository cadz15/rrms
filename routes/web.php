<?php

use App\Http\Controllers\Web\EducationController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EducationSetupController;
use App\Http\Controllers\Web\RequestController;
use App\Http\Controllers\Web\RequestItemController;
use App\Http\Controllers\Web\RequestorController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\RequestorRegistrationController;
use App\Services\CryptService;
use App\Services\PayMongoService;
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

Route::controller(HealthCheckController::class)->prefix('health-check')->group(function () {
    Route::get('/sms', 'checkSmsNotification');
});

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', 'index')->name('login');
        Route::post('login', 'login')->name('auth.login');
    });


    Route::group(['prefix' => 'requestor'], function () {

        Route::get('/register', [RequestorRegistrationController::class, 'index']);
        Route::post('/register', [RequestorRegistrationController::class, 'store'])->name('requestor.register');
    });
});

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route::prefix(('account'))->group(function() {        
    //     Route::get('account-setting', [DashboardController::class, 'showAccount'])->name('account.setting');
    //     Route::post('account-setting', [DashboardController::class, 'changePassword'])->name('account.change.password');
    // });

    Route::prefix('requestors')->controller(RequestorController::class)->group(function () {
        Route::get('/', 'index')->name('requestors.list');
        Route::get('/{student}', 'show')->name('requestors.show');
        Route::post('/approve/{id}', 'approve')->name('requestors.approve');
        Route::get('/disapprove-alert/{id}', 'showDisapprove')->name('requestors.show.disapprove');
        Route::post('/disapprove/{id}', 'disapprove')->name('requestors.disapprove');
    });

    Route::group(['prefix' => 'student'], function () {
        Route::get('/list', [StudentController::class, 'index'])->name('students.index');
        Route::get('/{id}/information', [StudentController::class, 'show'])->name('students.show');
        Route::get('/{id}/request-history', [StudentController::class, 'requestHistory'])->name('students.request.history');
        Route::get('/{id}/account-setting', [StudentController::class, 'showAccount'])->name('students.account.setting');
        Route::post('/{id}/account-setting', [StudentController::class, 'changePassword'])->name('students.account.change.password');
        Route::put('/{id}', [StudentController::class, 'update'])->name('students.update');
        // Route::get('/create', [StudentController::class, 'create'])->name('student.create');

        Route::get('/create', [StudentController::class, 'viewCreate'])->name('student.create.form');
        Route::post('/create', [StudentController::class, 'storeStudent'])->name('student.create');

        Route::get('/decline-student', function() {

            return view('student.decline-student');
        })->name('student.decline');

        Route::controller(EducationController::class)->prefix('{id}/educations')->group(function () {
            Route::get('/', 'index')->name('educations.index');
            Route::post('/', 'store')->name('educations.store');
            Route::get('/add', 'create')->name('educations.create');
            Route::get('/{educationId}', 'show')->name('educations.show');
            Route::put('/{educationId}', 'update')->name('educations.update');
            Route::delete('/{educationId}', 'delete')->name('educations.delete');
        });

        // Route::get('/{id}', [RequestorController::class, 'showStudentForm'])->name('student.information');
    });

    Route::group(['prefix' => 'setup'], function () {
        Route::group(['prefix' => 'education'], function () {
            Route::get('/', [EducationSetupController::class, 'index'])->name('education.setup.index');
            Route::get('/create-education', [EducationSetupController::class, 'createEducation'])->name('education.setup.create');
            Route::post('store-education', [EducationSetupController::class, 'storeLevel'])->name('education.setup.store');
            Route::post('update-education', [EducationSetupController::class, 'updateLevel'])->name('education.setup.update');
            Route::post('store-major', [EducationSetupController::class, 'storeMajor'])->name('education.setup.major.store');
            Route::get('delete-major/{id}', [EducationSetupController::class, 'deleteMajor'])->name('education.setup.major.destroy');

            Route::get('/{id}', [EducationSetupController::class, 'view'])->name('education.setup.view');
        });

        Route::group(['prefix' => 'request-item'], function() {
            Route::get('/', [RequestItemController::class, 'index'])->name('item.setup.index');
            Route::post('/', [RequestItemController::class, 'create'])->name('item.setup.create');
            Route::get('/update/{id}', [RequestItemController::class, 'viewEdit'])->name('item.setup.view.update');
            Route::post('/update', [RequestItemController::class, 'update'])->name('item.setup.update');

            Route::get('/confirm-delete/{id}', [RequestItemController::class, 'viewDelete'])->name('item.setup.view.delete');
            Route::post('/delete/{id}', [RequestItemController::class, 'destroy'])->name('item.setup.destroy');
        });

        Route::group(['prefix' => 'accounts'], function() {
            Route::get('/', [DashboardController::class, 'showAccounts'])->name('accounts.list');
            Route::get('account-setting/create', [DashboardController::class, 'showCreateForm'])->name('account.create.user');
            Route::post('account-setting/create', [DashboardController::class, 'createUser'])->name('account.create.information');
            Route::get('account-setting/{id}', [DashboardController::class, 'showAccount'])->name('account.setting');
            Route::post('account-setting/{id}', [DashboardController::class, 'updateInformation'])->name('account.update.information');
            Route::post('account-setting/update-password/{id}', [DashboardController::class, 'changePassword'])->name('account.change.password');
            Route::get('account-delete/{id}', [DashboardController::class, 'deleteAccount'])->name('account.delete');
        });
    });

    Route::group(['prefix' => 'requests'], function () {
        Route::get('/', [RequestController::class, 'index'])->name('requests.list-web');
        Route::get('/history/{id}', [RequestController::class, 'viewRequest']);
        Route::post('/for-pickup', [RequestController::class, 'forPickup'])->name('request.mark.forpickup');
        Route::post('/completed', [RequestController::class, 'requestComplete'])->name('request.mark.completed');
    });
    
    Route::group(['prefix' => 'payment'], function() {
        Route::get('/cancelled-payment/{e_id}', function($e_id) {
            $request = PayMongoService::markRequestAsSuccess(CryptService::decrypt($e_id));

            return redirect('/');
        })->name('payment.cancelled');
        Route::get('/success-payment/{e_id}', function($e_id) {
            $request = PayMongoService::markRequestAsSuccess(CryptService::decrypt($e_id));

            return redirect('/');
        })->name('payment.success');
    });
});



Route::get('/pages', function () {
    return view('home');
});
