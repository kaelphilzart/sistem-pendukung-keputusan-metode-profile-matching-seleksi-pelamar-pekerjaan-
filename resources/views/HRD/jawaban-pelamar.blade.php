@foreach($data as $detailPelamar)
<div class="modal fade" id="jawaban-pelamar{{$detailPelamar->id}}" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title">{{$detailPelamar->nama_pelamar}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark">
                <div class="container">
                    <div class="row">
                        @foreach($detailPelamar->nilai_detail as $index => $nilai)
                            <div class="col-md-4">
                                <div class="card shadow-md my-2">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark">Kualifikasi : {{ $nilai['nama_sub_kriteria'] }}</h5>
                                        <h6 class="card-subtitle mb-2 text-dark">Jawaban : {{ $nilai['keterangan_isi'] }}</h6>
                                        @if(is_string($nilai['isi_detail']) && str_starts_with($nilai['isi_detail'], 'storage/lamar/'))
                                            @if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $nilai['isi_detail']))
                                                <img src="{{ asset($nilai['isi_detail']) }}" alt="Image" style="max-width: 100%; max-height: 200px; object-fit: contain;">
                                                <p><a href="{{ asset($nilai['isi_detail']) }}" target="_blank" class="btn btn-link">Lihat File</a></p>
                                            @else
                                                <a href="{{ asset($nilai['isi_detail']) }}" target="_blank" class="btn btn-link">Lihat Detail</a>
                                            @endif
                                        @else
                                            <span class="text-dark">Ketentuan Detailnya  | {{ $nilai['isi_detail'] }}</span>
                                        @endif
                                        
                                        @if($nilai['status'] == 'belum diverifikasi')
                                            <button class="btn btn-success" id="done-btn-{{ $detailPelamar->id }}-{{ $index }}" onclick="markAsDone('{{ $detailPelamar->id }}', '{{ $index }}')">Sesuai</button>
                                            <button class="btn btn-danger" id="not-match-btn-{{ $detailPelamar->id }}-{{ $index }}" onclick="showForm('{{ $detailPelamar->id }}', '{{ $index }}')">Tidak Sesuai</button>
                                            <div id="form-{{ $detailPelamar->id }}-{{ $index }}" class="mt-3" style="display: none;">
                                                <form id="form-update-{{ $detailPelamar->id }}-{{ $index }}" onsubmit="event.preventDefault(); saveValidation('{{ $detailPelamar->id }}', '{{ $index }}');">
                                                    @csrf
                                                    <input type="hidden" name="id_pelamar" value="{{ $detailPelamar->id }}">
                                                    <input type="hidden" name="id_jawab" value="{{ $nilai['id_jawab'] }}">
                                                    <input type="hidden" name="index" value="{{ $index }}">
                                                    <div class="form-group">
                                                        <label for="new_answer_{{ $detailPelamar->id }}_{{ $index }}">Pilih Jawaban Baru</label>
                                                        <select class="form-control" id="new_answer_{{ $detailPelamar->id }}_{{ $index }}" name="new_answer">
                                                            @foreach(App\Models\NilaiIsi::where('id_sub', $nilai['id_sub'])->get() as $option)
                                                                <option value="{{ $option->id }}">{{ $option->keterangan_isi }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-2">Save</button>
                                                </form>
                                            </div>
                                        @else
                                            <button class="btn btn-secondary" disabled>Sudah Diverifikasi</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
function markAsDone(idPelamar, index) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('{{ route("mark-as-done") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_pelamar: idPelamar, index: index })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Kualifikasi ini sudah sesuai.');
            document.getElementById(`not-match-btn-${idPelamar}-${index}`).disabled = true;
            document.getElementById(`done-btn-${idPelamar}-${index}`).disabled = true;
        } else {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function showForm(idPelamar, index) {
    document.getElementById(`form-${idPelamar}-${index}`).style.display = 'block';
    document.getElementById(`done-btn-${idPelamar}-${index}`).disabled = true;
}

function saveValidation(idPelamar, index) {
    const form = document.getElementById(`form-update-${idPelamar}-${index}`);
    const formData = new FormData(form);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('{{ route("save-validation") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Jawaban berhasil diperbarui.');
            document.getElementById(`form-${idPelamar}-${index}`).style.display = 'none';
            document.getElementById(`not-match-btn-${idPelamar}-${index}`).disabled = true;
            document.getElementById(`done-btn-${idPelamar}-${index}`).disabled = true;
        } else {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    })
    .catch(error => console.error('Error:', error));
}

</script>
@endforeach
