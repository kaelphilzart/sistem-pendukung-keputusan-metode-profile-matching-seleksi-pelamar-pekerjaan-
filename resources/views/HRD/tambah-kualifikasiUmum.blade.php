<div class="modal fade" id="tambah-kualifikasiUmum" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kualifikasi Umum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('tambah-kualifikasiUmum')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                            <div class="form-group text-dark">
                                <label for="id_kriteria">Nama Aspek</label>
                                <select class="js-example-basic-single form-control" style="width:100%" id="id_kriteria" name="id_kriteria">
                                @foreach($data1 as $data1)
                                    <option value="{{$data1->id}}">{{$data1->nama_kriteria}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_kriteria')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    <div class="mb-3 text-dark">
                        <label for="nama_sub_kriteria " class="form-label">Nama Kualifikasi</label>
                        <input type="text" class="form-control text-dark" id="nama_sub_kriteria" name="nama_sub_kriteria">
                        @error('nama_sub_kriteria')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3 text-dark">
                        <label for="nilai_standar" class="form-label">Nilai Standar</label>
                        <input type="number" class="form-control text-dark" id="nilai_standar" name="nilai_standar">
                        @error('nilai_standar')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                            <div class="form-group text-dark">
                                <label for="pengelompokan">Pengelompokan</label>
                                <select class="js-example-basic-single form-control" style="width:100%" id="pengelompokan" name="pengelompokan">
                                    <option value="core factor">Core Factor</option>
                                    <option value="secondary factor">Secondary Factor</option>
                                </select>
                            </div>
                            @error('pengelompokan')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-group text-dark">
                                <label for="pengelompokan">Detail Data</label>
                                <select class="js-example-basic-single form-control" style="width:100%" id="input_pelamar" name="input_pelamar">
                                <option value="0">Tidak Ada</option>
                                    <option value="text">Text</option>
                                    <option value="file">Upload File</option>
                                </select>
                            </div>
                            @error('input_pelamar')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3 text-dark">
                        <label for="pengelompokan">Intruksi Detail</label>
                        <textarea class="form-control" id="perintah" name="perintah" rows="4"></textarea>
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
