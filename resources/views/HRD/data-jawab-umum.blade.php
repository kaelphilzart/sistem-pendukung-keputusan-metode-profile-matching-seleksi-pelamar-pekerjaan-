@extends('template.template_HRD')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body ">
          <h5 class="card-title text-dark">Data Jawab</h5>
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
                   @include('HRD.tambah-jawab')
                        <a href="#" class="text-dark btn btn-success  mb-0  px-4 mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambah-jawab">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
        <div class="col-md-12 text-dark text-center" style="text-transform: uppercase; font-weight: bold;">
            Kualifikasi :  {{$data1->nama_sub_kriteria}}
          </div>
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>Keterangan Jawaban</th>
                        <th>Nilai</th>
                        <th>Aksi</th>               
                    </tr>
            </thead>
            @foreach($data as $key => $dataJawab)
            <tbody>
            <tr class="">
                       <td>{{  $data->firstItem() + $key }}</td>
                        <td>{{ $dataJawab->keterangan_isi }}</td>
                        <td>{{ $dataJawab->nilai_isi }}</td>
                        <td>
                        <form action="{{ route('delete-jawab', $dataJawab->id) }}" method="post">@csrf
                       <a href="#" class="text-dark btn btn-warning  px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-jawab{{$dataJawab->id}}">Edit</a>
                    <button class="btn btn-danger px-3" onClick="return confirm('Yakin Hapus Jawaban?')">Delete</button>
                    </form>
                        </td>
                           </tr>
                          @include('HRD.edit-jawab')
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