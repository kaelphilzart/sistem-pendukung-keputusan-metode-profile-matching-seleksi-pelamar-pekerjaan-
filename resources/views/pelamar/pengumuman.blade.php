@extends('template.template_pelamar')

@section('content')
<div class="container">
    @if ($pengumuman)
        <div class="mt-4 text-center">
            <h2 class="font-weight-bold">PT. An Namiroh</h2>
            <h5 class="mt-2">Pengumuman</h5>
            <div class="card mt-4">
                <div class="card-body">
                    @if ($pengumuman->status = 'lolos')
                        <h3 class="text-success">Selamat!</h3>
                        <p class="mt-4">Anda telah <span class="font-weight-bold text-success fw-bold">LOLOS</span> seleksi tahap pertama. Kami sangat senang mengundang Anda ke tahap wawancara selanjutnya.</p>
                        <p><strong>Jadwal Wawancara:</strong> <span class="text-warning fw-bold">{{ $pengumuman->tgl_wawancara }}</span> Jam: <span class="text-warning fw-bold">{{ $pengumuman->jam_wawancara }}</span></p>
                        <p>Harap hadir di kantor kami pada jadwal tersebut untuk melakukan tes wawancara. Jangan lupa untuk membawa dokumen yang diperlukan.</p>
                        <p class="mt-4">Salam hangat,<br><strong>PT. An Namiroh</strong></p>
                    @else
                        <h3 class="text-danger">Terima Kasih</h3>
                        <p class="mt-4">Kami menghargai usaha dan waktu Anda yang telah mengikuti proses seleksi di <strong>PT. An Namiroh</strong>. Namun, saat ini Anda belum berhasil lolos seleksi.</p>
                        <p>Jangan berkecil hati, tetap semangat dan terus mencoba. Kami berharap Anda akan mendapatkan kesempatan yang lebih baik di waktu mendatang.</p>
                        <p class="mt-4">Salam hangat,<br><strong>PT. An Namiroh</strong></p>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="vh-100 d-flex flex-column justify-content-center align-items-center text-center">
            <div class="mt-4">
                <h2 class="font-weight-bold">PT. An Namiroh</h2>
                <h5 class="mt-2">Pengumuman</h5>
                <div class="mt-4">
                    <h2 class="font-weight-bold">Belum ada Informasi</h2>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
