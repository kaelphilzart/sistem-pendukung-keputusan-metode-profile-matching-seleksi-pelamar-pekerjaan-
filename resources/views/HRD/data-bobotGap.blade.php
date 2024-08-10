@extends('template.template_HRD')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body ">
          <h5 class="card-title text-dark">Data Bobot Gap</h5>
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
                   @include('HRD.tambah-bobotGap')
                        <a href="#" class="text-dark btn btn-success  mb-0  px-4 mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambah-bobotGap">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>selisih</th>
                        <th>Nilai Gap</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>               
                    </tr>
            </thead>
            @foreach($data as $key => $dataBobotGap)
            <tbody>
            <tr class="">
                       <td>{{  $data->firstItem() + $key }}</td>
                        <td>{{ $dataBobotGap->selisih }}</td>
                        <td>{{ $dataBobotGap->nilai_gap }}</td>
                        <td>{{ $dataBobotGap->keterangan_gap }}</td>
                        <td>
                        <form action="{{route('delete-bobotGap', $dataBobotGap->id)}}" method="post">@csrf
                       <a href="#" class="text-dark btn btn-warning  px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-bobotGap{{$dataBobotGap->id}}">Edit</a>
                    <button class="btn btn-danger px-3" onClick="return confirm('Yakin Hapus ?')">Delete</button>
                    </form>
                        </td>
                           </tr>
                          @include('HRD.edit-bobotGap')
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