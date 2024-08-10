@extends('template.template_pemilik')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body ">
          <h5 class="card-title text-dark">Hasil Seleksi Perlowongan</h5>
<div class="table-responsive">
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>Lowongan Kerja</th>
                        <th>Pelamar</th>
                        <th>Aksi</th>               
                    </tr>
            </thead>
            @foreach($data as $key => $dataLowongan)
            <tbody>
            <tr class="">
                       <td>{{  $data->firstItem() + $key }}</td>
                        <td>{{ $dataLowongan->lowongan }}</td>
                        <td>{{ $dataLowongan->pendaftar }}</td>
                        <td>
                    
                        <a href="{{route('riwayat', ['id' => $dataLowongan->id] )}}" class="text-dark btn btn-warning px-4" type="button">Lihat Hasil Seleksi</a>
                        </td>
                           </tr>
                         
                   @endforeach
            </tbody>
          </table>
                  <div class="pagination py-2 px-2">
            <div class="d-flex justify-content-center align-items-center">
             
                {{ $data->links('pagination::bootstrap-4') }}
            </div>
        </div>
          </div>
          </div>
      </div>

    </div>
  </div>
</div>
@endsection