<?php

use Illuminate\Support\Facades\Route;

//Beranda
use App\Http\Controllers\BerandaController as Beranda;

//Dashboard
use App\Http\Controllers\Dashboard\DashboardController as Dashboard;

//Event Calendar
use App\Http\Controllers\Dashboard\EventCalendarController as DashboardEventCalendar;

//Tugas
use App\Http\Controllers\Dashboard\TugasController as DashboardTugas;

//Konfigurasi Profil
use App\Http\Controllers\Dashboard\KonfigurasiProfilController as DashboardKonfigurasiProfil;

//Konfigurasi Akun
use App\Http\Controllers\Dashboard\KonfigurasiAkunController as DashboardKonfigurasiAkun;

//Apps
use App\Http\Controllers\Dashboard\SuratController as DashboardSurat;
use App\Http\Controllers\Dashboard\MomController as DashboardMom;
use App\Http\Controllers\Dashboard\EventController as DashboardEvent;

//Konfigurasi Aplikasi
use App\Http\Controllers\Dashboard\KlasifikasiSuratController as DashboardKlasifikasiSurat;
use App\Http\Controllers\Dashboard\DisposisiSuratController as DashboardDisposisiSurat;
use App\Http\Controllers\Dashboard\DerajatSuratController as DashboardDerajatSurat;
use App\Http\Controllers\Dashboard\SifatSuratController as DashboardSifatSurat;
use App\Http\Controllers\Dashboard\MenuController as DashboardMenu;
use App\Http\Controllers\Dashboard\DivisiController as DashboardDivisi;
use App\Http\Controllers\Dashboard\StatusTugasController as DashboardStatusTugas;
use App\Http\Controllers\Dashboard\LevelSistemController as DashboardLevelSistem;
use App\Http\Controllers\Dashboard\AdminController as DashboardAdmin;
use App\Http\Controllers\Dashboard\SosialMediaController as DashboardSosialMedia;
use App\Http\Controllers\Dashboard\KonfigurasiAplikasiController as DashboardKonfigurasiAplikasi;

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

Route::get('/storage-link', function() {
    Artisan::call('storage:link'); 
    return 'The links have been created.';
});
Route::get('/', [Beranda::class, 'index']);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::group(['prefix' => 'dashboard'], function (){
        //Dashboard
        Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

        //Event Calendar
        Route::group(['prefix' => 'eventcalendar'], function() {
            Route::get('/', [DashboardEventCalendar::class, 'index']);
            Route::get('/mom/card/{tanggal}', [DashboardEventCalendar::class, 'mom']);
            Route::get('/mom/detail/{id}', [DashboardEventCalendar::class, 'detail']);
        });

        //Konfigurasi Profil
        Route::group(['prefix' => 'konfigurasi_profil'], function(){
            Route::get('/', [DashboardKonfigurasiProfil::class, 'index']);
            Route::post('/prosesedit', [DashboardKonfigurasiProfil::class, 'prosesedit']);
        });

        //Konfigurasi Akun
        Route::group(['prefix' => 'konfigurasi_akun'], function() {
            Route::get('/', [DashboardKonfigurasiAkun::class, 'index']);
            Route::post('/prosesedit', [DashboardKonfigurasiAkun::class, 'prosesedit']);
        });

        //Tugas
        Route::group(['prefix' => 'tugas'], function() {
            Route::get('/{id_status_tugas}', [DashboardTugas::class, 'index']);
        });

        //Apps
            //Surat
            Route::group(['prefix' => 'surat'], function() {
                Route::get('/', [DashboardSurat::class, 'index']);
                Route::get('/cari', [DashboardSurat::class, 'cari']);
                Route::get('/tambah', [DashboardSurat::class, 'tambah']);
                Route::post('/prosestambah', [DashboardSurat::class, 'prosestambah']);
                Route::get('/detail/{id}', [DashboardSurat::class, 'detail']);
                Route::get('/edit/{id}', [DashboardSurat::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardSurat::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardSurat::class, 'hapus']);
                Route::get('/cetak/{id}', [DashboardSurat::class, 'cetak']);
                Route::group(['prefix' => 'lampiran'], function() {
                    Route::post('/upload', [DashboardSurat::class, 'uploadlampiran']);
                    Route::post('/hapus', [DashboardSurat::class, 'hapuslampiran']);
                });
                Route::get('/disposisi/{id}', [DashboardSurat::class, 'disposisi']);
                Route::post('/prosesdisposisi/{id}', [DashboardSurat::class, 'prosesdisposisi']);
            });

            //Mom
            Route::group(['prefix' => 'mom'], function() {
                Route::get('/', [DashboardMom::class, 'index']);
                Route::get('/cari', [DashboardMom::class, 'cari']);
                Route::get('/tambah', [DashboardMom::class, 'tambah']);
                Route::post('/prosestambah', [DashboardMom::class, 'prosestambah']);
                Route::get('/edit/{id}', [DashboardMom::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardMom::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardMom::class, 'hapus']);
                Route::get('/cetak/{id}', [DashboardMom::class, 'cetak']);
                Route::get('/ambilmom/{id}', [DashboardMom::class, 'ambilmom']);
                Route::get('/momuser/{id}', [DashboardMom::class, 'ambilmomuser']);
                Route::get('/momexternal/{id}', [DashboardMom::class, 'ambilmomuserexternal']);
            });

            //Event
            Route::group(['prefix' => 'event'], function() {
                Route::get('/', [DashboardEvent::class, 'index']);
                Route::get('/cari', [DashboardEvent::class, 'cari']);
                Route::get('/tambah', [DashboardEvent::class, 'tambah']);
                Route::post('/prosestambah', [DashboardEvent::class, 'prosestambah']);
                Route::get('/edit/{id}', [DashboardEvent::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardEvent::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardEvent::class, 'hapus']);
            });

        //Konfigurasi Aplikasi
            //Klasifikasi Surat
            Route::group(['prefix' => 'klasifikasi_surat'], function() {
                Route::get('/', [DashboardKlasifikasiSurat::class, 'index']);
                Route::get('/cari', [DashboardKlasifikasiSurat::class, 'cari']);
                Route::get('/tambah', [DashboardKlasifikasiSurat::class, 'tambah']);
                Route::post('/prosestambah', [DashboardKlasifikasiSurat::class, 'prosestambah']);
                Route::get('/edit/{id}', [DashboardKlasifikasiSurat::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardKlasifikasiSurat::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardKlasifikasiSurat::class, 'hapus']);
            });
            
            //Disposisi Surat
            Route::group(['prefix' => 'disposisi_surat'], function() {
                Route::get('/', [DashboardDisposisiSurat::class, 'index']);
                Route::get('/cari', [DashboardDisposisiSurat::class, 'cari']);
                Route::get('/tambah', [DashboardDisposisiSurat::class, 'tambah']);
                Route::post('/prosestambah', [DashboardDisposisiSurat::class, 'prosestambah']);
                Route::get('/edit/{id}', [DashboardDisposisiSurat::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardDisposisiSurat::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardDisposisiSurat::class, 'hapus']);
            });
            
            //Derajat Surat
            Route::group(['prefix' => 'derajat_surat'], function() {
                Route::get('/', [DashboardDerajatSurat::class, 'index']);
                Route::get('/cari', [DashboardDerajatSurat::class, 'cari']);
                Route::get('/tambah', [DashboardDerajatSurat::class, 'tambah']);
                Route::post('/prosestambah', [DashboardDerajatSurat::class, 'prosestambah']);
                Route::get('/edit/{id}', [DashboardDerajatSurat::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardDerajatSurat::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardDerajatSurat::class, 'hapus']);
            });
            
            //Sifat Surat
            Route::group(['prefix' => 'sifat_surat'], function() {
                Route::get('/', [DashboardSifatSurat::class, 'index']);
                Route::get('/cari', [DashboardSifatSurat::class, 'cari']);
                Route::get('/tambah', [DashboardSifatSurat::class, 'tambah']);
                Route::post('/prosestambah', [DashboardSifatSurat::class, 'prosestambah']);
                Route::get('/edit/{id}', [DashboardSifatSurat::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardSifatSurat::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardSifatSurat::class, 'hapus']);
            });

            //Status Tugas
            Route::group(['prefix' => 'status_tugas'], function() {
                Route::get('/', [DashboardStatusTugas::class, 'index']);
                Route::get('/cari', [DashboardStatusTugas::class, 'cari']);
                Route::get('/tambah', [DashboardStatusTugas::class, 'tambah']);
                Route::post('/prosestambah', [DashboardStatusTugas::class, 'prosestambah']);
                Route::get('/edit/{id}', [DashboardStatusTugas::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardStatusTugas::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardStatusTugas::class, 'hapus']);
            });

            //Menu
            Route::group(['prefix' => 'menu'], function () {
                Route::get('/', [DashboardMenu::class, 'index']);
                Route::get('/cari', [DashboardMenu::class, 'cari']);
                Route::get('/urutan', [DashboardMenu::class, 'urutan']);
                Route::post('/prosesurutan', [DashboardMenu::class, 'prosesurutan']);
                Route::get('/tambah', [DashboardMenu::class, 'tambah']);
                Route::post('/prosestambah', [DashboardMenu::class, 'prosestambah']);
                Route::get('/baca/{id}', [DashboardMenu::class, 'baca']);
                Route::get('/edit/{id}', [DashboardMenu::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardMenu::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardMenu::class, 'hapus']);
                Route::get('/submenu/{id}', [DashboardMenu::class, 'submenu']);
                Route::get('/cari_submenu/{id}', [DashboardMenu::class, 'cari_submenu']);
                Route::get('/tambah_submenu/{id}', [DashboardMenu::class, 'tambah_submenu']);
                Route::post('/prosestambah_submenu/{id}', [DashboardMenu::class, 'prosestambah_submenu']);
                Route::get('/urutan_submenu/{id}', [DashboardMenu::class, 'urutan_submenu']);
                Route::get('/baca_submenu/{id}', [DashboardMenu::class, 'baca_submenu']);
                Route::get('/edit_submenu/{id}', [DashboardMenu::class, 'edit_submenu']);
                Route::post('/prosesedit_submenu/{id}', [DashboardMenu::class, 'prosesedit_submenu']);
                Route::get('/hapus_submenu/{id}', [DashboardMenu::class, 'hapus_submenu']);
            });

            //Divisi
            Route::group(['prefix' => 'divisi'], function() {
                Route::get('/', [DashboardDivisi::class, 'index']);
                Route::get('/cari', [DashboardDivisi::class, 'cari']);
                Route::get('/tambah', [DashboardDivisi::class, 'tambah']);
                Route::post('/prosestambah', [DashboardDivisi::class, 'prosestambah']);
                Route::get('/edit/{id}', [DashboardDivisi::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardDivisi::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardDivisi::class, 'hapus']);
            });

            //Level Sistem
            Route::group(['prefix' => 'level_sistem'], function () {
                Route::get('/', [DashboardLevelSistem::class, 'index']);
                Route::get('/cari', [DashboardLevelSistem::class, 'cari']);
                Route::get('/tambah', [DashboardLevelSistem::class, 'tambah']);
                Route::post('/prosestambah', [DashboardLevelSistem::class, 'prosestambah']);
                Route::get('/baca/{id}', [DashboardLevelSistem::class, 'baca']);
                Route::get('/edit/{id}', [DashboardLevelSistem::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardLevelSistem::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardLevelSistem::class, 'hapus']);
            });

            //Admin
            Route::group(['prefix' => 'admin'], function () {
                Route::get('/', [DashboardAdmin::class, 'index']);
                Route::get('/cari', [DashboardAdmin::class, 'cari']);
                Route::get('/tambah', [DashboardAdmin::class, 'tambah']);
                Route::post('/prosestambah', [DashboardAdmin::class, 'prosestambah']);
                Route::get('/baca/{id}', [DashboardAdmin::class, 'baca']);
                Route::get('/edit/{id}', [DashboardAdmin::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardAdmin::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardAdmin::class, 'hapus']);
            });

            //Sosial Media
            Route::group(['prefix' => 'sosial_media'], function() {
                Route::get('/', [DashboardSosialMedia::class, 'index']);
                Route::get('/cari', [DashboardSosialMedia::class, 'cari']);
                Route::get('/tambah', [DashboardSosialMedia::class, 'tambah']);
                Route::post('/prosestambah', [DashboardSosialMedia::class, 'prosestambah']);
                Route::get('/edit/{id}', [DashboardSosialMedia::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardSosialMedia::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardSosialMedia::class, 'hapus']);
            });

            //Konfigurasi Aplikasi
            Route::group(['prefix' => 'konfigurasi_aplikasi'], function () {
                Route::get('/', [DashboardKonfigurasiAplikasi::class, 'index']);
                Route::post('/prosesedit', [DashboardKonfigurasiAplikasi::class, 'prosesedit']);
                Route::post('/proseseditlogo', [DashboardKonfigurasiAplikasi::class, 'proseseditlogo']);
                Route::post('/prosesediticon', [DashboardKonfigurasiAplikasi::class, 'prosesediticon']);
                Route::post('/proseseditlogotext', [DashboardKonfigurasiAplikasi::class, 'proseseditlogotext']);
                Route::post('/proseseditbackgroundwebsite', [DashboardKonfigurasiAplikasi::class, 'proseseditbackgroundwebsite']);
            });

        //Logout
        Route::get('/logout', [Dashboard::class, 'logout']);
    });
});