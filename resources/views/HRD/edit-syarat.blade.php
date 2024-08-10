<div class="modal fade" id="edit-syarat{{$dataSyarat->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Nilai Jawaban</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-syarat', ['id' => $dataSyarat->id]) }}" method="POST">
                    @csrf
                    <input type="text" value="{{$dataSyarat->id_loker}}"  id="id_Loker" name="id_loker" hidden >
                    <div class="mb-3">
                        <label for="syarat" class="form-label">Syarat</label>
                        <input type="text" class="form-control text-white" id="syarat" name="syarat" value="{{$dataSyarat->syarat}}">
                        @error('syarat')
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
