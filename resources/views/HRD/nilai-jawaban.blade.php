@extends('template.template_HRD')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-dark">Kualifikasi</h5>
          <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('nilai-jawaban') }}" method="GET" class="form-inline">
                        <div class="form-group mb-2">
                            <select class="form-control" id="id_loker" name="id_loker">
                                <option value="">Pilih Lowongan</option>
                                @foreach($lowongan as $data1)
                                    <option value="{{ $data1->id }}" {{ request('id_loker') == $data1->id ? 'selected' : '' }}>
                                        {{ $data1->lowongan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mx-2 mb-2">
                            <i class="bx bx-search fs-4 lh-0"></i> Filter
                        </button>
                    </form>
                </div>
                <div class="col-md-3">
                <a href="{{ route('jawaban-kualifikasiUmum') }}" class="btn btn-primary w-100" type="button">Jawaban Kualifikasi Umum</a>
                </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr class="">
                  <th>No</th>
                  <th>Lowongan Kerja</th>
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
                    <td>{{ $dataJawab->lowongan }}</td>
                    <td>{{ $dataJawab->nama_kriteria }}</td>
                    <td>{{ $dataJawab->nama_sub_kriteria }}</td>
                    <td>{{ $dataJawab->nilai_standar }}</td>
                    <td>{{ $dataJawab->pengelompokan }}</td>
                    <td>
                      <a href="{{ route('jawab', ['id' => $dataJawab->id]) }}" class="btn btn-dark w-100" type="button">Lihat Jawab</a>
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
