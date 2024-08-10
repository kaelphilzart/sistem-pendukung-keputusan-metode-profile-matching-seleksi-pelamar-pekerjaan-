@extends('template.template_HRD')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body ">
          <h5 class="card-title text-dark">Data Lowongan</h5>
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
                <div class="col-md-3">
                    <div class="text-end mx-2">
                        <a href="#" class="text-dark btn btn-success  mb-0  px-4 mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambah-lowongan">+&nbsp; Tambah Lowongan</a>
                    </div>
                </div>
                <div class="col-md-3">
                <a href="{{ route('data-kualifikasiUmum') }}" class="btn btn-primary w-100" type="button">Kualifikasi Umum</a>
                </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>Lowongan</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th>Mulai</th>
                        <th>Berakhir</th>
                        <th class="text-center">Aksi</th>               
                    </tr>
            </thead>
            @foreach($data as $key => $dataLowongan)
            <tbody>
            <tr class="">
                       <td>{{  $data->firstItem() + $key }}</td>
                        <td>{{ $dataLowongan->lowongan }}</td>
                        <td>{{ $dataLowongan->kuota }}</td>
                        <td>{{ $dataLowongan->status }}</td>
                        <td>{{ $dataLowongan->tanggal_mulai }}</td>
                        <td>{{ $dataLowongan->tanggal_berakhir }}</td>
                        <td>
                          <form action="{{ route('delete-lowongan', $dataLowongan->id) }}" method="post">
                              @csrf
                              <div class="row mb-2">
                                  <div class="col">
                                      <a href="{{ route('syarat', ['id' => $dataLowongan->id]) }}" class="btn btn-primary w-100" type="button">Syarat</a>
                                  </div>
                                  <div class="col">
                                      <a href="{{ route('dataKualifikasi', ['id' => $dataLowongan->id]) }}" class="btn btn-dark w-100" type="button">Kualifikasi</a>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col">
                                      <a href="#" class="text-dark btn btn-warning w-100" type="button" data-bs-toggle="modal" data-bs-target="#edit-lowongan{{$dataLowongan->id}}">Edit</a>
                                  </div>
                                  <div class="col">
                                      <button class="btn btn-danger w-100" onClick="return confirm('Yakin Hapus Karyawan?')">Delete</button>
                                  </div>
                              </div>
                          </form>
                      </td>

                           </tr>
                          @include('HRD.edit-lowongan')
                   @endforeach
            </tbody>
          </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@include('HRD.tambah-lowongan')
@endsection