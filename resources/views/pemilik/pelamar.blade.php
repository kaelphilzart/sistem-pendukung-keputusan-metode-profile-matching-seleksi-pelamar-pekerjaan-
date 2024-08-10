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
                        <th>Nama Pelamar</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th>Aksi</th>               
                    </tr>
            </thead>
            @foreach($data as $key => $dataPelamar)
            <tbody>
            <tr class="">
                       <td>{{  $data->firstItem() + $key }}</td>
                        <td>{{ $dataPelamar->nama_lengkap }}</td>
                        <td>{{ $dataPelamar->alamat }}</td>
                        <td>{{ $dataPelamar->no_hp }}</td>
                        <td>
                        <a href="#" class="text-dark btn btn-warning  px-4" type="button" data-bs-toggle="modal" data-bs-target="#profile-pelamar{{$dataPelamar->id}}">Profile</a>
                        </td>
                           </tr>
                           @include('pemilik.profile-pelamar')
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