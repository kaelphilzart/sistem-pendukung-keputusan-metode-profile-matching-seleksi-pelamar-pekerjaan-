<div class="modal fade" id="edit-kriteria{{$dataKriteria->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-kriteria', ['id' => $dataKriteria->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" class="form-control text-white" id="nama_kriteria" name="nama_kriteria" value="{{ $dataKriteria->nama_kriteria }}">
                        @error('nama_kriteria')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                    <label for="kode" class="form-label">Kode</label>
                    <input type="text" class="form-control text-white" id="kode" name="kode" value="{{$dataKriteria->kode}}">
                        @error('kode')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                    <label for="kode" class="form-label">Persentase</label>
                    <input type="text" class="form-control text-white" id="persentase" name="persentase" value="{{$dataKriteria->persentase}}">
                        @error('persentase')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
