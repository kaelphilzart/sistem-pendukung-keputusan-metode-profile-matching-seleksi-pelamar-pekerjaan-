@extends('template.template_HRD')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body ">
          <h5 class="card-title text-dark">Data Kriteria</h5>
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
                <div class="col-md-6">
                    <div class="text-end mx-2">
                   @include('HRD.tambah-kriteria')
                        <a href="#" class="text-dark btn btn-success  mb-0  px-4 mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambah-kriteria">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>Nama Kriteria</th>
                        <th>Kode</th>
                        <th>persentase</th>
                        <th>Aksi</th>               
                    </tr>
            </thead>
            @foreach($data as $key => $dataKriteria)
            <tbody>
            <tr class="">
                       <td>{{  $data->firstItem() + $key }}</td>
                        <td>{{ $dataKriteria->nama_kriteria }}</td>
                        <td>{{ $dataKriteria->kode }}</td>
                        <td>{{ $dataKriteria->persentase }} %</td>
                        <td>
                        <form action="{{route('delete-kriteria', $dataKriteria->id)}}" method="post">@csrf
                       <a href="#" class="text-dark btn btn-warning  px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-kriteria{{$dataKriteria->id}}">Edit</a>
                    <button class="btn btn-danger px-3" onClick="return confirm('Yakin Hapus Kriteria?')">Delete</button>
                    </form>
                        </td>
                           </tr>
                          @include('HRD.edit-kriteria')
                   @endforeach
            </tbody>
          </table>
        </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection