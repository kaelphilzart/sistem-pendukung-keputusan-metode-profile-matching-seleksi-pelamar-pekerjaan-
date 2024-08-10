<div class="modal fade" id="edit-jawab{{$dataJawab->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit jawab</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-jawab', ['id' => $dataJawab->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $data1->id }}" id="id_sub" name="id_sub">
                    <div class="mb-3 text-dark">
                        <label for="keterangan_isi" class="form-label">Keterangan Jawaban</label>
                        <input type="text" class="form-control text-dark " id="keterangan_isi" name="keterangan_isi" value="{{ $dataJawab->keterangan_isi }}">
                        @error('keterangan_isi')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 text-dark">
                        <label for="nilai_isi" class="form-label">Nilai Jawab</label>
                        <input type="number" class="form-control text-dark" id="nilai_isi" name="nilai_isi" value="{{ $dataJawab->nilai_isi }}">
                        @error('nilai_isi')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                </form>

            </div>
        </div>
    </div>
</div>
