<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelamar;
use App\Models\Lamar;
use App\Models\Pengumuman;
use App\Models\Lowongan;
use App\Models\Kriteria;
use App\Models\User;
use App\Models\Hasil;
use App\Models\SubKriteria;
use App\Models\SyaratLoker;
use App\Models\NilaiIsi;
use Illuminate\Support\Facades\DB;
use App\Models\BobotGap;

class PemilikController extends Controller
{
    //
    public function dashboard(){

        $loker = Lowongan::count();
        $pelamar = Pelamar::count();
        $user = User::count();
        return view('pemilik.dashboard', compact('loker','pelamar','user'));
    }

    // public function hasilSeleksi(){
    //     $data = Lowongan::select(
    //                     'lowongan.id', 
    //                     'lowongan.lowongan', 
    //                     'lowongan.kuota', 
    //                     DB::raw('COUNT(lamar.id) as pendaftar'),
    //                     DB::raw('COUNT(CASE WHEN lamar.status = "lolos" THEN 1 END) as lolos'),
    //                     DB::raw('COUNT(CASE WHEN lamar.status = "tidak lolos" THEN 1 END) as tidak_lolos')
    //                 )
    //                 ->leftJoin('lamar', 'lowongan.id', '=', 'lamar.id_lowongan')
    //                 ->groupBy('lowongan.id', 'lowongan.lowongan', 'lowongan.kuota')
    //                 ->paginate(5);

    //     return view('pemilik.data-pelamar', ['data' => $data]);
    // }

    // public function detailSeleksi($id){
    //     $data = Lamar::join('pelamar', 'lamar.id_pelamar', '=', 'pelamar.id')
    //                  ->select('lamar.*', 'pelamar.nama_lengkap as nama_pelamar', 'pelamar.alamat', 'pelamar.no_hp')
    //                  ->where('lamar.id_lowongan', $id)
    //                  ->paginate(10);
    
    //     $data1 = Lowongan::where('id', $id)->first();
    
    //     // Menguraikan nilai JSON dan melakukan join manual dalam PHP
    //     foreach ($data as $lamar) {
    //         $nilai = json_decode($lamar->nilai, true);
    //         $nilaiDetail = [];
    //         foreach ($nilai as $index => $item) {
    //             $nilaiIsi = NilaiIsi::join('sub_kriteria', 'nilai_isi.id_sub', '=', 'sub_kriteria.id')
    //                                 ->where('nilai_isi.id', $item['id_jawab'])
    //                                 ->select('nilai_isi.keterangan_isi', 'sub_kriteria.nama_sub_kriteria')
    //                                 ->first();
    //             $nilaiDetail[$index] = [
    //                 'id_jawab' => $item['id_jawab'],
    //                 'isi_detail' => $item['isi_detail'],
    //                 'nama_sub_kriteria' => $nilaiIsi->nama_sub_kriteria ?? '',
    //                 'keterangan_isi' => $nilaiIsi->keterangan_isi ?? ''
    //             ];
    //         }
    //         $lamar->nilai_detail = $nilaiDetail; // Menambahkan atribut tambahan ke model
    //     }
    
    //     return view('pemilik.detail-pelamar', ['data' => $data, 'data1' => $data1]);
    // }

    public function pelamar(){
        $data = Pelamar::paginate(5);

        return view('pemilik.pelamar', ['data' => $data]);
    }

    public function hasilSeleksi()
    {
        $data = Lowongan::select(
                'lowongan.id',
                'lowongan.lowongan',
                'lowongan.kuota',
                DB::raw('COUNT(lamar.id) as pendaftar')
            )
            ->leftJoin('lamar', function($join) {
                $join->on('lowongan.id', '=', 'lamar.id_lowongan');
            })
            ->groupBy('lowongan.id', 'lowongan.lowongan', 'lowongan.kuota')
            ->having(DB::raw('COUNT(lamar.id)'), '>', 0)  // Hanya menampilkan pendaftar > 0
            ->paginate(5);
    
        return view('pemilik.hasil-seleksi', ['data' => $data]);
    }

    public function seleksi($id) {
        try {

            // Mengambil data dari model Lamar berdasarkan id_lowongan dan menggabungkan dengan tabel pelamar
            $hasilLoker = Lowongan::where('id',$id)
                                    ->first();
                                    
            $lamarData = Lamar::where('id_lowongan', $id)
                        ->join('pelamar', 'lamar.id_pelamar', '=', 'pelamar.id')
                        ->select('lamar.*', 'pelamar.nama_lengkap','pelamar.no_hp')  
                        ->get();
    
            // Array untuk menyimpan data nilai berdasarkan nama lengkap pelamar
            $pelamarData = [];
    
            // Mengakses nilai dari kolom JSON 'nilai' untuk setiap pelamar
            foreach ($lamarData as $lamar) {
                // Inisialisasi array untuk menyimpan nilai berdasarkan id_jawab untuk setiap pelamar
                $jawabArray = [];
                $kelompokArray = [];
                $hasil_akhir = 0; // Inisialisasi hasil akhir
    
                // Decode JSON yang ada di kolom 'nilai'
                $nilaiArray = json_decode($lamar->nilai, true);
    
                // Akses setiap id_jawab di dalam array nilai
                foreach ($nilaiArray as $nilai) {
                    // Ambil nilai, nilai_standar, pengelompokan, nama_kriteria, dan persentase dari tabel nilai_isi, sub_kriteria, dan kriteria berdasarkan id_jawab
                    $nilaiDetail = DB::table('nilai_isi')
                                    ->join('sub_kriteria', 'nilai_isi.id_sub', '=', 'sub_kriteria.id')
                                    ->join('kriteria', 'sub_kriteria.id_kriteria', '=', 'kriteria.id')
                                    ->where('nilai_isi.id', $nilai['id_jawab'])
                                    ->select('nilai_isi.nilai_isi', 'sub_kriteria.nilai_standar', 'sub_kriteria.nama_sub_kriteria as nama_kualifikasi','sub_kriteria.pengelompokan', 'kriteria.nama_kriteria', 'kriteria.persentase')
                                    ->first();
    
                    // Jika ditemukan nilai detail, hitung gap_selisih dan ambil nilai_gap dari bobot_gap
                    if ($nilaiDetail) {
                        $gap_selisih = $nilaiDetail->nilai_isi - $nilaiDetail->nilai_standar;
    
                        // Ambil nilai_gap dari tabel bobot_gap berdasarkan gap_selisih
                        $bobotGap = DB::table('bobot_gap')
                                    ->where('selisih', $gap_selisih)
                                    ->select('nilai_gap')
                                    ->first();
    
                        $nilai_gap = $bobotGap ? $bobotGap->nilai_gap : 0;
    
                        // Tambahkan data nilai untuk id_jawab ke dalam array jawab
                        $jawabArray[] = [
                            'id_jawab' => $nilai['id_jawab'],
                            'nilai_isi' => $nilaiDetail->nilai_isi,
                            'nama_kualifikasi' => $nilaiDetail->nama_kualifikasi,
                            'nilai_standar' => $nilaiDetail->nilai_standar,
                            'gap_selisih' => $gap_selisih,
                            'nilai_gap' => $nilai_gap,
                            'pengelompokan' => $nilaiDetail->pengelompokan,
                            'nama_kriteria' => $nilaiDetail->nama_kriteria,
                            'persentase' => $nilaiDetail->persentase / 100
                        ];
    
                        // Kelompokkan data berdasarkan nama_kriteria
                        if (!isset($kelompokArray[$nilaiDetail->nama_kriteria])) {
                            $kelompokArray[$nilaiDetail->nama_kriteria] = [
                                'items' => [],
                                'ncf' => 0,
                                'nsf' => 0,
                                'ntk' => 0,
                                'persen_cf' => 60,
                                'persen_sf' => 40,
                                'persentase' => $nilaiDetail->persentase / 100,
                                'nilai_akhir_kriteria' => 0
                            ];
                        }
                        $kelompokArray[$nilaiDetail->nama_kriteria]['items'][] = [
                            'nama_kualifikasi' => $nilaiDetail->nama_kualifikasi,
                            'nilai_gap' => $nilai_gap,
                            'pengelompokan' => $nilaiDetail->pengelompokan
                        ];
                    }
                }
    
                // Hitung NCF, NSF, NTK, dan nilai_akhir_kriteria untuk setiap nama_kriteria dalam kelompokArray
                foreach ($kelompokArray as $nama_kriteria => $kelompok) {
                    $coreFactorSum = 0;
                    $coreFactorCount = 0;
                    $secondaryFactorSum = 0;
                    $secondaryFactorCount = 0;
    
                    foreach ($kelompok['items'] as $item) {
                        if ($item['pengelompokan'] === 'core factor') {
                            $coreFactorSum += $item['nilai_gap'];
                            $coreFactorCount++;
                        } elseif ($item['pengelompokan'] === 'secondary factor') {
                            $secondaryFactorSum += $item['nilai_gap'];
                            $secondaryFactorCount++;
                        }
                    }
    
                    $ncf = $coreFactorCount > 0 ? $coreFactorSum / $coreFactorCount : 0;
                    $nsf = $secondaryFactorCount > 0 ? $secondaryFactorSum / $secondaryFactorCount : 0;
                    $ntk = $ncf * 0.6 + $nsf * 0.4;
                    $nilai_akhir_kriteria = $ntk * $kelompok['persentase'];
    
                    $kelompokArray[$nama_kriteria]['ncf'] = $ncf;
                    $kelompokArray[$nama_kriteria]['nsf'] = $nsf;
                    $kelompokArray[$nama_kriteria]['ntk'] = $ntk;
                    $kelompokArray[$nama_kriteria]['nilai_akhir_kriteria'] = $nilai_akhir_kriteria;
    
                    // Tambahkan nilai_akhir_kriteria ke hasil_akhir
                    $hasil_akhir += $nilai_akhir_kriteria;
                }
    
                // Tentukan status berdasarkan hasil_akhir
                $status = $hasil_akhir >= 4.10 ? 'lolos' : 'tidak lolos';
    
                // Tambahkan data nama lengkap, jawabArray, kelompokArray, hasil_akhir, dan status ke dalam array pelamarData
                $pelamarData[] = [
                    'id_pelamar' => $lamar->id_pelamar,
                    'status_awal' => $lamar->status,
                    'nama_lengkap' => $lamar->nama_lengkap,
                    'no_hp' => $lamar->no_hp,
                    'jawab' => $jawabArray,
                    'kelompok' => $kelompokArray,
                    'hasil_akhir' => $hasil_akhir,
                    'status' => $status
                ];
            }
    
            // Mengembalikan response dalam bentuk JSON
            // dd(['pelamarData' => $pelamarData]); // Debug output
    
            return view('pemilik.tampilan-seleksi', ['pelamarData' => $pelamarData, 'id_low' => $id, 'hasilLoker'=> $hasilLoker]);
        } catch (\Exception $e) {
            // Debug output untuk pengecekan error
            // dd($e->getMessage());
    
            return response()->json(['message' => 'Terjadi kesalahan saat mengambil data kriteria'], 500);
        }
    }

}
