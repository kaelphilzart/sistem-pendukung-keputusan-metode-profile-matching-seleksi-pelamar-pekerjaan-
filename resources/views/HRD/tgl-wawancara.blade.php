<div class="modal fade" id="tgl-wawancara" tabindex="-1">
@if($item['status'] == 'lolos')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $item['nama_lengkap'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="terimaForm" action="{{ route('kirim-pesan-pelamar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_lowongan" value="{{ $id_low }}">
                    <input type="hidden" name="id_pelamar" value="{{ $item['id_pelamar'] }}">
                    <input type="hidden" name="status" value="{{ $item['status'] }}">
                    <input type="hidden" name="no_hp" value="{{ $item['no_hp'] }}">
                    
                    <div class="mb-3 text-dark">
                        <label for="tgl_wawancara" class="form-label">Tanggal Wawancara</label>
                        <input type="date" class="form-control text-dark" id="tgl_wawancara" name="tgl_wawancara">
                        @error('tgl_wawancara')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror

                        <!-- Input jam -->
                        <div class="mb-3 text-dark">
                            <label for="jam_wawancara" class="form-label">Jam Wawancara</label>
                            <input type="time" class="form-control text-dark" id="jam_wawancara" name="jam_wawancara">
                            @error('jam_wawancara')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input tersembunyi untuk pesan -->
                        <input type="hidden" id="pesan" name="pesan">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Kirim Informasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ">{{ $item['nama_lengkap'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark">
                <form id="terimaForm" action="{{ route('kirim-pesan-pelamar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_lowongan" value="{{ $id_low }}">
                    <input type="hidden" name="id_pelamar" value="{{ $item['id_pelamar'] }}">
                    <input type="hidden" name="status" value="{{ $item['status'] }}">
                    <input type="hidden" name="no_hp" value="{{ $item['no_hp'] }}">

                    <div id="pesan" name="pesan">
                        <h4>PT An - Namiroh</h4>
                        <div class="message-container">
                        <h3 class="text-danger">Terima Kasih</h3>
                        <p class="mt-2">Kami menghargai usaha dan waktu Anda yang telah mengikuti proses seleksi di <strong>PT. An Namiroh</strong>. Namun, saat ini Anda belum berhasil lolos seleksi.</p>
                        <p>Jangan berkecil hati, tetap semangat dan terus mencoba. Kami berharap Anda akan mendapatkan kesempatan yang lebih baik di waktu mendatang.</p>
                        <p class="mt-2">Salam hangat,<br><strong>PT. An Namiroh</strong></p>
                        </div>
                    </div>
                    <input type="hidden" id="pesan" name="pesan" value="
                        PT An - Namiroh

Kami menghargai usaha dan waktu Anda yang telah mengikuti proses seleksi di PT. An Namiroh. Namun, saat ini Anda belum berhasil lolos seleksi.
Jangan berkecil hati, tetap semangat dan terus mencoba. Kami berharap Anda akan mendapatkan kesempatan yang lebih baik di waktu mendatang.

Salam hangat,
PT. An Namiroh
                    ">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Kirim Informasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
        // Mendapatkan elemen-elemen yang diperlukan
        const tglInput = document.getElementById('tgl_wawancara');
        const jamInput = document.getElementById('jam_wawancara');
        const pesanInput = document.getElementById('pesan');
        let tglSpan = '';

        // Menambahkan event listener untuk input tanggal
        tglInput.addEventListener('change', function() {
            // Update nilai tglSpan
            let selectedDate = new Date(tglInput.value);
            tglSpan = selectedDate.toLocaleDateString('id-ID');
        });

        // Menambahkan event listener untuk input jam
        jamInput.addEventListener('change', function() {
            // Update nilai pesanInput hanya setelah jam dipilih
            let formattedDate = tglSpan; // Ambil tanggal yang sudah dipilih
            let formattedTime = jamInput.value;

            if (formattedDate && formattedTime) {
                pesanInput.value = `
                    Selamat!

Anda telah LOLOS seleksi tahap pertama. Kami sangat senang mengundang Anda ke tahap wawancara selanjutnya.

Jadwal Wawancara: ${formattedDate}
Jam: ${formattedTime}

Harap hadir di kantor kami pada jadwal tersebut untuk melakukan tes wawancara. Jangan lupa untuk membawa dokumen yang diperlukan.

Salam hangat,
PT. An Namiroh`;
            }
        });
    </script>
