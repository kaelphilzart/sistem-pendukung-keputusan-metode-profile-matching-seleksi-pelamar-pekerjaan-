<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\HRDController;
use App\Http\Controllers\PelamarController;

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




Route::get('/', function () {
    return view('login');
});

Route::get('login', [SessionController::class, 'login'])-> name('login');
Route::get('/register', [SessionController::class, 'register'])-> name('register');
Route::post('buat-akun', [SessionController::class, 'createUser'])-> name('buat-akun');
Route::post('login-akun', [SessionController::class, 'login_akun'])->name('login-akun');
Route::get('uji-coba/{id}', [HRDController::class, 'ujiCoba'])-> name('uji-coba');

Route::middleware(['auth'])->group(function () {
    // Rute untuk pengguna dengan tingkat 'HRD'


    Route::middleware(['pemilik'])->group(function () {

        Route::get('dashboard_pemilik', [PemilikController::class, 'dashboard'])-> name('dashboard_pemilik');
        Route::get('logout-pemilik', [SessionController::class, 'destroyPemilik'])->name('logout-pemilik');
        // Route::get('hasil-seleksi', [PemilikController::class, 'hasilSeleksi'])->name('hasil-seleksi');
        // Route::get('detail-seleksi/{id}', [PemilikController::class, 'detailSeleksi'])-> name('detail-seleksi');
        Route::get('pelamar', [PemilikController::class, 'pelamar'])->name('pelamar');
        Route::get('riwayat-seleksi', [PemilikController::class, 'hasilSeleksi'])-> name('riwayat-seleksi');
        Route::get('riwayat/{id}', [PemilikController::class, 'seleksi'])-> name('riwayat');   

  
    });

    Route::middleware(['HRD'])->group(function () {
    
        Route::get('dashboard_HRD', [HRDController::class, 'dashboard'])-> name('dashboard_HRD');
        Route::get('logout-HRD', [SessionController::class, 'destroyHRD'])->name('logout-HRD');

//pelamar
        Route::get('data-pelamar', [HRDController::class, 'dataPelamar'])->name('data-pelamar');
        Route::get('detail-pelamar/{id}', [HRDController::class, 'detailPelamar'])-> name('detail-pelamar');
        Route::post('/save-validation', [HRDController::class, 'saveValidation'])->name('save-validation');
        Route::post('/mark-as-done', [HRDController::class, 'markAsDone'])->name('mark-as-done');



    //Lowongan
        Route::get('data-lowongan', [HRDController::class, 'dataLowongan'])-> name('data-lowongan');
        Route::post('tambah-lowongan', [HRDController::class, 'tambahLowongan'])-> name('tambah-lowongan');
        Route::post('/lowongan/delete/{id}', [HRDController::class, 'deleteLowongan']) -> name('delete-lowongan');
        Route::post('/lowongan/update/{id}', [HRDController::class, 'updateLowongan']) -> name('update-lowongan');

    // kriteria
        Route::get('data-kriteria', [HRDController::class, 'dataKriteria'])-> name('data-kriteria');
        Route::post('tambah-kriteria', [HRDController::class, 'tambahKriteria'])-> name('tambah-kriteria');
        Route::post('/kriteria/delete/{id}', [HRDController::class, 'deleteKriteria']) -> name('delete-kriteria');
        Route::post('/kriteria/update/{id}', [HRDController::class, 'updateKriteria']) -> name('update-kriteria');

    // sub kriteria
        // Route::get('data-subKriteria', [HRDController::class, 'dataSubKriteria'])-> name('data-subKriteria');
        // Route::post('tambah-subKriteria', [HRDController::class, 'tambahSubKriteria'])-> name('tambah-subKriteria');
        // Route::post('/subKriteria/delete/{id}', [HRDController::class, 'deleteSubKriteria']) -> name('delete-subKriteria');
        // Route::post('/subKriteria/update/{id}', [HRDController::class, 'updateSubKriteria']) -> name('update-subKriteria');

     // Nilai Isi
        // Route::get('data-nilaiIsi', [HRDController::class, 'dataNilaiIsi'])-> name('data-nilaiIsi');
        // Route::post('tambah-nilaiIsi', [HRDController::class, 'tambahNilaiIsi'])-> name('tambah-nilaiIsi');
        // Route::post('/nilaiIsi/delete/{id}', [HRDController::class, 'deleteNilaiIsi']) -> name('delete-nilaiIsi');
        // Route::post('/nilaiIsi/update/{id}', [HRDController::class, 'updateNilaiIsi']) -> name('update-nilaiIsi');
    
     // Nilai IsiBobot Gap
        Route::get('data-bobotGap', [HRDController::class, 'dataBobotGap'])-> name('data-bobotGap');
        Route::post('tambah-bobotGap', [HRDController::class, 'tambahBobotGap'])-> name('tambah-bobotGap');
        Route::post('/bobotGap/delete/{id}', [HRDController::class, 'deleteBobotGap']) -> name('delete-bobotGap');
        Route::post('/bobotGap/update/{id}', [HRDController::class, 'updateBobotGap']) -> name('update-bobotGap');
    
    //perhitungan
        Route::get('lowongan-lamar', [HRDController::class, 'lowonganLamar'])-> name('lowongan-lamar');
        Route::get('perhitungan/{id}', [HRDController::class, 'lanjutan'])-> name('perhitungan');
        // Di dalam file routes/web.php atau file yang sesuai
        // Route::get('hasil/{id}', [HRDController::class, 'hasil'])-> name('hasil');
        Route::get('hasil-spk/{id}', [HRDController::class, 'startSpk'])-> name('start-spk');
       

    //Syarat
        Route::get('syarat/{id}', [HRDController::class, 'dataSyarat'])-> name('syarat');
        Route::post('tambah-syarat', [HRDController::class, 'tambahSyarat'])-> name('tambah-syarat');
        Route::post('/update-syarat/{id}', [HRDController::class, 'updateSyarat'])->name('update-syarat');
        Route::post('/delete-syarat/{id}', [HRDController::class, 'deleteSyarat'])->name('delete-syarat');
    
    //kualifikasi
        Route::get('dataKualifikasi/{id}', [HRDController::class, 'dataKualifikasi'])-> name('dataKualifikasi');
        Route::post('tambah-kualifikasi', [HRDController::class, 'tambahKualifikasi'])-> name('tambah-kualifikasi');
        Route::post('/update-kualifikasi/{id}', [HRDController::class, 'updateKualifikasi'])->name('update-kualifikasi');
        Route::post('/delete-kualifikasi/{id}', [HRDController::class, 'deletekualifikasi'])->name('delete-kualifikasi');

//kualifikasi umum
        Route::get('data-kualifikasiUmum', [HRDController::class, 'dataKualifikasiUmum'])-> name('data-kualifikasiUmum');
        Route::post('tambah-kualifikasiUmum', [HRDController::class, 'tambahKualifikasiUmum'])-> name('tambah-kualifikasiUmum');
        Route::post('/update-kualifikasiUmum/{id}', [HRDController::class, 'updateKualifikasiUmum'])->name('update-kualifikasiUmum');
        Route::post('/delete-kualifikasiUmum/{id}', [HRDController::class, 'deletekualifikasiUmum'])->name('delete-kualifikasiUmum');
        Route::get('jawaban-kualifikasiUmum', [HRDController::class, 'jawabanKualifikasiUmum'])-> name('jawaban-kualifikasiUmum');
        Route::get('jawab-umum/{id}', [HRDController::class, 'dataJawabUmum'])-> name('jawab-umum');

// jawab
        Route::get('nilai-jawaban', [HRDController::class, 'nilaiJawaban'])-> name('nilai-jawaban');
        Route::get('jawab/{id}', [HRDController::class, 'dataJawab'])-> name('jawab');
        Route::post('tambah-jawab', [HRDController::class, 'tambahJawab'])-> name('tambah-jawab');
        Route::post('/update-jawab/{id}', [HRDController::class, 'updateJawab'])->name('update-jawab');
        Route::post('/delete-jawab/{id}', [HRDController::class, 'deleteJawab'])->name('delete-jawab');

// wawancara
        Route::post('lolos-pengumuman', [HRDController::class, 'lolosPengumuman'])-> name('lolos-pengumuman');
        Route::post('gagal-pengumuman', [HRDController::class, 'gagalPengumuman'])-> name('gagal-pengumuman');
        Route::post('kirim-pesan', [HRDController::class, 'kirimPesan'])-> name('kirim-pesan');
        Route::post('kirim-pesan-pelamar', [HRDController::class, 'kirimPesanPelamar'])-> name('kirim-pesan-pelamar');     

//hasil seleksi
        Route::get('hasil-seleksi', [HRDController::class, 'hasilSeleksi'])-> name('hasil-seleksi');
        Route::get('seleksi/{id}', [HRDController::class, 'seleksi'])-> name('seleksi');   
        
    });

    Route::middleware(['pelamar'])->group(function () {
    
        Route::get('dashboard_pelamar', [PelamarController::class, 'dashboard'])-> name('dashboard_pelamar');
        Route::get('profile-pelamar', [PelamarController::class, 'profile'])-> name('profile-pelamar');
        Route::get('logout-pelamar', [SessionController::class, 'destroyPelamar'])->name('logout-pelamar');
        Route::post('isi-profile', [PelamarController::class, 'isiProfile'])-> name('isi-profile');
        Route::get('lowongan', [PelamarController::class, 'lowongan'])-> name('lowongan');
        Route::post('lamar-lowongan', [PelamarController::class, 'isiLowongan'])-> name('lamar-lowongan');
      
        Route::get('error', [PelamarController::class, 'kosong'])-> name('error');

        Route::get('kualifikasi/{id}', [PelamarController::class, 'kualifikasi'])-> name('kualifikasi');
        Route::post('lamar-pekerjaan', [PelamarController::class, 'lamarPekerjaan'])-> name('lamar-pekerjaan');

        Route::post('lamar-loker', [PelamarController::class, 'lamarLoker'])-> name('lamar-loker');

        Route::get('pengumuman', [PelamarController::class, 'pengumuman'])-> name('pengumuman');
    });
    
});