<div class="modal fade" id="tambah-lowongan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Tambah Lowongan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark">
                <form action="{{route('tambah-lowongan')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="lowongan" class="form-label">Nama Lowongan</label>
                        <input type="text" class="form-control" id="lowongan" name="lowongan">
                        @error('lowongan')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                    <label for="kuota" class="form-label">Kuota</label>
                    <input type="text" class="form-control" id="kuota" name="kuota">
                        @error('kuota')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status" value="aktif">
                        <label class="form-check-label text-dark" for="status">
                            Aktif
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status" value="Tidak Aktif">
                        <label class="form-check-label text-dark" for="status">
                            Tidak Aktif
                        </label>
                    </div>
                    @error('status')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3 text-dark">
                    <label for="tanggal_mulai" class="form-label">Mulai</label>
                    <input type="date" class="form-control text-dark" id="tanggal_mulai" name="tanggal_mulai">
                        @error('tanggal_mulai')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3 text-dark">
                    <label for="tanggal_berakhir" class="form-label">Tutup</label>
                    <input type="date" class="form-control text-dark" id="tanggal_berakhir" name="tanggal_berakhir">
                        @error('tanggal_berakhir')
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
