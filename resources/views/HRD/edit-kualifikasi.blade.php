<div class="modal fade" id="edit-kualifikasi{{$dataKualifikasi->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kualifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark">
                            <form action="{{ route('update-kualifikasi', ['id' => $dataKualifikasi->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $data2->id }}" id="id_loker" name="id_loker">
                    <div class="mb-3">
                        <div class="form-group ">
                            <label for="id_kriteria">Nama Aspek</label>
                            <select class="js-example-basic-single form-control" style="width:100%" id="id_kriteria" name="id_kriteria">
                                @foreach($data1 as $item)    
                                <option value="{{ $item->id }}" {{ $item->id == $dataKualifikasi->id_kriteria ? 'selected' : '' }}>{{ $item->nama_kriteria }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('id_kriteria')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_sub_kriteria" class="form-label">Nama Sub Kriteria</label>
                        <input type="text" class="form-control " id="nama_sub_kriteria" name="nama_sub_kriteria" value="{{ $dataKualifikasi->nama_sub_kriteria }}">
                        @error('nama_sub_kriteria')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nilai_standar" class="form-label">Nilai Standar</label>
                        <input type="number" class="form-control " id="nilai_standar" name="nilai_standar" value="{{ $dataKualifikasi->nilai_standar }}">
                        @error('nilai_standar')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-group ">
                            <label for="pengelompokan">Pengelompokan</label>
                            <select class="js-example-basic-single form-control" style="width:100%" id="pengelompokan" name="pengelompokan">
                                <option value="core factor" {{ $dataKualifikasi->pengelompokan == 'core factor' ? 'selected' : '' }}>Core Factor</option>
                                <option value="secondary factor" {{ $dataKualifikasi->pengelompokan == 'secondary factor' ? 'selected' : '' }}>Secondary Factor</option>
                            </select>
                        </div>
                        @error('pengelompokan')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-group ">
                            <label for="input_pelamar">Detail Data</label>
                            <select class="js-example-basic-single form-control" style="width:100%" id="input_pelamar" name="input_pelamar">
                                <option value="text" {{ $dataKualifikasi->input_pelamar == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="file" {{ $dataKualifikasi->input_pelamar == 'file' ? 'selected' : '' }}>Upload File</option>
                            </select>
                        </div>
                        @error('input_pelamar')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 text-dark">
                        <label for="pengelompokan">Intruksi Detail</label>
                        <textarea class="form-control" id="perintah" name="perintah" rows="4">{{ $dataKualifikasi->perintah }}</textarea>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                </form>

            </div>
        </div>
    </div>
</div>
