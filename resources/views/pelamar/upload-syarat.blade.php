<div class="modal fade" id="upload-syarat{{$dataLowongan->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Persyaratan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('lamar-lowongan')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 d-none">
                        <input type="text" class="form-control" id="id_lowongan" name="id_lowongan" value="{{ $dataLowongan->id }}">
                        @error('id_lowongan')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="form-group row">
                        <label for="file_syarat" class="col-sm-3 col-form-label">File Syarat</label>
                        <div class="col-sm-9">
                        <input class="form-control" type="file" id="file_syarat" name="file_syarat">
                    @error('file_syarat')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                        </div>
                      </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
