@extends('template.template_HRD')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-dark">Kualifikasi</h5>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr class="">
                  <th>No</th>
                  <th>Aspek</th>
                  <th>Kualifikasi</th>
                  <th>Nilai Standar</th>
                  <th>Pengelompokan</th>
                  <th>Aksi</th>               
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key => $dataJawab)
                  <tr class="">
                    <td>{{ $data->firstItem() + $key }}</td>
                    <td>{{ $dataJawab->kriteria->nama_kriteria }}</td>
                    <td>{{ $dataJawab->nama_sub_kriteria }}</td>
                    <td>{{ $dataJawab->nilai_standar }}</td>
                    <td>{{ $dataJawab->pengelompokan }}</td>
                    <td>
                      <a href="{{ route('jawab-umum', ['id' => $dataJawab->id]) }}" class="btn btn-dark w-100" type="button">Lihat Jawab</a>
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
