<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Staff\AktaNotarisController;
use App\Http\Controllers\Staff\AktaPpatController;

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

    // 🔹 Edit & Update pakai UUID (bukan ID)
    Route::get('/akta-notaris/{uuid}/edit', [AktaNotarisController::class, 'edit'])
        ->name('staff.akta-notaris.edit');

    Route::post('/akta-notaris/{uuid}/update', [AktaNotarisController::class, 'update'])
        ->name('staff.akta-notaris.update');

    Route::delete('/akta-notaris/{uuid}/delete', [AktaNotarisController::class, 'destroy'])
        ->name('staff.akta-notaris.destroy');

    Route::get('/search', [AktaNotarisController::class, 'search'])
        ->name('staff.akta-notaris.search');

    /*
    |--------------------------------------------------------
    | CRUD AKTA PPAT (PAKAI CONTROLLER) - UPDATED TO USE UUID
    |--------------------------------------------------------
    */
    Route::get('/akta-ppat', [AktaPpatController::class, 'index'])
        ->name('staff.akta-ppat.index');

    Route::get('/akta-ppat/form', [AktaPpatController::class, 'create'])
        ->name('staff.akta-ppat.create');

    Route::post('/akta-ppat/save', [AktaPpatController::class, 'store'])
        ->name('staff.akta-ppat.store');

    // ✅ UBAH: {id} jadi {aktaPpat}
    Route::get('/akta-ppat/{aktaPpat}/edit', [AktaPpatController::class, 'edit'])
        ->name('staff.akta-ppat.edit');

    // ✅ UBAH: {id} jadi {aktaPpat}
    Route::post('/akta-ppat/{aktaPpat}/update', [AktaPpatController::class, 'update'])
        ->name('staff.akta-ppat.update');

    // ✅ UBAH: {id} jadi {aktaPpat}
    Route::delete('/akta-ppat/{aktaPpat}/delete', [AktaPpatController::class, 'destroy'])
        ->name('staff.akta-ppat.destroy');

    Route::get('/akta-ppat/search', [AktaPpatController::class, 'search'])
        ->name('staff.akta-ppat.search');

    /*
    |--------------------------------------------------------
    | MENU LAIN (MASIH VIEW STATIS)
    |--------------------------------------------------------
    */
    Route::view('/legnot', 'staff.legnot.index');
    Route::view('/legnot/form', 'staff.legnot.form');

    Route::view('/sertifikat', 'staff.sertifikat.index');
    Route::view('/sertifikat/form', 'staff.sertifikat.form');

    Route::view('/detail', 'staff.detail');
});