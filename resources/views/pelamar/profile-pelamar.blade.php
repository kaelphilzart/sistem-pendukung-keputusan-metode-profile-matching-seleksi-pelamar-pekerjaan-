@extends('template.template_pelamar')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg" style="background-color: #EEEDEB;">
        <div class="row no-gutters">
            <div class="col-md-4 py-4 px-2">
                <img src="{{ $pelamar->foto }}" class="card-img px-3" style="object-fit: cover; height: 100%;" alt="Foto Pelamar">
            </div>
            <div class="col-md-8">
                <h5 class="card-title text-center mt-4" style="color: #2F3645;"><b>MY PROFILE</b></h5>
                <div class="row">
                        <div class="text-black mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama Lengkap</strong></p>
                                    <p><strong>Alamat</strong></p>
                                    <p><strong>Tempat Lahir</strong></p>
                                    <p><strong>Tanggal Lahir</strong></p>
                                    <p><strong>No Hp</strong></p>
                                    <p><strong>Email</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $pelamar->nama_lengkap }}</p>
                                    <p>{{ $pelamar->alamat }}</p>
                                    <p>{{ $pelamar->tempat_lahir }}</p>
                                    <p>{{ $pelamar->tanggal_lahir }}</p>
                                    <p>{{ $pelamar->no_hp }}</p>
                                    <p>{{ $pelamar->email }}</p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
