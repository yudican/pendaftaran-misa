<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrintMultipleQrCode;
use App\Http\Livewire\Admin\CatatanKehadiran;
use App\Http\Livewire\Admin\DataAbsen;
use App\Http\Livewire\Admin\DataPendaftaran;
use App\Http\Livewire\Admin\DataUmat;
use App\Http\Livewire\Admin\Jadwal;
use App\Http\Livewire\Client\Pendaftaran;
use App\Http\Livewire\Admin\StatusKesehatan;
use App\Http\Livewire\Client\CekPendaftaran;
use App\Http\Livewire\Client\HomePage;
use App\Http\Livewire\Client\RiwayatPendaftaran;
use App\Http\Livewire\CrudGenerator;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\UserManagement\Permission;
use App\Http\Livewire\UserManagement\PermissionRole;
use App\Http\Livewire\UserManagement\Role;
use App\Http\Livewire\UserManagement\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});


Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::group(['middleware' => ['auth:sanctum', 'verified', 'user.authorization']], function () {
    // Crud Generator Route
    Route::get('/crud-generator', CrudGenerator::class)->name('crud.generator');

    // user management
    Route::get('/permission', Permission::class)->name('permission');
    Route::get('/permission-role/{role_id}', PermissionRole::class)->name('permission.role');
    Route::get('/role', Role::class)->name('role');
    Route::get('/user', User::class)->name('user');

    // App Route
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Master data
    Route::get('/jadwal-misa', Jadwal::class)->name('jadwal');
    Route::get('/data-umat', DataUmat::class)->name('data.umat');
    Route::get('/status-kesehatan', StatusKesehatan::class)->name('status.kesehatan');
    Route::get('/data-absen', DataAbsen::class)->name('data.absen');
    Route::get('/catatan-kehadiran', CatatanKehadiran::class)->name('catatan.kehadiran');
    Route::get('/data-pendaftaran', DataPendaftaran::class)->name('data.pendaftaran');

    // client
    Route::get('/home', HomePage::class)->name('client.home');
    Route::get('/pendaftaran', Pendaftaran::class)->name('pendaftaran');
    Route::get('/cek-pendaftaran', CekPendaftaran::class)->name('cek.pendaftaran');
    Route::get('/riwayat-pendaftaran', RiwayatPendaftaran::class)->name('riwayat.pendaftaran');
    Route::get('/data-barcode/{jadwal_id}', [PrintMultipleQrCode::class, 'cetak_barcode'])->name('cetak_barcode');
});
