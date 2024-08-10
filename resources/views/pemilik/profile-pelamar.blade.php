<div class="modal fade" id="profile-pelamar{{$dataPelamar->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">{{$dataPelamar->nama_lengkap}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                <div class="col-md-4">
                <img src="{{$dataPelamar->foto}}" class="card-img px-3" style="object-fit: cover; height: 100%;" alt="Foto Pelamar">
                </div>
                <div class="col-md-8">
                    <div class="row text-dark">
                        <div class="col-md-6">
                            <p>Nama Lengkap</p>
                            <p>Alamat</p>
                            <p>Tempat Lahir</p>
                            <p>Tanggal Lahir</p>
                            <p>Kontak</p>
                            <p>Register</p>
                        </div>
                        <div class="col-md-6">
                            <p>: {{$dataPelamar->nama_lengkap}}</p>
                            <p>: {{$dataPelamar->alamat}}</p>
                            <p>: {{$dataPelamar->tempat_lahir}}</p>
                            <p>: {{$dataPelamar->tanggal_lahir}}</p>
                            <p>: {{$dataPelamar->no_hp}}</p>
                            <p>: {{ $dataPelamar->created_at->format('d-m-Y') }}</p>
                        </div>
                    </div>
                </div>
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
