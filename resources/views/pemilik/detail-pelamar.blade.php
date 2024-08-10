@extends('template.template_pemilik')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body ">
          <h5 class="card-title text-dark">Data Pelamar</h5>
        <div class="table-responsive">
        <div class="col-md-12 text-dark text-center" style="text-transform: uppercase; font-weight: bold;">
              {{$data1->lowongan}}
          </div>
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>Nama Pelamar</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th>Waktu</th>
                        <th>Kualifikasi</th>    
                        <th>Status</th>               
                    </tr>
            </thead>
            @foreach($data as $key => $detailPelamar)
            <tbody>
            <tr class="">
                       <td>{{  $data->firstItem() + $key }}</td>
                        <td>{{ $detailPelamar->nama_pelamar }}</td>
                        <td>{{ $detailPelamar->alamat }}</td>
                        <td>{{ $detailPelamar->no_hp }}</td>
                        <td>{{ $detailPelamar->created_at->format('d-m-Y') }}</td>
                        <td>
                       
                       <a href="#" class="text-dark btn btn-warning  px-4" type="button" data-bs-toggle="modal" data-bs-target="#jawaban-pelamar{{$detailPelamar->id}}">Detail</a>
                        </td>
                        <td>{{ $detailPelamar->status }}</td>
                           </tr>
                        @include('HRD.jawaban-pelamar')
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