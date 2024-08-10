@extends('template.template_pelamar')

@section('content')
<div class="container text-white">
    <div class="text-center mt-4">
        <h2 style="font-weight: bold; " class="text-white">LOWONGAN KERJA</h2>
        <h5 class="mt-2 text-white">Sistem Pendukung Keputusan Rekrutmen Karyawan</h5>
    </div>
    <div class="row mt-4">
        @foreach($dataLowongan as $key => $lowongan)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card" style="background-color: #EEEDEB; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ $lowongan->lowongan }}
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Kuota: {{ $lowongan->kuota }}</h6>
                        <p>Dari {{$lowongan->tanggal_mulai}} sampai {{$lowongan->tanggal_berakhir}}</p>
                        <p class="card-text">
                            <strong>Syarat:</strong>
                            <ul>
                                @foreach($dataSyarat as $syarat)
                                    @if($syarat->id_loker == $lowongan->id)
                                        <li>{{ $syarat->syarat }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </p>
                        @if($lowongan->kuota > 0)
                            @if($sudahMelamar)
                                <button class="btn btn-dark px-4" type="button" disabled>Lamar</button>
                            @else
                                <a href="{{ route('kualifikasi', ['id' => $lowongan->id]) }}" class="btn btn-dark px-4">Lamar</a>
                            @endif
                        @else
                            <button class="btn btn-dark px-4" type="button" disabled>Full</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
