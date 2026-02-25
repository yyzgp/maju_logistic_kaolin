<?php

use App\Http\Controllers\Administrator\DispatcherController;
use App\Http\Controllers\Administrator\Auth\ChangePasswordController;
use App\Http\Controllers\Administrator\Auth\ForgotPasswordController;
use App\Http\Controllers\Administrator\Auth\LoginController;
use App\Http\Controllers\Administrator\Auth\MyAccountController;
use App\Http\Controllers\Administrator\Auth\ResetPasswordController;
use App\Http\Controllers\Administrator\CalendarController;
use App\Http\Controllers\Administrator\CompanyController;
use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\DriverController;
use App\Http\Controllers\Administrator\InvoiceController;
use App\Http\Controllers\Administrator\MapController;
use App\Http\Controllers\Administrator\MerchantController;
use App\Http\Controllers\Administrator\PageController;
use App\Http\Controllers\Administrator\ServiceController;
use App\Http\Controllers\Administrator\TaskController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\XeroController;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require base_path('routes/dispatcher.php');

Route::get('/', [SiteController::class, "index"])->name('index');
Route::get('about-us', [SiteController::class, "aboutUs"])->name('about-us');
Route::get('terms-and-conditions', [SiteController::class, "terms"])->name('terms-and-conditions');
Route::get('privacy-policy', [SiteController::class, "privacyPolicy"])->name('privacy-policy');
Route::get('cookies-policy', [SiteController::class, "cookiesPolicy"])->name('cookies-policy');
Route::get('contact-us', [SiteController::class, "contactUs"])->name('contact-us');
Route::post('save-contact-us', [SiteController::class, "saveContactUs"])->name('save-contact-us');
Route::get('command',function(Request $request){

    Artisan::call($request->cmd);
    dd($request->cmd);

})->name('cmd');
Route::group(['middleware' => ['XeroAuthenticated']], function () {
    Route::get('xero', [XeroController::class, "xero"]);
});

Route::get('nearby-places', [TestController::class, "nearByPlaces"]);
Route::post('xero/web-hook', [XeroController::class, "xeroWebhook"]);
Route::get('xero/connect', [XeroController::class, "connect"]);
Auth::routes(['register' => false,  'login' => false]);
Route::redirect('login', '/administrator/login')->name('login');
Route::redirect('home', '/administrator')->name('home');
Route::get('customer-request-form/{slug}/kaolin-towing', [IndexController::class, 'customerRequestForm'])->name('customer-request-form');
Route::put('customer-request-form/{slug}/kaolin-towing', [IndexController::class, 'storeCustomerRequestForm'])->name('customer-request-form.store');
Route::get('track-order/{slug}/kaolin-towing/order/{id}', [IndexController::class, 'trackRequest'])->name('track-order');
Route::group(['prefix' => 'administrator', 'as' => 'administrator.'], function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes | LOGIN | REGISTER
    |--------------------------------------------------------------------------
    */

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/update', [ResetPasswordController::class, 'reset'])->name('password.update');


    /*
    |--------------------------------------------------------------------------
    | Dashboard Route
    |--------------------------------------------------------------------------
    */

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Dispatchers Route
    |--------------------------------------------------------------------------
    */
    Route::resource('dispatchers', DispatcherController::class);
    Route::post('dispatchers/bulk-delete', [DispatcherController::class, 'bulkDelete'])->name('dispatchers.bulk-delete');
    Route::get('dispatchers/change-status/{id}', [DispatcherController::class, 'changeStatus'])->name('dispatchers.change-status');
    Route::post('dispatchers/reset-password', [DispatcherController::class, 'resetPassword'])->name('dispatchers.reset-password');

    /*
    |--------------------------------------------------------------------------
    | Merchants Route
    |--------------------------------------------------------------------------
    */
    Route::resource('merchants', MerchantController::class);
    Route::get('merchants/{slug}/delivery-orders', [MerchantController::class, 'deliveryOrders'])->name('merchants.delivery-orders');
    Route::post('merchants/bulk-delete', [MerchantController::class, 'bulkDelete'])->name('merchants.bulk-delete');
    Route::post('merchants/change-status', [MerchantController::class, 'changeStatus'])->name('merchants.change-status');
    Route::post('merchants/reset-password', [MerchantController::class, 'resetPassword'])->name('merchants.reset-password');
    Route::get('merchants/{slug}/download-order', [MerchantController::class, 'downloadOrder'])->name('merchants.download-order');

    /*
    |--------------------------------------------------------------------------
    | Tasks Route
    |--------------------------------------------------------------------------
    */
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/bulk-delete', [TaskController::class, 'bulkDelete'])->name('tasks.bulk-delete');
    Route::post('tasks/change-status', [TaskController::class, 'changeStatus'])->name('tasks.change-status');
    Route::post('tasks/assign-driver', [TaskController::class, 'assignDriver'])->name('tasks.assign-driver');
    Route::post('tasks/driver-assign', [TaskController::class, 'driverAssign'])->name('tasks.driver-assign');
    Route::post('tasks/get-details', [TaskController::class, 'getDetails'])->name('tasks.get-details');/*
    |--------------------------------------------------------------------------
    | Pages Route
    |--------------------------------------------------------------------------
    */
    Route::resource('pages', PageController::class);
    Route::post('pages/bulk-delete', [PageController::class, 'bulkDelete'])->name('pages.bulk-delete');

    /*
    |--------------------------------------------------------------------------
    | Drivers Route
    |--------------------------------------------------------------------------
    */
    Route::post('driver/document/add',[DriverController::class,'documentAdd'])->name('driver.document-add');
    Route::post('driver/document/status',[DriverController::class,'documentStatus'])->name('driver.document-status');
    Route::post('driver/document/delete/{id}',[DriverController::class,'documentDelete'])->name('driver.doc-remove');
    Route::get('driver/documents/{id}',[DriverController::class,'documents'])->name('driver.documents');
    Route::resource('drivers', DriverController::class);
    Route::post('drivers/bulk-delete', [DriverController::class, 'bulkDelete'])->name('drivers.bulk-delete');
    Route::get('drivers/change-status/{id}', [DriverController::class, 'changeStatus'])->name('drivers.change-status');
    Route::post('drivers/reset-password', [DriverController::class, 'resetPassword'])->name('drivers.reset-password');
    Route::post('drivers/notify', [DriverController::class, 'notifyAppON'])->name('drivers.notify-app');

    /*
    |--------------------------------------------------------------------------
    | Services Route
    |--------------------------------------------------------------------------
    */
    Route::resource('services', ServiceController::class);
    Route::post('services/bulk-delete', [ServiceController::class, 'bulkDelete'])->name('services.bulk-delete');
    Route::get('services/change-status/{id}', [ServiceController::class, 'changeStatus'])->name('services.change-status');
    Route::post('services/reset-password', [ServiceController::class, 'resetPassword'])->name('services.reset-password');
    Route::post('get-services', [ServiceController::class, 'getServices'])->name('ajax.get-services');
    Route::post('get-service-price', [ServiceController::class, 'getServicePrice'])->name('ajax.get-service-price');

    /*
    |--------------------------------------------------------------------------
    | Invoices Route
    |--------------------------------------------------------------------------
    */
    Route::resource('invoices', InvoiceController::class);
    Route::post('invoices/bulk-delete', [InvoiceController::class, 'bulkDelete'])->name('invoices.bulk-delete');
    Route::get('invoices/settings/frequency', [InvoiceController::class, 'settings'])->name('invoices.settings');
    Route::post('invoices/settings/frequency', [InvoiceController::class, 'saveSettings'])->name('invoices.settings');

     /*
    |--------------------------------------------------------------------------
    | Calendar Management
    |--------------------------------------------------------------------------
    */
    Route::get('calendar-management', [CalendarController::class, 'index'])->name('calendar-management.index');

      /*
    |--------------------------------------------------------------------------
    | Tracking Management
    |--------------------------------------------------------------------------
    */
    Route::get('tracking', [MapController::class, 'index'])->name('tracking.index');
    Route::post('tracking/drivers-nearby', [MapController::class, 'driversNearby'])->name('tracking.drivers-nearby');
    /*
    |--------------------------------------------------------------------------
    | Settings > My Account Route
    |--------------------------------------------------------------------------
    */
    Route::resource('my-account', MyAccountController::class);

    /*
    |--------------------------------------------------------------------------
    | Settings > Change Password Route
    |--------------------------------------------------------------------------
    */
    Route::get('change-password', [ChangePasswordController::class, 'changePasswordForm'])->name('password.form');

    Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');

    /*
    |--------------------------------------------------------------------------
    | Settings > Company Details Route
    |--------------------------------------------------------------------------
    */
    Route::get('company-details', [CompanyController::class, 'companyDetailsForm'])->name('company-details.form');

    Route::post('company-details', [CompanyController::class, 'companyDetails'])->name('company-details');

    Route::get('fix-the-services', function () {
        $services = Service::get();
        foreach ($services as $service) {
           $merchants = $service->merchants;
           $service->merchants = array_map('intval', (array) $merchants);
           $service->save();
        }
        return "Done";
    });
});


