<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Staff\AktaNotarisController;
use App\Http\Controllers\Staff\AktaPpatController;
use App\Http\Controllers\Staff\LegnotController;
use App\Http\Controllers\Staff\SertifikatController;

/*
|--------------------------------------------------------------------------
| REDIRECT UTAMA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN & LOGOUT)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD BERDASARKAN ROLE
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('role:admin');

Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
})->name('staff.dashboard')->middleware('role:staff');

/*
|--------------------------------------------------------------------------
| MENU ADMIN (hanya untuk role admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['role:admin'])->group(function () {

    // 🔹 Akta Notaris
    Route::view('/akta-notaris', 'admin.akta_notaris.index');
    Route::view('/akta-notaris/form', 'admin.akta_notaris.form');

    // 🔹 Akta PPAT
    Route::view('/akta-ppat', 'admin.akta_ppat.index');
    Route::view('/akta-ppat/form', 'admin.akta_ppat.form');

    // 🔹 Legnot
    Route::view('/legnot', 'admin.legnot.index');
    Route::view('/legnot/form', 'admin.legnot.form');

    // 🔹 Sertifikat
    Route::view('/sertifikat', 'admin.sertifikat.index');
    Route::view('/sertifikat/form', 'admin.sertifikat.form');

    // 🔹 Detail Dokumen
    Route::view('/detail', 'admin.detail');
});

/*
|--------------------------------------------------------------------------
| MENU STAFF (hanya untuk role staff)
|--------------------------------------------------------------------------
*/
Route::prefix('staff')->middleware(['role:staff'])->group(function () {

    /*
    |--------------------------------------------------------
    | CRUD AKTA NOTARIS (PAKAI CONTROLLER)
    |--------------------------------------------------------
    */
    Route::get('/akta-notaris', [AktaNotarisController::class, 'index'])
        ->name('staff.akta-notaris.index');

    Route::get('/akta-notaris/form', [AktaNotarisController::class, 'create'])
        ->name('staff.akta-notaris.create');

    Route::post('/akta-notaris/save', [AktaNotarisController::class, 'store'])
        ->name('staff.akta-notaris.store');

    Route::get('/akta-notaris/{uuid}/edit', [AktaNotarisController::class, 'edit'])
        ->name('staff.akta-notaris.edit');

    Route::post('/akta-notaris/{uuid}/update', [AktaNotarisController::class, 'update'])
        ->name('staff.akta-notaris.update');

    Route::delete('/akta-notaris/{uuid}/delete', [AktaNotarisController::class, 'destroy'])
        ->name('staff.akta-notaris.destroy');

    Route::get('/search', [AktaNotarisController::class, 'search'])
        ->name('staff.akta-notaris.search');

        // 🔹 ROUTE BARU UNTUK UPDATE STATUS
    Route::post('/akta-notaris/{uuid}/update-status', [AktaNotarisController::class, 'updateStatus'])
        ->name('staff.akta-notaris.update-status');

    /*
    |--------------------------------------------------------
    | CRUD AKTA PPAT (PAKAI CONTROLLER)
    |--------------------------------------------------------
    */
    // ✅ Route update status (HARUS DI ATAS route resource!)
    // ✅ BENAR (tanpa /staff di awal)
    Route::post('/akta-ppat/{uuid}/update-status', [AktaPpatController::class, 'updateStatus'])->name('staff.akta-ppat.update-status');
    
    Route::get('/akta-ppat', [AktaPpatController::class, 'index'])
        ->name('staff.akta-ppat.index');

    Route::get('/akta-ppat/form', [AktaPpatController::class, 'create'])
        ->name('staff.akta-ppat.create');

    Route::post('/akta-ppat/save', [AktaPpatController::class, 'store'])
        ->name('staff.akta-ppat.store');

    Route::get('/akta-ppat/{aktaPpat}/edit', [AktaPpatController::class, 'edit'])
        ->name('staff.akta-ppat.edit');

    Route::post('/akta-ppat/{aktaPpat}/update', [AktaPpatController::class, 'update'])
        ->name('staff.akta-ppat.update');

    Route::delete('/akta-ppat/{aktaPpat}/delete', [AktaPpatController::class, 'destroy'])
        ->name('staff.akta-ppat.destroy');

    Route::get('/akta-ppat/search', [AktaPpatController::class, 'search'])
        ->name('staff.akta-ppat.search');
    

    /*
    |--------------------------------------------------------
    | CRUD LEGNOT (PAKAI CONTROLLER)
    |--------------------------------------------------------
    */
    Route::get('/legnot', [LegnotController::class, 'index'])
        ->name('staff.legnot.index');

    Route::get('/legnot/form', [LegnotController::class, 'create'])
        ->name('staff.legnot.create');

    Route::post('/legnot/save', [LegnotController::class, 'store'])
        ->name('staff.legnot.store');

    Route::get('/legnot/{legnot}/edit', [LegnotController::class, 'edit'])
        ->name('staff.legnot.edit');

    Route::post('/legnot/{legnot}/update', [LegnotController::class, 'update'])
        ->name('staff.legnot.update');

    Route::delete('/legnot/{legnot}/delete', [LegnotController::class, 'destroy'])
        ->name('staff.legnot.destroy');

    Route::get('/legnot/search', [LegnotController::class, 'search'])
        ->name('staff.legnot.search');

    /*
    |--------------------------------------------------------
    | CRUD SERTIFIKAT (PAKAI CONTROLLER)
    |--------------------------------------------------------
    */
    
    // Route update status (HARUS DI ATAS route resource!)
    Route::post('/sertifikat/{uuid}/update-status', [SertifikatController::class, 'updateStatus'])
        ->name('staff.sertifikat.update-status');
    Route::get('/sertifikat', [SertifikatController::class, 'index'])
        ->name('staff.sertifikat.index');

    Route::get('/sertifikat/form', [SertifikatController::class, 'create'])
        ->name('staff.sertifikat.create');

    Route::post('/sertifikat/save', [SertifikatController::class, 'store'])
        ->name('staff.sertifikat.store');

    Route::get('/sertifikat/{sertifikat:uuid}/edit', [SertifikatController::class, 'edit'])
        ->name('staff.sertifikat.edit');

    Route::post('/sertifikat/{sertifikat:uuid}/update', [SertifikatController::class, 'update'])
        ->name('staff.sertifikat.update');

    Route::delete('/sertifikat/{sertifikat:uuid}/delete', [SertifikatController::class, 'destroy'])
        ->name('staff.sertifikat.destroy');

    

    /*
    |--------------------------------------------------------
    | MENU LAIN (MASIH VIEW STATIS)
    |--------------------------------------------------------
    */
    Route::view('/detail', 'staff.detail');
});