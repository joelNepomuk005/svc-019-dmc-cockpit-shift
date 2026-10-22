<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * S-Cockpit & Authentication
 */
Route::redirect('/', '/login');
Route::any('/auth', [\App\Http\Controllers\Auth\LoginController::class, 'scockpit_auth'])->name('auth');

Route::any('/auth', [\App\Http\Controllers\Auth\LoginController::class, 'scockpit_auth'])->name('auth');
Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/check/blz', [\App\Http\Controllers\Auth\RegisterController::class, 'check_blz'])->name('check_blz');
Route::get('/verify/blz', [\App\Http\Controllers\Auth\RegisterController::class, 'verify_blz'])->name('verify_blz');
Route::post('/register/user', [\App\Http\Controllers\Auth\RegisterController::class, 'register_user'])->name('register_user');

Route::get('/verification/failed', [\App\Http\Controllers\Auth\RegisterController::class, 'verification_failed'])->name('verification_failed');
Route::get('/verification', [\App\Http\Controllers\Auth\RegisterController::class, 'verification'])->name('verification');

Route::get('/reset/password/success', [\App\Http\Controllers\Auth\RegisterController::class, 'reset_password_success'])->name('reset_password_success');
Route::get('/contact/modal', [\App\Http\Controllers\FrontendController::class, 'showModal'])->name('showModal');
Auth::routes(['verify' => true]);

Route::view('/datenschutz', 'shared.privacy')->name('shared.privacy');

/**
 * Backend
 */
if (env('APP_ENV') == 'local' && env('SCOCKPIT_SKIP_AUTH') == true) {
    \Auth::loginUsingId(1);
}

Route::middleware('auth')->group(function () {

    Route::prefix('backend')->name('backend.')->group(function () {

        Route::prefix('files')->name('files.')->group(function () {
            Route::get('/{file}', [\App\Http\Controllers\DownloadController::class, 'downloadFile'])->name('downloadFile');
            Route::delete('/{file}', [\App\Http\Controllers\DownloadController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('modal')->name('modal.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Backend\ModalController::class, 'loadModal'])->name('loadModal');
        });

        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('index');
            Route::get('/contacts', [\App\Http\Controllers\Backend\DashboardController::class, 'getContacts'])->name('getContacts');
            Route::get('/measures', [\App\Http\Controllers\Backend\DashboardController::class, 'getMeasures'])->name('getMeasures');
            Route::get('/dmc-contact', [\App\Http\Controllers\Backend\DashboardController::class, 'show'])->name('show');
        });

        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Backend\CustomerController::class, 'index'])->name('index');
            Route::get('/showModal', [\App\Http\Controllers\Backend\CustomerController::class, 'showModal'])->name('showModal');
            Route::get('/showBalanceModal', [\App\Http\Controllers\Backend\CustomerController::class, 'showBalanceModal'])->name('showBalanceModal');
            Route::post('/upload', [\App\Http\Controllers\Backend\CustomerController::class, 'upload'])->name('upload');

            Route::prefix('{customer}')->name('{customer}.')->group(function () {
                Route::get('/updateContactPerson', [\App\Http\Controllers\Backend\CustomerController::class, 'updateContactPerson'])->name('updateContactPerson');
                Route::get('/updateSocialNetwork', [\App\Http\Controllers\Backend\CustomerController::class, 'updateSocialNetwork'])->name('updateSocialNetwork');
                Route::get('/', [\App\Http\Controllers\Backend\CustomerController::class, 'show'])->name('show');
                Route::get('/edit', [\App\Http\Controllers\Backend\CustomerController::class, 'edit'])->name('edit');
                Route::put('/update', [\App\Http\Controllers\Backend\CustomerController::class, 'update'])->name('update');
                Route::delete('/delete', [\App\Http\Controllers\Backend\CustomerController::class, 'delete'])->name('delete');
                Route::get('/customer/{tab}', [\App\Http\Controllers\Backend\CustomerController::class, 'show'])->name('modalTabs');

                Route::prefix('contact')->name('contact.')->group(function () {
                    Route::get('/create', [\App\Http\Controllers\Backend\CustomerContactController::class, 'create'])->name('create');
                    Route::post('/store', [\App\Http\Controllers\Backend\CustomerContactController::class, 'store'])->name('store');
                    Route::prefix('{customerContact}')->name('{customerContact}.')->group(function () {
                        Route::post('/update', [\App\Http\Controllers\Backend\CustomerContactController::class, 'update'])->name('update');
                        Route::get('/', [\App\Http\Controllers\Backend\CustomerContactController::class, 'mainLocation'])->name('mainLocation');
                        Route::get('/edit', [\App\Http\Controllers\Backend\CustomerContactController::class, 'edit'])->name('edit');
                        Route::delete('/', [\App\Http\Controllers\Backend\CustomerContactController::class, 'destroy'])->name('destroy');
                    });
                });

                Route::prefix('users')->name('users.')->group(function () {
                    Route::get('/create', [\App\Http\Controllers\Backend\UserController::class, 'createCustomer'])->name('create');
                    Route::post('/store', [\App\Http\Controllers\Backend\UserController::class, 'storeCustomer'])->name('store');
                    Route::prefix('{user}')->name('{user}.')->group(function () {
                        Route::get('/edit', [\App\Http\Controllers\Backend\UserController::class, 'editCustomer'])->name('editCustomer');
                        Route::put('/update', [\App\Http\Controllers\Backend\UserController::class, 'updateCustomer'])->name('update');
                    });
                });

                Route::prefix('budgets')->name('budgets.')->group(function () {
                    Route::prefix('{type}')->name('{type}.')->group(function () {
                        Route::get('/create', [\App\Http\Controllers\Backend\BudgetController::class, 'createCustomer'])->name('create');
                        Route::post('/store', [\App\Http\Controllers\Backend\BudgetController::class, 'storeCustomer'])->name('store');
                    });

                    Route::prefix('{budget}')->name('{budget}.')->group(function () {
                        Route::get('/', [\App\Http\Controllers\Backend\BudgetController::class, 'show'])->name('show');
                        Route::prefix('{type}')->name('{type}.')->group(function () {
                            Route::get('/edit', [\App\Http\Controllers\Backend\BudgetController::class, 'editCustomer'])->name('editCustomer');
                            Route::put('/update', [\App\Http\Controllers\Backend\BudgetController::class, 'updateCustomer'])->name('update');
                        });
                        Route::delete('/', [\App\Http\Controllers\Backend\BudgetController::class, 'destroy'])->name('destroy');
                    });
                });

                Route::prefix('measures')->name('measures.')->group(function () {
                    Route::get('/create', [\App\Http\Controllers\Backend\MeasuresController::class, 'create'])->name('create');
                    Route::get('/', [\App\Http\Controllers\Backend\MeasuresController::class, 'tabFilterIndex'])->name('tabFilterIndex');
                    Route::prefix('{measure}')->name('{measure}.')->group(function () {
                        Route::get('/edit', [\App\Http\Controllers\Backend\MeasuresController::class, 'editCustomer'])->name('editCustomer');
                        Route::put('/', [\App\Http\Controllers\Backend\MeasuresController::class, 'updateOnCustomer'])->name('updateOnCustomer');
                        Route::delete('/', [\App\Http\Controllers\Backend\MeasuresController::class, 'destroy'])->name('destroy');
                        Route::get('/showModal', [\App\Http\Controllers\Backend\MeasuresController::class, 'showModalCustomer'])->name('showModalCustomer');
                    });
                });
            });
        });

        Route::prefix('measures')->name('measures.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Backend\MeasuresController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Backend\MeasuresController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Backend\MeasuresController::class, 'store'])->name('store');
            Route::get('/showModal', [\App\Http\Controllers\Backend\MeasuresController::class, 'showExportModal'])->name('showExportModal');
            Route::prefix('{measure}')->name('{measure}.')->group(function () {
                Route::get('/edit/{tab?}', [\App\Http\Controllers\Backend\MeasuresController::class, 'edit'])->name('edit');
                Route::get('/', [\App\Http\Controllers\Backend\MeasuresController::class, 'show'])->name('show');
                Route::put('/', [\App\Http\Controllers\Backend\MeasuresController::class, 'update'])->name('update');
                Route::get('/showModal', [\App\Http\Controllers\Backend\MeasuresController::class, 'showModal'])->name('showModal');
                Route::get('/show/measure', [\App\Http\Controllers\Backend\MeasuresController::class, 'showMeasure'])->name('showMeasure');
                Route::get('/filter', [\App\Http\Controllers\Backend\MeasuresController::class, 'tabFilterIndex'])->name('filter');
            });
        });

        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Backend\CampaignsController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Backend\CampaignsController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Backend\CampaignsController::class, 'store'])->name('store');
            Route::post('/sendCampaignDataToLandingpage', [\App\Http\Controllers\Backend\CampaignsController::class, 'sendCampaignDataToLandingpage'])->name('sendCampaignDataToLandingpage');
            Route::prefix('{campaign}')->name('{campaign}.')->group(function () {
                Route::get('/edit', [\App\Http\Controllers\Backend\CampaignsController::class, 'edit'])->name('edit');
                Route::put('/update', [\App\Http\Controllers\Backend\CampaignsController::class, 'update'])->name('update');
                Route::delete('/destroy', [\App\Http\Controllers\Backend\CampaignsController::class, 'destroy'])->name('destroy');
                Route::post('/deletePicture', [\App\Http\Controllers\Backend\CampaignsController::class, 'deleteCampaignPicture'])->name('deleteCampaignPicture');
                Route::get('/show', [\App\Http\Controllers\Backend\CampaignsController::class, 'showModalCampaign'])->name('showModalCustomer');
            });
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Backend\UserController::class, 'index'])->name('index');

            Route::get('/create', [\App\Http\Controllers\Backend\UserController::class, 'create'])->name('create');

            Route::post('/', [\App\Http\Controllers\Backend\UserController::class, 'store'])->name('store');

            Route::prefix('{user}')->name('{user}.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Backend\UserController::class, 'show'])->name('show');
                Route::get('/edit', [\App\Http\Controllers\Backend\UserController::class, 'edit'])->name('edit');
                Route::post('/', [\App\Http\Controllers\Backend\UserController::class, 'update'])->name('update');
                Route::delete('/destroy', [\App\Http\Controllers\Backend\UserController::class, 'destroy'])->name('destroy');
                Route::get('/release', [\App\Http\Controllers\Backend\UserController::class, 'release'])->name('release');
                Route::get('/impersonate}', [\App\Http\Controllers\Backend\UserController::class, 'impersonate'])->name('impersonate');
                Route::get('/leave-impersonate', [\App\Http\Controllers\Backend\UserController::class, 'leaveImpersonate'])->name('leave-impersonate');
            });
        });

        Route::prefix('contacts')->name('contacts.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Backend\CustomerContactController::class, 'index'])->name('index');
            Route::prefix('{customerContact}')->name('{customerContact}.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Backend\CustomerContactController::class, 'show'])->name('show');
                Route::get('/edit', [\App\Http\Controllers\Backend\CustomerContactController::class, 'edit'])->name('edit');
                Route::post('/', [\App\Http\Controllers\Backend\CustomerContactController::class, 'update'])->name('update');
                Route::delete('/', [\App\Http\Controllers\Backend\CustomerContactController::class, 'destroy'])->name('destroy');
            });
        });

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('customerExportExcel', [\App\Http\Controllers\Backend\ReportsController::class, 'excel_export_customers'])->name('excel_export_customers');
            Route::get('reports/customerExportPDF', [\App\Http\Controllers\Backend\ReportsController::class, 'pdf_export_customers'])->name('pdf_export_customers');
            Route::get('reports/measure/pdf', [\App\Http\Controllers\Backend\ReportsController::class, 'pdf_measure_export'])->name('pdf_measure_export');

            Route::prefix('{measure}')->name('{measure}.')->group(function () {
                Route::get('reports/customerMeasureExportPDF/', [\App\Http\Controllers\Backend\ReportsController::class, 'excel_export_measure_customers'])->name('excel_export_measure_customers');
            });

            Route::get('reports/contactExportExcel', [\App\Http\Controllers\Backend\ReportsController::class, 'excel_export_contacts'])->name('excel_export_contacts');
            Route::get('reports/userExportExcel', [\App\Http\Controllers\Backend\ReportsController::class, 'user_export_excel'])->name('user_export_excel');
            Route::get('AcquisitionExportExcel', [\App\Http\Controllers\Backend\ReportsController::class, 'excel_export_acquisitions'])->name('excel_export_acquisitions');
            Route::get('reports/AcquisitionExportPDF', [\App\Http\Controllers\Backend\ReportsController::class, 'pdf_export_acquisitions'])->name('pdf_export_acquisitions');
            Route::get('reports/ProjcectExportPDF', [\App\Http\Controllers\Backend\ReportsController::class, 'pdf_export_projects'])->name('pdf_export_projects');
            Route::get('projectExportExcel', [\App\Http\Controllers\Backend\ReportsController::class, 'excel_export_projects'])->name('excel_export_projects');
            Route::get('reports/ProjectExportPDF', [\App\Http\Controllers\Backend\ReportsController::class, 'pdf_export_projects'])->name('pdf_export_projects');
            Route::prefix('imports')->name('imports.')->group(function () {
                Route::post('/importProjects', [\App\Http\Controllers\Backend\ReportsController::class, 'importProjects'])->name('importProjects');
                Route::post('/balance_customer', [\App\Http\Controllers\Backend\ReportsController::class, 'balance_customer'])->name('balance_customer');

            });
        });
    });

});
