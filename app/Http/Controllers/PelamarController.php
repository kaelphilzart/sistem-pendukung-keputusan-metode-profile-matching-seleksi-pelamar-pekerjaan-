<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelamar;
use App\Models\Lowongan;
use App\Models\FileSyarat;
use App\Models\SubKriteria;
use App\Models\Kriteria;
use App\Models\SyaratLoker;
use App\Models\NilaiIsi;
use App\Models\BobotGap;
use App\Models\Hasil;
use App\Models\Pengumuman;
use App\Models\Lamar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PelamarController extends Controller
{
    //
    public function dashboard(){
        return view('pelamar.dashboard');
    }

    public function kosong(){
        return view('pelamar.error');
    }

    public function profile(){
        // Mengambil ID user yang sedang login
        $id_user = auth()->user()->id;

      
    
        // Mengambil data pelamar berdasarkan ID user dengan join ke tabel User
        $pelamar = Pelamar::join('users', 'pelamar.id_user', '=', 'users.id')
                            ->where('users.id', $id_user)
                            ->select('pelamar.*', 'users.name', 'users.email')
                            ->first();
    
        // Memeriksa apakah ID user sudah terdapat dalam tabel pelamar
        if(!$pelamar){
            // Jika ID user belum terdapat dalam tabel pelamar, arahkan ke halaman form
            $umum = SubKriteria::where('id_loker', '0')->get();
            $data1 = NilaiIsi::all();
            return view('pelamar.form-pelamar', compact('pelamar','umum','data1'));
        }
    
        // Jika ID user sudah terdapat dalam tabel pelamar, arahkan ke halaman profile
        return view('pelamar.profile-pelamar', compact('pelamar'));
    }
    

    public function isiProfile(Request $request){
       
        //validasi form
         
        $request->validate([
        'id_user' => 'required',
        'nama_lengkap' => 'required',
        'alamat' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'no_hp' => 'required',
        'foto' => 'required|image|mimes:jpeg,png|max:2048',// Contoh validasi file: PDF, DOC, DOCX, maksimal 2MB
        ]);

        $data = new Pelamar;
        $data->id_user = $request->input('id_user');
        $data->nama_lengkap = $request->input('nama_lengkap');
        $data->alamat = $request->input('alamat');
        $data->tempat_lahir = $request->input('tempat_lahir');
        $data->tanggal_lahir = $request->input('tanggal_lahir');
        $data->no_hp = $request->input('no_hp');
        if ($request->hasFile('foto')) {
            $cvFile = $request->file('foto');
            $cvFileName =  $cvFile->getClientOriginalName();
            $cvFile->storeAs('public/foto', $cvFileName); // Simpan file tugas di direktori 'storage/app/public/tasks'
            $data->foto = 'storage/foto/' . $cvFileName; // Simpan nama file tugas dalam basis data
        }
        // print_r($data);
        // exit;
        $data->save();

        $kualifikasi = [];
        foreach ($request->kualifikasi as $key => $value) {
            // Memproses file jika ada
            $isi_detail = null;
            if ($request->hasFile("kualifikasi.$key.isi_detail")) {
                $file = $request->file("kualifikasi.$key.isi_detail");
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/lamar', $filename);
                $isi_detail = 'storage/lamar/' . $filename;
            } else {
                $isi_detail = $value['isi_detail'] ?? null;
            }

            $kualifikasi[] = [
                'id_jawab' => $value['id_jawab'],
                'isi_detail' => $isi_detail,
                'status' => "belum diverifikasi"
            ];
        }

        $dataHasil = new Lamar;
        $dataHasil->id_pelamar = $data->id;
        $dataHasil->nilai = json_encode($kualifikasi);
        $dataHasil->save();

        return redirect('dashboard_pelamar')->with('success', 'Data berhasil daftar');
    }

    public function lowongan()
    {
        // Ambil data pelamar yang sedang login
        $id_pelamar = Auth::user()->pelamar->id;
    
        // Ambil data lowongan
        $dataLowongan = Lowongan::where('status','aktif')->get();
        
        // Ambil data syarat
        $dataSyarat = SyaratLoker::all();
    
        // Cek apakah pelamar sudah melamar di salah satu lowongan
        $sudahMelamar = Lamar::where('id_pelamar', $id_pelamar)
                              ->where('id_lowongan','!=', null)->exists();
        
        return view('pelamar.lowongan', [
            'dataLowongan' => $dataLowongan,
            'dataSyarat' => $dataSyarat,
            'sudahMelamar' => $sudahMelamar,
        ]);
    }
    

   
    
    // public function isiLowongan(Request $request){
       
    //     //validasi form
         
    //     $request->validate([
    //     'id_lowongan' => 'required',
    //     'file_syarat' => 'required|mimes:jpeg,png,pdf|max:2048',// Contoh validasi file: PDF, DOC, DOCX, maksimal 2MB
    //     ]);

    //     $id_pelamar = Auth::user()->pelamar->id;

    //         $existingFile = FileSyarat::where('id_pelamar', $id_pelamar)
    //                 ->where('id_lowongan', $request->id_lowongan)
    //                 ->first();

    //     if ($existingFile) {
    //         return redirect('/error')->with('error', 'Anda sudah mengupload syarat untuk lowongan ini.');
            
    //     }else{
    //         $data = new FileSyarat;
    //         $data->id_pelamar = $id_pelamar;
    //         $data->id_lowongan = $request->input('id_lowongan');
    //         if ($request->hasFile('file_syarat')) {
    //             $cvFile = $request->file('file_syarat');
    //             $cvFileName =  $cvFile->getClientOriginalName();
    //             $cvFile->storeAs('public/file_syarat', $cvFileName); // Simpan file tugas di direktori 'storage/app/public/tasks'
    //             $data->file_syarat = 'storage/file_syarat/' . $cvFileName; // Simpan nama file tugas dalam basis data
    //         }
    //         // print_r($data);
    //         // exit;
    //         $data->save();
    //         return redirect('lowongan')->with('success', 'Data berhasil daftar');
    //     }

       
    // }

    public function kualifikasi($id)
    {
        $data = SubKriteria::where('id_loker', $id)->get();
        $data1 = NilaiIsi::all();
        $data2 = Lowongan::find($id);

        $umum = SubKriteria::where('id_loker', '0')->get();
        return view('pelamar.kualifikasi', ['data' => $data, 'data1' => $data1, 'data2' => $data2, 'umum' => $umum]);
    }
    

    // public function lamarPekerjaan(Request $request)
    // {
    //     // Validasi form
    //     $validatedData = $request->validate([
    //         'id_lowongan' => 'required',
    //     ], [
    //         'id_lowongan.required' => 'ID Lowongan tidak boleh kosong.',
    //     ]);
    
    //     // Ambil id_pelamar dari user yang sedang login
    //     $id_pelamar = Auth::user()->pelamar->id;
    
    //     // Cek apakah pelamar sudah melamar untuk lowongan ini
    //     $existingFile = Lamar::where('id_pelamar', $id_pelamar)
    //         ->where('id_lowongan', $request->id_lowongan)
    //         ->first();
    
    //     if ($existingFile) {
    //         return redirect('/error')->with('error', 'Anda sudah mengupload syarat untuk lowongan ini.');
    //     }
    
    //     // Inisialisasi array data untuk perhitungan
    //     $tabel = Subkriteria::count();
    //     $data = [];
    
    //     for ($i = 0; $i < $tabel; $i++) {
    //         $alternatif = [];
    
    //         // Mendapatkan nilai inputan untuk kualifikasi
    //         $kualifikasi_input = $request->input("kualifikasi.$i.id_jawab");
    //         $alternatif["kualifikasi"] = $kualifikasi_input;
    
    //         // Mengambil id_sub dari nilai_isi
    //         $id_sub = NilaiIsi::where('id', $kualifikasi_input)->value('id_sub');
    //         $id_kriteria = SubKriteria::where('id', $id_sub)->value('id_kriteria');
    //         $nilai_standar = SubKriteria::join('nilai_isi', 'sub_kriteria.id', '=', 'nilai_isi.id_sub')
    //             ->where('nilai_isi.id', $kualifikasi_input)
    //             ->value('sub_kriteria.nilai_standar');
    //         $nilai_isi = NilaiIsi::where('id', $kualifikasi_input)->value('nilai_isi');
    //         $selisih = $nilai_isi - $nilai_standar;
    //         $nilai_gap = BobotGap::where('selisih', $selisih)->value('nilai_gap');
    //         $pengelompokan = SubKriteria::where('id', $id_sub)->value('pengelompokan');
    //         $nama_kriteria = Kriteria::where('id', $id_kriteria)->value('nama_kriteria');
    
    //         // Menyimpan nilai ke dalam array alternatif
    //         $alternatif["id_kriteria"] = $id_kriteria;
    //         $alternatif["nilai_standar"] = $nilai_standar;
    //         $alternatif["nilai_isi"] = $nilai_isi;
    //         $alternatif["selisih"] = $selisih;
    //         $alternatif["nilai_gap"] = $nilai_gap;
    //         $alternatif["pengelompokan"] = $pengelompokan;
    //         $alternatif["nama_kriteria"] = $nama_kriteria;
    
    //         $data[] = $alternatif;
    //     }
    
    //     // Menghitung nilai NCF dan NSF
    //     $hasil_per_kriteria = [];
    //     foreach ($data as $alternatif) {
    //         $nama_kriteria = $alternatif["nama_kriteria"];
    //         if (isset($hasil_per_kriteria[$nama_kriteria])) {
    //             continue;
    //         }
    
    //         $id_kriteria = $alternatif["id_kriteria"];
    //         $nilai_gap_sum_ncf = 0;
    //         $nilai_gap_sum_nsf = 0;
    //         $jumlah_subkriteria_core_factor = 0;
    //         $jumlah_subkriteria_secondary_factor = 0;
    
    //         foreach ($data as $item) {
    //             if ($item["nama_kriteria"] == $nama_kriteria) {
    //                 if ($item["pengelompokan"] == 'core factor') {
    //                     $nilai_gap_sum_ncf += $item["nilai_gap"];
    //                     $jumlah_subkriteria_core_factor++;
    //                 } elseif ($item["pengelompokan"] == 'secondary factor') {
    //                     $nilai_gap_sum_nsf += $item["nilai_gap"];
    //                     $jumlah_subkriteria_secondary_factor++;
    //                 }
    //             }
    //         }
    
    //         $ncf = $jumlah_subkriteria_core_factor > 0 ? $nilai_gap_sum_ncf / $jumlah_subkriteria_core_factor : 0;
    //         $nsf = $jumlah_subkriteria_secondary_factor > 0 ? $nilai_gap_sum_nsf / $jumlah_subkriteria_secondary_factor : 0;
    //         $nAspek = (0.6 * $ncf) + (0.4 * $nsf);
    //         $persentase_kriteria = Kriteria::where('id', $id_kriteria)->value('persentase') / 100;
    //         $nKriteria = $nAspek * $persentase_kriteria;
    
    //         $hasil_per_kriteria[$nama_kriteria] = $nKriteria;
    
    //         foreach ($data as &$item) {
    //             if ($item["nama_kriteria"] == $nama_kriteria) {
    //                 $item["ncf"] = $ncf;
    //                 $item["nsf"] = $nsf;
    //                 $item["nAspek"] = $nAspek;
    //                 $item["persentase_kriteria"] = $persentase_kriteria;
    //                 $item["nKriteria"] = $nKriteria;
    //             }
    //         }
    //         unset($item);
    //     }
    
    //     $total_hasil_keseluruhan = array_sum($hasil_per_kriteria);
    
    //     // Proses penyimpanan
    //     $kualifikasi = [];
    //     foreach ($request->kualifikasi as $key => $value) {
    //         $isi_detail = null;
    //         if ($request->hasFile("kualifikasi.$key.isi_detail")) {
    //             $file = $request->file("kualifikasi.$key.isi_detail");
    //             $filename = time() . '_' . $file->getClientOriginalName();
    //             $file->storeAs('public/lamar', $filename);
    //             $isi_detail = 'storage/lamar/' . $filename;
    //         } else {
    //             $isi_detail = $value['isi_detail'] ?? null;
    //         }
    
    //         $kualifikasi[] = [
    //             'id_jawab' => $value['id_jawab'],
    //             'isi_detail' => $isi_detail
    //         ];
    //     }
    
    //     // Simpan ke tabel Lamar
    //     $dataLamar = new Lamar;
    //     $dataLamar->id_pelamar = $id_pelamar;
    //     $dataLamar->id_lowongan = $request->id_lowongan;
    //     $dataLamar->nilai = json_encode($kualifikasi);
    //     $dataLamar->save();
    
    //     // Ambil id_lamar yang baru dimasukkan
    //     $id_lamar = $dataLamar->id;
    
    //     // Simpan ke tabel Hasil
    //     $dataHasil = new Hasil;
    //     $dataHasil->id_lamar = $id_lamar;
    //     $dataHasil->id_loker = $request->id_lowongan;
    //     $dataHasil->nilai = $total_hasil_keseluruhan;
    //     $dataHasil->save();
    
    //     return redirect('dashboard_pelamar')->with('success', 'Anda Berhasil Melamar Pekerjaan');
    // }
    

    public function lamarLoker(Request $request) {
        $id_pelamar = Auth::user()->pelamar->id;
    
        // Mencari record lama berdasarkan id_pelamar dan id_lowongan yang null
        $existingLamar = Lamar::where('id_pelamar', $id_pelamar)
                              ->whereNull('id_lowongan')
                              ->first();
        $existingKualifikasi = [];
    
        if ($existingLamar) {
            // Mendekode data nilai lama
            $existingKualifikasi = json_decode($existingLamar->nilai, true);
        }
    
        // Mengumpulkan nilai kualifikasi baru
        $kualifikasiBaru = [];
        foreach ($request->kualifikasi as $key => $value) {
            // Memproses file jika ada
            $isi_detail = null;
            if ($request->hasFile("kualifikasi.$key.isi_detail")) {
                $file = $request->file("kualifikasi.$key.isi_detail");
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/lamar', $filename);
                $isi_detail = 'storage/lamar/' . $filename;
            } else {
                $isi_detail = $value['isi_detail'] ?? null;
            }
    
            $kualifikasiBaru[] = [
                'id_jawab' => $value['id_jawab'],
                'isi_detail' => $isi_detail,
                'status' => "belum diverifikasi"
            ];
        }
    
        // Menggabungkan data kualifikasi lama dengan yang baru
        $mergedKualifikasi = array_merge($existingKualifikasi, $kualifikasiBaru);
    
        // Membuat record baru dengan data yang telah digabungkan
        $dataHasil = new Lamar;
        $dataHasil->id_pelamar = $id_pelamar;
        $dataHasil->id_lowongan = $request->id_lowongan;
        $dataHasil->nilai = json_encode($mergedKualifikasi);
        $dataHasil->save();
    
        return redirect('dashboard_pelamar')->with('success', 'Anda Berhasil Melamar Pekerjaan');
    }
    
    
    

    public function pengumuman()
    {
        $id_pelamar = Auth::user()->pelamar->id;
        $pengumuman = Pengumuman::join('hasil_akhir','pengumuman.id_hasil','=','hasil_akhir.id')
                                ->join('lamar','hasil_akhir.id_lamar','=','lamar.id')
                                ->where('lamar.id_pelamar', $id_pelamar)->first();
    
        return view('pelamar.pengumuman', ['pengumuman' => $pengumuman]);
    }
    
    
    
   
    }
