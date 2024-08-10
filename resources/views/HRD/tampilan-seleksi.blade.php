@extends('template.template_HRD')

@section('content')
<div class="container mb-2">
    <div class="card">
        <div class="card-body">
            <h4 class="text-center text-dark fw-bold">
            Hasil Seleksi Lowongan Kerja {{$hasilLoker->lowongan}}
            </h4>
        </div>
    </div>
</div>
<div class="container" id="set2">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
<!-- @if(count($pelamarData) > 0) -->
                    <h4 class="text-center py-4 text-dark">Pemetaan Gap Profile</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="border-top: black solid 1px;">
                        <thead>
                                <tr class="text-center">
                                    <th rowspan="2">NO</th>
                                    <th rowspan="2">NAMA</th>
                                    @if(count($pelamarData) > 0)
                                        @php
                                            // Mengelompokkan data berdasarkan nama_kriteria
                                            $groupedCriteria = [];
                                            foreach ($pelamarData[0]['jawab'] as $jawab) {
                                                if (!isset($groupedCriteria[$jawab['nama_kriteria']])) {
                                                    $groupedCriteria[$jawab['nama_kriteria']] = [];
                                                }
                                                $groupedCriteria[$jawab['nama_kriteria']][] = $jawab['nama_kualifikasi'];
                                            }
                                        @endphp
                                        @foreach($groupedCriteria as $nama_kriteria => $kualifikasis)
                                            <th colspan="{{ count($kualifikasis) }}">{{ $nama_kriteria }}</th>
                                        @endforeach
                                    @endif
                                </tr>
                                <tr>
                                    @if(count($pelamarData) > 0)
                                        @foreach($groupedCriteria as $kualifikasis)
                                            @foreach($kualifikasis as $kualifikasi)
                                                <th class="text-wrap align-middle">{{ $kualifikasi }}</th>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($pelamarData as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['nama_lengkap'] }}</td>
                                    @foreach($item['jawab'] as $jawab)
                                    <td>{{ $jawab['nilai_isi'] }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                                <tr class="table-warning text-dark">
                                    <th colspan="2">NILAI STANDAR</th>
                                    @foreach($item['jawab'] as $jawab)
                                    <td>{{ $jawab['nilai_standar'] }}</td>
                                    @endforeach
                                </tr>
                                @foreach($pelamarData as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['nama_lengkap'] }}</td>
                                    @foreach($item['jawab'] as $jawab)
                                    <td>{{ $jawab['gap_selisih'] }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h4 class="text-center py-4 text-dark">Konversi Nilai Bobot</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="border-top: black solid 1px;">
                        <thead>
                                <tr class="text-center">
                                    <th rowspan="2">NO</th>
                                    <th rowspan="2">NAMA</th>
                                    @if(count($pelamarData) > 0)
                                        @php
                                            // Mengelompokkan data berdasarkan nama_kriteria
                                            $groupedCriteria = [];
                                            foreach ($pelamarData[0]['jawab'] as $jawab) {
                                                if (!isset($groupedCriteria[$jawab['nama_kriteria']])) {
                                                    $groupedCriteria[$jawab['nama_kriteria']] = [];
                                                }
                                                $groupedCriteria[$jawab['nama_kriteria']][] = $jawab['nama_kualifikasi'];
                                            }
                                        @endphp
                                        @foreach($groupedCriteria as $nama_kriteria => $kualifikasis)
                                            <th colspan="{{ count($kualifikasis) }}">{{ $nama_kriteria }}</th>
                                        @endforeach
                                    @endif
                                </tr>
                                <tr>
                                    @if(count($pelamarData) > 0)
                                        @foreach($groupedCriteria as $kualifikasis)
                                            @foreach($kualifikasis as $kualifikasi)
                                                <th class="text-wrap align-middle">{{ $kualifikasi }}</th>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pelamarData as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['nama_lengkap'] }}</td>
                                    @foreach($item['jawab'] as $jawab)
                                    <td>{{ $jawab['gap_selisih'] }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                                <tr class="table-success text-dark">
                                    <th colspan="12 text-center">Konversi Nilai Gap</th>
                                </tr>
                                @foreach($pelamarData as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['nama_lengkap'] }}</td>
                                    @foreach($item['jawab'] as $jawab)
                                    <td>{{ $jawab['nilai_gap'] }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h4 class="text-center py-4 text-dark">Pengelompokan Aspek Core Factor dan Secondary Factor</h4>
                    @foreach($pelamarData as $index => $item)
                        <h4 class="text-center mt-4 text-dark">Nama Pelamar: {{ $item['nama_lengkap'] }}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="border-top: black solid 1px;">
                                <thead>
                                    <tr>
                                        <th>Aspek</th>
                                        <th>Kualifikasi</th>
                                        <th>Pengelompokan</th>
                                        <th>Nilai Gap</th>
                                        <th>NCF</th>
                                        <th>NSF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item['kelompok'] as $nama_kriteria => $kelompok)
                                        <tr>
                                            <td class="fw-bold" rowspan="{{ count($kelompok['items']) + 1 }}">{{ $nama_kriteria }}</td>
                                        </tr>
                                        @php $shownNCFNSF = false; @endphp
                                        @foreach($kelompok['items'] as $jawab)
                                            <tr>
                                                <td class="text-wrap">{{ $jawab['nama_kualifikasi'] }}</td>
                                                <td>{{ $jawab['pengelompokan'] }}</td>
                                                <td>{{ $jawab['nilai_gap'] }}</td>
                                                @if (!$shownNCFNSF)
                                                    <td rowspan="{{ count($kelompok['items']) }}">{{ $kelompok['ncf'] }}</td>
                                                    <td rowspan="{{ count($kelompok['items']) }}">{{ $kelompok['nsf'] }}</td>
                                                    @php $shownNCFNSF = true; @endphp
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach

                    <h4 class="text-center py-4 text-dark">Nilai Total Per Aspek</h4>
                    @foreach($pelamarData as $index => $item)
                        <h4 class="text-center mt-4 text-dark">Nama Pelamar: {{ $item['nama_lengkap'] }}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="border-top: black solid 1px;">
                                <thead>
                                    <tr>
                                        <th>Aspek</th>
                                        <th>NCF</th>
                                        <th>NSF</th>
                                        <th>Rumus</th>
                                        <th>Nilai Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item['kelompok'] as $nama_kriteria => $kelompok)
                                        <tr>
                                            <td class="fw-bold">{{ $nama_kriteria }}</td>
                                            <td>{{ $kelompok['ncf'] }}</td>
                                            <td>{{ $kelompok['nsf'] }}</td>
                                            <td>{{ $kelompok['ncf'] }} X 0.6 + {{ $kelompok['nsf'] }} X 0.4</td>
                                            <td>{{ $kelompok['ntk'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach

                    <h4 class="text-center py-4 text-dark">Hasil Akhir</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="border-top: black solid 1px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    @if(count($pelamarData) > 0)
                                        @php
                                            // Mengelompokkan data berdasarkan nama_kriteria
                                            $groupedCriteria = [];
                                            foreach ($pelamarData[0]['jawab'] as $jawab) {
                                                if (!isset($groupedCriteria[$jawab['nama_kriteria']])) {
                                                    $groupedCriteria[$jawab['nama_kriteria']] = [];
                                                }
                                                $groupedCriteria[$jawab['nama_kriteria']][] = $jawab['nama_kualifikasi'];
                                            }
                                        @endphp
                                        @foreach($groupedCriteria as $nama_kriteria => $kualifikasis)
                                            <th>{{ $nama_kriteria }}</th>
                                        @endforeach
                                    @endif
                                    <th>Hasil Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pelamarData as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['nama_lengkap'] }}</td>
                                    @foreach($item['kelompok'] as $nama_kriteria => $kelompok)
                                    <td>{{ $kelompok['ntk'] }} X {{ $kelompok['persentase'] }}</td>
                                    @endforeach
                                    <td>{{ $item['hasil_akhir'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h4 class="text-center py-4 text-dark">Hasil Perangkingan</h4>
                    <div class="table-responsive">
                    <table class="table table-bordered" style="border-top: black solid 1px;">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Hasil Akhir</th>
                                    <th>Status</th>
                                    <th>Rangking</th>
                                    <th>Informasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Mengurutkan data berdasarkan hasil_akhir secara descending
                                    $sortedPelamarData = collect($pelamarData)->sortByDesc('hasil_akhir')->values()->all();
                                @endphp
                                @foreach($sortedPelamarData as $index => $item)
                                <tr>
                                    <td>{{ $item['nama_lengkap'] }}</td>
                                    <td>{{ $item['hasil_akhir'] }}</td>
                                    <td>{{ $item['status'] }}</td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($item['status_awal'] == 'proses')
                                        <a href="#" class="text-dark btn btn-warning px-4" type="button" data-bs-toggle="modal" data-bs-target="#tgl-wawancara">Kirim Pesan</a>
                                        @else
                                        <button type="submit" class="btn btn-success text-center" disabled>Selesai dikirim</button>
                                        @endif
                                    </td>
                                </tr>
                                @include('HRD.tgl-wawancara')
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- <div class="col-md-12 text-center p-4">
                        <form action="{{ route('kirim-pesan') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_lowongan" value="{{ $id_low }}">
                            @foreach($pelamarData as $item)
                            <input type="hidden" name="pelamarData[]" value="{{ json_encode($item) }}">
                            @endforeach
                            <button type="submit" class="btn btn-primary">Send Information</button>
                        </form>
                    </div> -->
<!-- @else 
        <div class="text-dark text-center">
    <h2>Selesai</h2>
    <h4>Pada Lowongan ini penyeleksian telah dilakukan</h4>
    
    </div>
@endif -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    document.getElementById('startButton').addEventListener('click', function() {
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghitung...').prop('disabled', true);
        setTimeout(function() {
            document.getElementById('set1').style.display = 'none';
            document.getElementById('set2').style.display = 'block';
        }, 2000); // Simulate a delay for the loading spinner (2 seconds)
    });
</script>
<script>
    function addBreaksToText(elementId, maxLength) {
        const element = document.getElementById(elementId);
        const text = element.innerText;

        if (text.length > maxLength) {
            const newText = text.match(new RegExp('.{1,' + maxLength + '}', 'g')).join('<br>');
            element.innerHTML = newText;
        }
    }

    // Tambahkan <br> jika teks panjangnya lebih dari 50 karakter
    addBreaksToText('longText', 50);
</script>
@endsection
