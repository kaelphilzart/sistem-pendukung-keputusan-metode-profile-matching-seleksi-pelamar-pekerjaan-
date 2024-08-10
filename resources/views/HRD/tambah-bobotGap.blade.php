<div class="modal fade" id="tambah-bobotGap" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Bobot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('tambah-bobotGap')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                    <label for="selisih" class="form-label">Selisih</label>
                    <input type="number" class="form-control text-white" id="selisih" name="selisih"step="0.01" min="-100">
                        @error('selisih')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nilai_gap" class="form-label">Nilai Gap</label>
                        <input type="number" class="form-control text-white" id="nilai_gap" name="nilai_gap" step="0.01" min="-100">
                        @error('nilai_gap')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan_gap" class="form-label">Keterangan Gap</label>
                        <input type="text" class="form-control text-white" id="keterangan_gap" name="keterangan_gap">
                        @error('keterangan_gap')
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
