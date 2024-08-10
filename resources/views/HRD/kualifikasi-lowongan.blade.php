@extends('template.template_HRD')

@section('content')
<div class="container ">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body ">
          <h5 class="card-title text-dark">Data Kualifikasi</h5>
          <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <form action="##" method="GET">
                            <label>
                            <input type="search" name="q"  class="form-control" placeholder="Search ">
                            </label>
                            <button type="submit" class="mx-2 btn btn-primary ">
                            <i class="bx bx-search fs-4 lh-0"></i> Cari</button>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <div class="text-end mx-2">
                   @include('HRD.tambah-kualifikasi')
                        <a href="#" class="text-dark btn btn-success  mb-0  px-4 mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambah-kualifikasi">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
        <div class="col-md-12 text-dark text-center" style="text-transform: uppercase; font-weight: bold;">
              {{$data2->lowongan}}
          </div>
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>Nama Aspek</th>
                        <th>Kualifikasi</th>
                        <th>Nilai Standar</th>
                        <th>Pengelompokan</th>
                        <th>Jenis</th>
                        <th>Aksi</th>               
                    </tr>
            </thead>
            @foreach($data as $key => $dataKualifikasi)
            <tbody>
            <tr class="">
                       <td>{{  $data->firstItem() + $key }}</td>
                        <td>{{ $dataKualifikasi->nama_aspek }}</td>
                        <td>{{ $dataKualifikasi->nama_sub_kriteria }}</td>
                        <td>{{ $dataKualifikasi->nilai_standar }}</td>
                        <td>{{ $dataKualifikasi->pengelompokan }}</td>
                        <td>{{ $dataKualifikasi->input_pelamar }}</td>
                        <td>
                        <a href="#" class="btn btn-link mb-1" data-bs-toggle="modal" data-bs-target="#detailModal{{$dataKualifikasi->id}}">Lihat Perintah</a>
                            <!-- Modal -->
                            <div class="modal fade" id="detailModal{{$dataKualifikasi->id}}" tabindex="-1" aria-labelledby="detailModalLabel{{$dataKualifikasi->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel{{$dataKualifikasi->id}}">Detail Perintah</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $dataKualifikasi->perintah }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <form action="{{ route('delete-kualifikasi', $dataKualifikasi->id) }}" method="post">@csrf
                       <a href="#" class="text-dark btn btn-warning  px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-kualifikasi{{$dataKualifikasi->id}}">Edit</a>
                    <button class="btn btn-danger px-3" onClick="return confirm('Yakin Hapus kualifikasi?')">Delete</button>
                    </form>
                        </td>
                           </tr>
                          @include('HRD.edit-kualifikasi')
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