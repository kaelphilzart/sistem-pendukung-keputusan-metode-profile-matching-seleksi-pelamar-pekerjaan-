@extends('template.template_pelamar')

@section('content')
<div class="container">
    <div class="col-12 pt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="text-center card-title">Isi Data Profile</h4>
                <form class="forms-sample" method="POST" action="{{route('isi-profile')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row" style="display:none;">
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="id_user" name="id_user" value="{{Auth::user()->id}}">
                            @error('id_user')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="file" id="foto" name="foto">
                            @error('foto')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" aria-describedby="emailHelp" placeholder="Nama Lengkap">
                            @error('nama_lengkap')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="alamat" name="alamat" aria-describedby="emailHelp" placeholder="Alamat">
                            @error('alamat')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Tempat Tanggal Lahir</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" aria-describedby="emailHelp" placeholder="Tempat Tanggal Lahir">
                            @error('tempat_lahir')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" aria-describedby="emailHelp" placeholder="Tanggal Lahir">
                            @error('tanggal_lahir')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">No HP</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="no_hp" name="no_hp" aria-describedby="emailHelp" placeholder="No HP">
                            @error('no_hp')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        @foreach($umum as $key => $dataKualifikasi)
                            <div class="col-md-6 mb-3">
                                <div class="mb-3">
                                    <label for="kualifikasi_{{$key}}_id_jawab" class="form-label fw-bold">{{ strtoupper($dataKualifikasi->nama_sub_kriteria) }}</label>
                                    <select class="form-select" id="kualifikasi_{{$key}}_id_jawab" name="kualifikasi[{{$key}}][id_jawab]">
                                        <option value="0">Pilih jawaban</option>
                                        @foreach($data1 as $item)
                                            @if($item->id_sub == $dataKualifikasi->id)
                                                <option value="{{ $item->id }}">{{ $item->keterangan_isi }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                @if($dataKualifikasi->input_pelamar == '0')
                                    <label for="kualifikasi_{{$key}}_isi_detail" class="mb-2">Tidak Perlu kelengkapan</label>
                                    <input type="file" class="form-control" id="kualifikasi_{{$key}}_isi_detail" name="kualifikasi[{{$key}}][isi_detail]">
                                @elseif($dataKualifikasi->input_pelamar == 'file')
                                    <label for="kualifikasi_{{$key}}_isi_detail" class="mb-2">{{ $dataKualifikasi->perintah }}</label>
                                    <input type="file" class="form-control" id="kualifikasi_{{$key}}_isi_detail" name="kualifikasi[{{$key}}][isi_detail]">
                                @elseif($dataKualifikasi->input_pelamar == 'text')
                                    <label for="kualifikasi_{{$key}}_isi_detail" class="mb-2">{{ $dataKualifikasi->perintah }}</label>
                                    <textarea class="form-control" id="kualifikasi_{{$key}}_isi_detail" name="kualifikasi[{{$key}}][isi_detail]" rows="3"></textarea>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-dark">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
