<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelamar;
use App\Models\Lamar;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\Lowongan;
use App\Models\Kriteria;
use App\Models\Hasil;
use App\Models\SubKriteria;
use App\Models\SyaratLoker;
use App\Models\NilaiIsi;
use Illuminate\Support\Facades\DB;
use App\Models\BobotGap;
use Illuminate\Support\Facades\Http;



class HRDController extends Controller
{
    //
    public function dashboard(){
        $loker = Lowongan::count();
        $pelamar = Pelamar::count();
        $user = User::count();
        return view('HRD.dashboard', compact('loker','pelamar','user'));
    }
// data pelamar
        public function dataPelamar(){
            $data = Lowongan::select(
                            'lowongan.id', 
                            'lowongan.lowongan', 
                            'lowongan.kuota', 
                            DB::raw('COUNT(lamar.id) as pendaftar'),
                            DB::raw('COUNT(CASE WHEN lamar.status = "lolos" THEN 1 END) as lolos'),
                            DB::raw('COUNT(CASE WHEN lamar.status = "tidak lolos" THEN 1 END) as tidak_lolos')
                        )
                        ->leftJoin('lamar', 'lowongan.id', '=', 'lamar.id_lowongan')
                        ->groupBy('lowongan.id', 'lowongan.lowongan', 'lowongan.kuota')
                        ->paginate(5);

            return view('HRD.data-pelamar', ['data' => $data]);
        }

        public function detailPelamar($id){
            $data = Lamar::join('pelamar', 'lamar.id_pelamar', '=', 'pelamar.id')
                         ->select('lamar.*', 'pelamar.nama_lengkap as nama_pelamar', 'pelamar.alamat', 'pelamar.no_hp')
                         ->where('lamar.id_lowongan', $id)
                         ->paginate(10);
        
            $data1 = Lowongan::where('id', $id)->first();
        
            // Menguraikan nilai JSON dan melakukan join manual dalam PHP
            foreach ($data as $lamar) {
                $nilai = json_decode($lamar->nilai, true);
                $nilaiDetail = [];
                foreach ($nilai as $index => $item) {
                    $nilaiIsi = NilaiIsi::join('sub_kriteria', 'nilai_isi.id_sub', '=', 'sub_kriteria.id')
                                        ->where('nilai_isi.id', $item['id_jawab'])
                                        ->select('nilai_isi.keterangan_isi', 'sub_kriteria.nama_sub_kriteria','nilai_isi.id_sub')
                                        ->first();
                    $nilaiDetail[$index] = [
                        'id_jawab' => $item['id_jawab'],
                        'isi_detail' => $item['isi_detail'],
                        'status' => $item['status'],
                        'nama_sub_kriteria' => $nilaiIsi->nama_sub_kriteria ?? '',
                        'keterangan_isi' => $nilaiIsi->keterangan_isi ?? '',
                        'id_sub' => $nilaiIsi->id_sub ?? ''
                    ];
                }
                $lamar->nilai_detail = $nilaiDetail; // Menambahkan atribut tambahan ke model
            }
        
            return view('HRD.detail-pelamar', ['data' => $data, 'data1' => $data1]);
        }
//update jawab

    public function markAsDone(Request $request)
    {
        $idPelamar = $request->input('id_pelamar');
        $index = $request->input('index');

        $lamar = Lamar::where('id', $idPelamar)->first();
        $nilai = json_decode($lamar->nilai, true);

        if (isset($nilai[$index])) {
            $nilai[$index]['status'] = 'diverifikasi';
            $lamar->nilai = json_encode($nilai);
            $lamar->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function saveValidation(Request $request)
    {
        $idPelamar = $request->input('id_pelamar');
        $idJawab = $request->input('id_jawab');
        $newAnswer = $request->input('new_answer');

        // Temukan pelamar dengan idPelamar dan idJawab yang sesuai
        $lamar = Lamar::where('id', $idPelamar)->first();
        $nilai = json_decode($lamar->nilai, true);

        // Perbarui id_jawab dalam nilai
        foreach ($nilai as &$item) {
            if ($item['id_jawab'] == $idJawab) {
                $item['id_jawab'] = $newAnswer;
                $item['status'] = "diverifikasi";
            }
        }
        $lamar->nilai = json_encode($nilai);
        $lamar->save();

        return response()->json(['success' => true]);
    }
  

// Lowongan
    public function dataLowongan(){
        $data = Lowongan::paginate(5);
        return view('HRD.data-lowongan', ['data' => $data]);
    }

    public function tambahLowongan(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
        ];

        $attributes = request()->validate([
            'lowongan'=> 'required',
            'kuota' => 'required',
            'status' => 'required',
        ], $message);
        
        $data = new Lowongan;
        $data->lowongan = $request->lowongan;
        $data->kuota = $request->kuota;
        $data->status = $request->status;
        $data->tanggal_mulai = $request->tanggal_mulai;
        $data->tanggal_berakhir = $request->tanggal_berakhir;       
        $data->save($attributes);
        return redirect('/data-lowongan')->with('success', 'Lowongan berhasil disimpan');
    }

    public function updateLowongan(Request $request, $id){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
            'numeric' => 'attribute harus berupa angka',
        ];

        $this->validate($request, [
            'lowongan'=> 'required',
            'kuota' => 'required',
            'status' => 'required',
        ], $message);

        $data = Lowongan::find($id);
        $data->lowongan = $request->lowongan;
        $data->kuota = $request->kuota;
        $data->status = $request->status;
        $data->tanggal_mulai = $request->tanggal_mulai;
        $data->tanggal_berakhir = $request->tanggal_berakhir;  
        $data->update();
        return redirect('/data-lowongan')->with('success', 'Lowongan berhasil diubah');;
    }

    public function deleteLowongan($id){
        $data = Lowongan::find($id);
        $data->delete();
        return redirect('/data-lowongan')->with('success', 'Lowongan berhasil dihapus');;
    }

// Kriteria
    public function dataKriteria(){
        $data = Kriteria::paginate(5);
        return view('HRD.data-kriteria', ['data' => $data]);
    }

    public function tambahKriteria(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
        ];

        $attributes = request()->validate([
            'nama_kriteria'=> 'required',
            'kode' => 'required',
            'persentase' => 'required',
        ], $message);
        
        $data = new Kriteria;
        $data->nama_kriteria = $request->nama_kriteria;
        $data->kode = $request->kode;
        $data->persentase = $request->persentase;
        $data->save($attributes);
        return redirect('/data-kriteria')->with('success', 'Aspek berhasil disimpan');
    }

    public function updateKriteria(Request $request, $id){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
            'numeric' => 'attribute harus berupa angka',
        ];

        $this->validate($request, [
            'nama_kriteria'=> 'required',
            'kode' => 'required',
            'persentase' => 'required',
        ], $message);

        $data = Kriteria::find($id);
        $data->nama_kriteria = $request->nama_kriteria;
        $data->kode = $request->kode;
        $data->persentase = $request->persentase;
        $data->update();
        return redirect('/data-kriteria')->with('success', 'Aspek berhasil diubah');;
    }

    public function deleteKriteria($id){
        $data = Kriteria::find($id);
        $data->delete();
        return redirect('/data-kriteria')->with('success', 'Aspek berhasil dihapus');;
    }

// // sub kriteria
//      public function dataSubKriteria(){
//         $data = SubKriteria::join('kriteria','sub_kriteria.id_kriteria','=','kriteria.id')
//                             ->select('sub_kriteria.*','kriteria.nama_kriteria')
//                             ->paginate(5);

//         $data1 = Kriteria::all(); 

//         return view('HRD.data-subKriteria', ['data' => $data, 'data1' => $data1]);
//     }

//     public function tambahSubKriteria(Request $request){
//         //validasi form
//         $message= [
//             'required' =>':attribute tidak boleh kosong',
//             'unique' => 'attribute sudah digunakan',
//         ];

//         $attributes = request()->validate([
//             'id_kriteria'=> 'required',
//             'kode_sub' => 'required',
//             'nama_sub_kriteria' => 'required',
//             'nilai_standar' => 'required',
//             'pengelompokan' => 'required',
//         ], $message);
        
//         $data = new SubKriteria;
//         $data->id_kriteria = $request->id_kriteria;
//         $data->kode_sub = $request->kode_sub;
//         $data->nama_sub_kriteria = $request->nama_sub_kriteria;
//         $data->nilai_standar = $request->nilai_standar;
//         $data->pengelompokan = $request->pengelompokan;
//         $data->save($attributes);
//         return redirect('/data-subKriteria')->with('success', 'Lowongan berhasil disimpan');
//     }

//     public function updateSubKriteria(Request $request, $id){
//         //validasi form
//         $message= [
//             'required' =>':attribute tidak boleh kosong',
//             'unique' => 'attribute sudah digunakan',
//             'numeric' => 'attribute harus berupa angka',
//         ];

//         $this->validate($request, [
//             'id_kriteria'=> 'required',
//             'kode_sub' => 'required',
//             'nama_sub_kriteria' => 'required',
//             'nilai_standar' => 'required',
//             'pengelompokan' => 'required',
//         ], $message);

//         $data = SubKriteria::find($id);
//         $data->id_kriteria = $request->id_kriteria;
//         $data->kode_sub = $request->kode_sub;
//         $data->nama_sub_kriteria = $request->nama_sub_kriteria;
//         $data->nilai_standar = $request->nilai_standar;
//         $data->pengelompokan = $request->pengelompokan;
//         $data->update();
//         return redirect('/data-subKriteria')->with('success', 'Pengguna berhasil diubah');;
//     }

//     public function deleteSubKriteria($id){
//         $data = SubKriteria::find($id);
//         $data->delete();
//         return redirect('/data-subKriteria')->with('success', 'Data berhasil dihapus');;
//     }

// Nilai Isi
        public function dataNilaiIsi(){
            $data = NilaiIsi::join('sub_kriteria','nilai_isi.id_sub','=','sub_kriteria.id')
                                ->select('nilai_isi.*','sub_kriteria.nama_sub_kriteria')
                                ->paginate(10);
    
            $data1 = SubKriteria::all(); 
    
            return view('HRD.data-nilaiIsi', ['data' => $data, 'data1' => $data1]);
        }
    
        public function tambahNilaiIsi(Request $request){
            //validasi form
            $message= [
                'required' =>':attribute tidak boleh kosong',
                'unique' => 'attribute sudah digunakan',
            ];
    
            $attributes = request()->validate([
                'id_sub'=> 'required',
                'keterangan_isi' => 'required',
                'nilai_isi' => 'required',
            ], $message);
            
            $data = new NilaiIsi;
            $data->id_sub = $request->id_sub;
            $data->keterangan_isi = $request->keterangan_isi;
            $data->nilai_isi = $request->nilai_isi;
            $data->save($attributes);
            return redirect('/data-nilaiIsi')->with('success', 'Nilai Jawaban berhasil disimpan');
        }
    
        public function updateNilaiIsi(Request $request, $id){
            //validasi form
            $message= [
                'required' =>':attribute tidak boleh kosong',
                'unique' => 'attribute sudah digunakan',
                'numeric' => 'attribute harus berupa angka',
            ];
    
            $this->validate($request, [
                'id_sub'=> 'required',
                'keterangan_isi' => 'required',
                'nilai_isi' => 'required',
            ], $message);
    
            $data = NilaiIsi::find($id);
            $data->id_sub = $request->id_sub;
            $data->keterangan_isi = $request->keterangan_isi;
            $data->nilai_isi = $request->nilai_isi;
            $data->update();
            return redirect('/data-nilaiIsi')->with('success', 'Nilai jawaban berhasil diubah');;
        }
    
        public function deleteNilaiIsi($id){
            $data = NilaiIsi::find($id);
            $data->delete();
            return redirect('/data-nilaiIsi')->with('success', 'Nilai jawaban berhasil dihapus');;
        }

// Bobot Gap
        public function dataBobotGap(){
                $data = BobotGap::paginate(5);
        
                return view('HRD.data-bobotGap', ['data' => $data]);
        }
        
        public function tambahBobotGap(Request $request){
                //validasi form
                $message= [
                    'required' =>':attribute tidak boleh kosong',
                    'unique' => 'attribute sudah digunakan',
                ];
        
                $attributes = request()->validate([
                    'selisih'=> 'required',
                    'nilai_gap' => 'required',
                    'keterangan_gap' => 'required',
                ], $message);
                
                $data = new BobotGap;
                $data->selisih = $request->selisih;
                $data->nilai_gap = $request->nilai_gap;
                $data->keterangan_gap = $request->keterangan_gap;
                $data->save($attributes);
                return redirect('/data-bobotGap')->with('success', 'Bobot gap berhasil disimpan');
        }
        
        public function updateBobotGap(Request $request, $id){
                //validasi form
                $message= [
                    'required' =>':attribute tidak boleh kosong',
                    'unique' => 'attribute sudah digunakan',
                    'numeric' => 'attribute harus berupa angka',
                ];
        
                $this->validate($request, [
                    'selisih'=> 'required',
                    'nilai_gap' => 'required',
                    'keterangan_gap' => 'required',
                ], $message);
        
                $data = BobotGap::find($id);
                $data->selisih = $request->selisih;
                $data->nilai_gap = $request->nilai_gap;
                $data->keterangan_gap = $request->keterangan_gap;
                $data->update();
                return redirect('/data-bobotGap')->with('success', 'Bobot gap berhasil diubah');;
        }
        
        public function deleteBobotGap($id){
                $data = BobotGap::find($id);
                $data->delete();
                return redirect('/data-bobotGap')->with('success', 'Bobot gap berhasil dihapus');;
        }


//perhitungan
        public function lowonganLamar()
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
                ->paginate(5);

            return view('/HRD.lamar-lowongan', ['data' => $data]);
        }
        
        
        public function lanjutan($id) {
            $data = Lowongan::find($id);
            $nilai = $id; // Misalnya ini nilai yang ingin Anda kirim ke view
        
            // Mengirim nilai $nilai ke dalam view 'HRD.lanjutan'
            return view('HRD.lanjutan', compact('nilai'));
        }

        public function startSpk($id) {
            try {

                // Mengambil data dari model Lamar berdasarkan id_lowongan dan menggabungkan dengan tabel pelamar
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
        
                return view('HRD.uji-coba', ['pelamarData' => $pelamarData, 'id_low' => $id]);
            } catch (\Exception $e) {
                // Debug output untuk pengecekan error
                // dd($e->getMessage());
        
                return response()->json(['message' => 'Terjadi kesalahan saat mengambil data kriteria'], 500);
            }
        }
        
        public function ujiCoba($id) {
            try {
                // Mengambil data dari model Lamar berdasarkan id_lowongan dan menggabungkan dengan tabel pelamar
                $lamarData = Lamar::where('id_lowongan', $id)
                            ->join('pelamar', 'lamar.id_pelamar', '=', 'pelamar.id')
                            ->select('lamar.*', 'pelamar.nama_lengkap')  
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
                                        ->select('nilai_isi.nilai_isi', 'sub_kriteria.nilai_standar', 'sub_kriteria.nama_sub_kriteria as nama_kualifikasi',
                                                'sub_kriteria.pengelompokan', 'kriteria.nama_kriteria', 'kriteria.persentase','nilai_isi.id_sub','sub_kriteria.input_pelamar')
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
                                'id_sub' => $nilaiDetail->id_sub,
                                'tipe' => $nilaiDetail->input_pelamar,
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
                        'jawab' => $jawabArray,
                        'kelompok' => $kelompokArray,
                        'hasil_akhir' => $hasil_akhir,
                        'status' => $status
                    ];
                }
        
                // Mengembalikan response dalam bentuk JSON
                dd(['pelamarData' => $pelamarData]); // Debug output
        
                return response()->json(['pelamarData' => $pelamarData], $id_low, 200);
            } catch (\Exception $e) {
                // Debug output untuk pengecekan error
                dd($e->getMessage());
        
                return response()->json(['message' => 'Terjadi kesalahan saat mengambil data kriteria'], 500);
            }
        }
    
        // public function hasil($id){
        //     // Mengambil data hasil berdasarkan id_lowongan dari tabel hasil_akhir, diurutkan berdasarkan nilai dari besar ke kecil
        //     $data1= Lowongan::find($id);
        //     $data = Hasil::join('lamar','hasil_akhir.id_lamar','=','lamar.id')
        //                   ->join('pelamar','lamar.id_pelamar','=','pelamar.id')
        //                   ->select('hasil_akhir.*','pelamar.nama_lengkap','lamar.status')
        //                   ->where('id_loker', $id)
        //                   ->orderBy('nilai', 'desc') // Urutkan berdasarkan kolom nilai dari besar ke kecil
        //                   ->get();
            
        //     // Jika data ditemukan
        //     if($data->count() > 0){
        //         return response()->json(['data' => $data, 'data1' => $data1], 200); // Kirim respon JSON dengan data hasil yang telah diurutkan
        //     } else {
        //         return response()->json(['error' => 'Data tidak ditemukan'], 404); // Kirim respon JSON dengan status kode 404 jika data tidak ditemukan
        //     }
        // }
        
// syarat_loker
    public function dataSyarat($id){
        $data1 = Lowongan::where('id',$id)
                           ->first();

        $data = SyaratLoker::where('id_loker', $id)
                             ->join('lowongan','syarat_loker.id_loker','=','lowongan.id')
                             ->select('syarat_loker.*','lowongan.lowongan AS nama_loker')
                              ->paginate(5);
        return view('HRD.data-syarat', ['data' => $data, 'data1' => $data1]);
    }

    public function tambahSyarat(Request $request)
    {
        // Validasi form
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute sudah digunakan',
        ];
    
        $attributes = $request->validate([
            'syarat' => 'required',
            'id_loker' => 'required|exists:lowongan,id', // pastikan id_loker valid
        ], $message);
    
        // Menyimpan data syarat loker
        $data = new SyaratLoker();
        $data->id_loker = $request->id_loker;
        $data->syarat = $request->syarat;
        $data->save();
    
        // Redirect ke halaman syarat berdasarkan id_loker
        $id_loker = $request->id_loker;
        return redirect()->route('syarat', ['id' => $id_loker])
            ->with('success', 'Syarat berhasil ditambahkan');
    }

    public function updateSyarat(Request $request, $id)
    {
        // Validasi form
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
            'numeric' => 'attribute harus berupa angka',
        ];
    
        $this->validate($request, [
            'syarat' => 'required',
        ], $message);
    
        // Mengambil data syarat loker
        $data = SyaratLoker::find($id);
        $data->syarat = $request->input('syarat');
        $data->update();
    
        // Mengambil id_loker dari request
        $id_loker = $request->input('id_loker');
    
        return redirect()->route('syarat', ['id' => $id_loker])
            ->with('success', 'Pengguna berhasil diubah');
    }

    public function deleteSyarat($id)
    {
        // Mengambil data syarat loker berdasarkan ID
        $data = SyaratLoker::find($id);
        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan');
        }
    
        // Mengambil id_loker sebelum data dihapus
        $id_loker = $data->id_loker;
    
        // Menghapus data syarat loker
        $data->delete();
    
        // Redirect ke halaman syarat berdasarkan id_loker
        return redirect()->route('syarat', ['id' => $id_loker])->with('success', 'Data berhasil dihapus');
    }

// kualifikasi

    public function dataKualifikasiUmum(){
        $data = SubKriteria::where('id_loker','0')
                            ->join('kriteria','sub_kriteria.id_kriteria','=','kriteria.id')
                            ->select('sub_kriteria.*','kriteria.nama_kriteria')
                            ->get();
        $data1 = Kriteria::all(); 
       
        return view('HRD.data-kualifikasiUmum', ['data' => $data, 'data1' => $data1]);
    }

    public function jawabanKualifikasiUmum()
    {
        $data = SubKriteria::where('id_loker','0')->paginate(10);
        return view('HRD.jawaban-kualifikasiUmum', ['data' => $data]);
    }

    public function tambahKualifikasiUmum(Request $request)
    {
        // Validasi form
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute sudah digunakan',
        ];
    
        $attributes = $request->validate([
            'nama_sub_kriteria' => 'required', // pastikan id_loker valid
        ], $message);
    
        // Menyimpan data syarat loker
        $data = new SubKriteria();
        $data->id_kriteria = $request->id_kriteria;
        $data->id_loker = '0';
        $data->nama_sub_kriteria = $request->nama_sub_kriteria;
        $data->nilai_standar = $request->nilai_standar;
        $data->pengelompokan = $request->pengelompokan;
        $data->input_pelamar = $request->input_pelamar;
        $data->perintah = $request->perintah;
        $data->save();
    
        // Redirect ke halaman syarat berdasarkan id_loker
        return redirect('/data-kualifikasiUmum')->with('success', 'Kualifikasi  berhasil disimpan');
    }

    public function updateKualifikasiUmum(Request $request, $id)
    {
        // Validasi form
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
            'numeric' => 'attribute harus berupa angka',
        ];
    
        $this->validate($request, [
            'nama_sub_kriteria' => 'required',
        ], $message);
    
        // Mengambil data syarat loker
        $data = SubKriteria::find($id);
        $data->id_kriteria = $request->id_kriteria;
        $data->nama_sub_kriteria = $request->nama_sub_kriteria;
        $data->nilai_standar = $request->nilai_standar;
        $data->pengelompokan = $request->pengelompokan;
        $data->input_pelamar = $request->input_pelamar;
        $data->perintah = $request->perintah;
        $data->update();
    
        // Mengambil id_loker dari request
        return redirect('/data-kualifikasiUmum')->with('success', 'Kualifikasi  berhasil disimpan');
    }

    public function deleteKualifikasiUmum($id)
    {
        // Mengambil data syarat loker berdasarkan ID
        $data = SubKriteria::find($id);
        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan');
        }
    
        $data->delete();
    
        return redirect('/data-kualifikasiUmum')->with('success', 'Kualifikasi  berhasil disimpan');
    }

    public function dataKualifikasi($id){
        $data = SubKriteria::join('kriteria','sub_kriteria.id_kriteria','=','kriteria.id')
                            ->select('sub_kriteria.*','kriteria.nama_kriteria as nama_aspek')
                            ->where('sub_kriteria.id_loker',$id)
                            ->paginate(10);

        $data1 = Kriteria::all(); 
        $data2 = Lowongan::where('id',$id)
                        ->first();

        return view('HRD.kualifikasi-lowongan', ['data' => $data, 'data1' => $data1, 'data2' => $data2]);
    }

    public function tambahKualifikasi(Request $request)
    {
        // Validasi form
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute sudah digunakan',
        ];
    
        $attributes = $request->validate([
            'nama_sub_kriteria' => 'required', // pastikan id_loker valid
        ], $message);
    
        // Ambil data yang ada berdasarkan id_kriteria dan id_loker
        $coreFactorCount = SubKriteria::where('id_kriteria', $request->id_kriteria)
                                        ->where('id_loker', $request->id_loker)
                                        ->where('pengelompokan', 'core factor')
                                        ->count();
    
        $secondaryFactorCount = SubKriteria::where('id_kriteria', $request->id_kriteria)
                                           ->where('id_loker', $request->id_loker)
                                           ->where('pengelompokan', 'secondary factor')
                                           ->count();
    
        // Jika pengelompokan yang ditambahkan adalah 'secondary factor' dan jumlahnya akan melebihi jumlah 'core factor', batalkan proses
        if ($request->pengelompokan == 'secondary factor' && $secondaryFactorCount >= $coreFactorCount) {
            return back()->with('error', 'Kualifikasi secondary factor tidak boleh lebih banyak dari core factor');
        }
    
        // Menyimpan data syarat loker
        $data = new SubKriteria();
        $data->id_kriteria = $request->id_kriteria;
        $data->id_loker = $request->id_loker;
        $data->nama_sub_kriteria = $request->nama_sub_kriteria;
        $data->nilai_standar = $request->nilai_standar;
        $data->pengelompokan = $request->pengelompokan;
        $data->input_pelamar = $request->input_pelamar;
        $data->perintah = $request->perintah;
        $data->save();
    
        // Redirect ke halaman syarat berdasarkan id_loker
        return back()->with('success', 'Kualifikasi berhasil ditambahkan');
    }
    

    public function updateKualifikasi(Request $request, $id)
    {
        // Validasi form
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
            'numeric' => 'attribute harus berupa angka',
        ];
    
        $this->validate($request, [
            'nama_sub_kriteria' => 'required',
        ], $message);
    
        // Mengambil data syarat loker
        $data = SubKriteria::find($id);
        $data->id_kriteria = $request->id_kriteria;
        $data->nama_sub_kriteria = $request->nama_sub_kriteria;
        $data->nilai_standar = $request->nilai_standar;
        $data->pengelompokan = $request->pengelompokan;
        $data->input_pelamar = $request->input_pelamar;
        $data->perintah = $request->perintah;
        $data->update();
    
        // Mengambil id_loker dari request
        $id_loker = $request->id_loker;
    
        return redirect()->route('kualifikasi', ['id' => $id_loker])
            ->with('success', 'kualifikasi berhasil diubah');
    }

    public function deleteKualifikasi($id)
    {
        // Mengambil data syarat loker berdasarkan ID
        $data = SubKriteria::find($id);
        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan');
        }
    
        // Mengambil id_loker sebelum data dihapus
        $id_loker = $data->id_loker;
    
        // Menghapus data syarat loker
        $data->delete();
    
        // Redirect ke halaman syarat berdasarkan id_loker
        return redirect()->route('kualifikasi', ['id' => $id_loker])->with('success', 'Data berhasil dihapus');
    }

// nilai jawaban
        public function nilaiJawaban(Request $request)
        {
            $query = SubKriteria::join('lowongan', 'sub_kriteria.id_loker', '=', 'lowongan.id')
                                ->join('kriteria', 'sub_kriteria.id_kriteria', '=', 'kriteria.id')
                                ->select('sub_kriteria.*', 'lowongan.lowongan', 'kriteria.nama_kriteria');

            if ($request->has('id_loker') && $request->id_loker != '') {
                $query->where('sub_kriteria.id_loker', $request->id_loker);
            }

            $data = $query->paginate(10);
            $lowongan = Lowongan::all();

            return view('HRD.nilai-jawaban', ['data' => $data, 'lowongan' => $lowongan]);
        }


    public function dataJawab($id){
        $data1 = SubKriteria::where('id',$id)
                            ->first();
        $data = NilaiIsi::where('nilai_isi.id_sub',$id)
                          ->paginate(10);

        return view('HRD.data-jawab', ['data' => $data,'data1' => $data1]);
    }

    public function tambahJawab(Request $request)
    {
        // Validasi form
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute sudah digunakan',
        ];
    
        $attributes = $request->validate([
            'keterangan_isi' => 'required', // pastikan id_loker valid
        ], $message);
    
        // Menyimpan data syarat loker
        $data = new NilaiIsi();
        $data->id_sub = $request->id_sub;
        $data->keterangan_isi = $request->keterangan_isi;
        $data->nilai_isi = $request->nilai_isi;
        $data->save();
    
        // Redirect ke halaman syarat berdasarkan id_loker
        $id_sub = $request->id_sub;
        return redirect()->route('jawab', ['id' => $id_sub])
            ->with('success', 'Jawaban berhasil ditambahkan');
    }

    public function updateJawab(Request $request, $id)
    {
        // Validasi form
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
            'numeric' => 'attribute harus berupa angka',
        ];
    
        $this->validate($request, [
            'keterangan_isi' => 'required',
        ], $message);
    
        // Mengambil data syarat loker
        $data = NilaiIsi::find($id);
        $data->keterangan_isi = $request->keterangan_isi;
        $data->nilai_isi = $request->nilai_isi;
        $data->update();
    
        // Mengambil id_loker dari request
        $id_sub = $request->id_sub;
    
        return redirect()->route('jawab', ['id' => $id_sub])
            ->with('success', 'kualifikasi berhasil diubah');
    }

    public function deleteJawab($id)
    {
        // Mengambil data syarat loker berdasarkan ID
        $data = NilaiIsi::find($id);
        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan');
        }
    
        // Mengambil id_loker sebelum data dihapus
        $id_sub = $data->id_sub;
    
        // Menghapus data syarat loker
        $data->delete();
    
        // Redirect ke halaman syarat berdasarkan id_loker
        return redirect()->route('jawab', ['id' => $id_sub])->with('success', 'Data berhasil dihapus');
    }

// jawab umum
    public function dataJawabUmum($id){
        $data1 = SubKriteria::where('id',$id)
                            ->first();
        $data = NilaiIsi::where('nilai_isi.id_sub',$id)
                        ->paginate(10);

        return view('HRD.data-jawab-umum', ['data' => $data,'data1' => $data1]);
    }








        public function lolosPengumuman(Request $request)
    {
        // Validasi dan simpan data wawancara
        $request->validate([
            'tgl_wawancara' => 'required|date',
        
        ]);

        $id_lamar = $request->id_lamar;

        // Update status di tabel lamar
        Lamar::where('id', $id_lamar)->update(['status' => 'selesai']);

        // Insert data ke tabel wawancara

        // Insert data ke tabel pengumuman
        Pengumuman::create([
            'id_hasil' => $request->id_hasil,
            'tgl_wawancara' => $request->tgl_wawancara,
            'jam_wawancara' => $request->jam_wawancara,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Wawancara berhasil disimpan');
    }

    public function gagalPengumuman(Request $request)
    {
        // Validasi dan simpan data wawancara
       
    
        $id_lamar = $request->id_lamar;
    
        // Update status di tabel lamar
        Lamar::where('id', $id_lamar)->update(['status' => 'selesai']);
    
        // Insert data ke tabel wawancara
    
        // Insert data ke tabel pengumuman
        Pengumuman::create([
            'id_hasil' => $request->id_hasil,
            'tgl_wawancara' => $request->tgl_wawancara,
            'status' => $request->status,
        ]);
    
        return redirect()->back()->with('success', 'Wawancara berhasil disimpan');
    }


    public function kirimPesan(Request $request) {
        try {
            $id_lowongan = $request->input('id_lowongan');
            $pelamarData = $request->input('pelamarData');
    
            foreach ($pelamarData as $pelamar) {
                $pelamar = json_decode($pelamar, true);
                $idPelamar = $pelamar['id_pelamar']; // Mengambil id_pelamar dari data yang dikirim
                $status = $pelamar['status'];
    
                // Update status in the database based on id_lowongan and id_pelamar
                Lamar::where('id_lowongan', $id_lowongan)
                     ->where('id_pelamar', $idPelamar)
                     ->update(['status' => $status]);
            }
    
            return redirect()->back()->with('success', 'Informasi berhasil di kirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim informasi.');
        }
    }

    public function kirimPesanPelamar(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
            'numeric' => 'attribute harus berupa angka',
        ];

        $this->validate($request, [
            'id_lowongan'=> 'required',
            'id_pelamar' => 'required',
            'status' => 'required',
        ], $message);
        $id_lowongan = $request->input('id_lowongan');
        $pelamarData = $request->input('id_pelamar');
        $noHp = $request->input('no_hp');
        $status = $request->input('status');
        $pesan = $request->input('pesan');

        Lamar::where('id_lowongan', $id_lowongan)
                     ->where('id_pelamar', $pelamarData)
                     ->update(['status' => $status]);

        $response = Http::post('http://localhost:8001/send-message', [
                    'number' => $noHp,
                    'message' => $pesan
                ]);

        if ($response->successful()) {
            return redirect('/data-pelamar')->with('success', 'Informasi telah diberikan dan pesan WhatsApp telah terkirim.');
        } else {
            return redirect('/data-pelamar')->with('error', 'Informasi telah diberikan tetapi pesan WhatsApp gagal terkirim.');
        }
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
    
        return view('/HRD.hasil-seleksi', ['data' => $data]);
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
    
            return view('HRD.tampilan-seleksi', ['pelamarData' => $pelamarData, 'id_low' => $id, 'hasilLoker'=> $hasilLoker]);
        } catch (\Exception $e) {
            // Debug output untuk pengecekan error
            // dd($e->getMessage());
    
            return response()->json(['message' => 'Terjadi kesalahan saat mengambil data kriteria'], 500);
        }
    }

    
        
}
