@extends('template.template_pelamar')

@section('content')
<div class="container">
    <div class="text-center py-4">
        <h3 class="text-white">Kualifikasi Karyawan</h3>
    </div>
    <form action="{{ route('lamar-loker') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" value="{{ $data2->id }}" hidden id="id_lowongan" name="id_lowongan">

        <div class="row">
            @foreach($data as $key => $dataKualifikasi)
            <div class="col-md-4 mb-3">
                <div class="mb-3">
                    <label for="kualifikasi_{{$key}}_id_jawab" class="form-label text-white">{{ $dataKualifikasi->nama_sub_kriteria }}</label>
                    <select class="form-select" id="kualifikasi_{{$key}}_id_jawab" name="kualifikasi[{{$key}}][id_jawab]">
                        <option value="0">pilih jawaban</option>
                        @foreach($data1 as $item)
                        @if($item->id_sub == $dataKualifikasi->id)
                        <option value="{{ $item->id }}">{{ $item->keterangan_isi }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                @if($dataKualifikasi->input_pelamar == '0')
                <label for="kualifikasi_{{$key}}_isi_detail" class="mb-2 text-white">Tidak Perlu kelengkapan</label>
                <input type="file" class="form-control" id="kualifikasi_{{$key}}_isi_detail" name="kualifikasi[{{$key}}][isi_detail]">
                @elseif($dataKualifikasi->input_pelamar == 'file')
                <label for="kualifikasi_{{$key}}_isi_detail" class="mb-2 text-white">{{ $dataKualifikasi->perintah }}</label>
                <input type="file" class="form-control" id="kualifikasi_{{$key}}_isi_detail" name="kualifikasi[{{$key}}][isi_detail]">
                @elseif($dataKualifikasi->input_pelamar == 'text')
                <label for="kualifikasi_{{$key}}_isi_detail" class="mb-2 text-white">{{ $dataKualifikasi->perintah }}</label>
                <textarea class="form-control" id="kualifikasi_{{$key}}_isi_detail" name="kualifikasi[{{$key}}][isi_detail]" rows="3"></textarea>
                @endif
            </div>
            @endforeach
        </div>

        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-success">Kirim Lamar</button>
        </div>
    </form>
</div>
@endsection
