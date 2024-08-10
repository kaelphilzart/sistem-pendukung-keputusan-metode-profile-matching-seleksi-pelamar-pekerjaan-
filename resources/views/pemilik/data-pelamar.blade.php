@extends('template.template_pemilik')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body ">
          <h5 class="card-title text-dark">Data Pelamar</h5>
<div class="table-responsive">
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>Lowngan Kerja</th>
                        <th>Sisa Kuota</th>
                        <th>Pendaftar</th>
                        <th>Lolos</th>
                        <th>Tidak Lolos</th>
                        <th>Aksi</th>               
                    </tr>
            </thead>
            @foreach($data as $key => $dataLowongan)
            <tbody>
            <tr class="">
                       <td>{{  $data->firstItem() + $key }}</td>
                        <td>{{ $dataLowongan->lowongan }}</td>
                        <td>{{ $dataLowongan->kuota }}</td>
                        <td>{{ $dataLowongan->pendaftar }}</td>
                        <td>{{ $dataLowongan->lolos }}</td>
                        <td>{{ $dataLowongan->tidak_lolos }}</td>
                        <td>
                      
                       <a href="{{route('detail-seleksi', ['id' => $dataLowongan->id] )}}" class="text-dark btn btn-info  px-4" type="button">Lihat Pelamar</a>
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