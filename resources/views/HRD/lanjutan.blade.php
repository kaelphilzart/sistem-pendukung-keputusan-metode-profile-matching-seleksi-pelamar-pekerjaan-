@extends('template.template_HRD')

@section('content')

<section class="section">
    
    <!-- Tombol "Start" -->
    <div id="startContainer" class="container d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="card-body text-center">
                <div class="col-md-12 p-4 mt-4 text-dark">
                    <h3 class="mt-2" style="font-weight: bold;" id="label">Sistem Pendukung Keputusan Rekrutmen Karyawan</h3>
                </div>
                <div class="">
                    <button id="startButton" class="text-dark btn btn-info btn-lg" style="font-weight: bold;" type="button">Start</button>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Container untuk menampilkan hasil -->
    <div id="resultContainer" class="container" style="display:none;">
        <div class="col-md-12 text-center text-dark">
            <h2 style="font-weight: bold;">Rangking</h2>
            <h5 class="mt-2">Sistem Pendukung Keputusan Rekrutmen Karyawan</h5>
            <h5 id="lowonganTitle"></h5>
        </div>
            <div class="col-lg-12 text-center"> 
                <div class="card">
                    <div class="card-body">
                        <table id="jobsTable" class="table"> 
                            <thead>
                                <tr>
                                    <th>Nama Pelamar</th>
                                    <th>Nilai</th>
                                    <th>Rangking</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="jobsTableBody" class="text-dark"> 
                            </tbody>
                            @include('HRD.tgl-wawancara')
                        </table>
                    </div>
                </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // Event listener untuk tombol "Start"
    $('#startButton').click(function(){
        // Tampilkan loading
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghitung...').prop('disabled', true);

        // Panggil AJAX untuk mengambil data lowongan kerja
        var currentUrl = window.location.pathname;
        // Mencari bagian dari URL yang berisi ID
        var id = currentUrl.split('/').pop();

        // Panggil AJAX untuk mengambil data hasil
        $.ajax({
            url: '/hasil-spk/' + id,
            type: 'GET',
            beforeSend: function() {
                // Hilangkan kelas vh-100 dari div utama
            },
            success: function(response){
                // Simulasikan penundaan loading selama 3 detik
                setTimeout(function() {
                    // Sembunyikan tombol "Start" dan tampilkan hasil
                    $('#resultContainer').show();
                    $('#startContainer').hide(); // Sembunyikan container awal setelah hasil ditampilkan
                    $('#startButton').hide();
                    $('#label').hide();

                    // Kosongkan tabel
                    $('#lowonganTitle').text(response.data1.lowongan);
                    $('#jobsTableBody').empty();

                    // Masukkan data hasil ke dalam tabel
                    $.each(response.data, function(index, result){
                        var row = '<tr class="text-dark">' +
                                    '<td>' + result.nama_lengkap + '</td>' +
                                    '<td>' + result.nilai + '</td>' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' +
                                        '<form action="{{ route('gagal-pengumuman') }}" method="POST" class="d-inline">' +
                                            '@csrf' +
                                            '<input type="hidden" name="id_hasil" value="' + result.id + '">' +
                                            '<input type="hidden" name="id_lamar" value="' + result.id_lamar + '">' +
                                            '<input type="hidden" name="status" value="tidak lolos">' +
                                            '<button type="submit" class="btn btn-danger rejectButton mx-2">Tidak Lolos</button>' +
                                        '</form>' +
                                        '<button class="btn btn-success acceptButton mx-2" data-id="' + result.id + '" data-lamar="' + result.id_lamar + '" data-bs-toggle="modal" data-bs-target="#tgl-wawancara">Lolos</button>' +
                                    '</td>' +
                                  '</tr>';
                        $('#jobsTableBody').append(row);
                    });

                    $('.acceptButton').click(function() {
                        var id_hasil = $(this).data('id');
                        var id_lamar = $(this).data('lamar');
                        $('#id_hasil').val(id_hasil);  // Set the value of id_hasil in the modal form
                        $('#id_lamar').val(id_lamar);  // Set the value of id_lamar in the modal form
                    });
                }, 3000);
            },
            error: function(xhr, status, error){
                console.error("Terjadi kesalahan: " + error);
            }
        });
    });
});
</script>

@endsection
