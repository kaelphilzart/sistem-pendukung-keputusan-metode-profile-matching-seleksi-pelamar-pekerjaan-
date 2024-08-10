@extends('template.template_HRD')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body ">
          <h5 class="card-title text-dark">Data Syarat</h5>
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
                   @include('HRD.tambah-syarat')
                        <a href="#" class="text-dark btn btn-success  mb-0  px-4 mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambah-syarat">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
        <div class="col-md-12 text-dark text-center" style="text-transform: uppercase; font-weight: bold;">
              {{$data1->lowongan}}
          </div>
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>Syarat</th>
                        <th>Aksi</th>               
                    </tr>
            </thead>
            @foreach($data as $key => $dataSyarat)
            <tbody>
            <tr class="">
                       <td>{{  $data->firstItem() + $key }}</td>
                        <td>{{ $dataSyarat->syarat }}</td>
                        <td>
                        <form action="{{ route('delete-syarat', $dataSyarat->id) }}" method="post">@csrf
                       <a href="#" class="text-dark btn btn-warning  px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-syarat{{$dataSyarat->id}}">Edit</a>
                    <button class="btn btn-danger px-3" onClick="return confirm('Yakin Hapus Syarat?')">Delete</button>
                    </form>
                        </td>
                           </tr>
                          @include('HRD.edit-syarat')
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