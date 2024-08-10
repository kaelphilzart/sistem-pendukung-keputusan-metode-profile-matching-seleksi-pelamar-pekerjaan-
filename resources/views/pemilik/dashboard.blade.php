@extends('template.template_pemilik')

@section('content')
<div class="container">
    <div class="row justify-content-center"> <!-- Menggunakan justify-content-center untuk membuat row berada di tengah -->
        <div class="col-md-4">
        <div class="card text-center mx-4 my-2 shadow rounded" style="background-color: #e2faff;">
                <img src="/img/loker.png" class="card-img-top mx-auto mt-4" style="width: 30%;" alt="Your Image"> <!-- Menambahkan mx-auto dan mt-3 untuk memusatkan gambar secara horizontal dan memberikan margin top -->
                <div class="card-body text-dark">
                    <h4 class="">Lowongan</h4>
                    <p class="card-text">{{$loker}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center mx-4 my-2 shadow rounded" style="background-color: #e2faff;">
                <img src="/img/pelamar.png" class="card-img-top mx-auto mt-4" style="width: 30%;" alt="Your Image"> <!-- Menambahkan mx-auto dan mt-3 untuk memusatkan gambar secara horizontal dan memberikan margin top -->
                <div class="card-body text-dark">
                    <h4 class="">Pelamar</h4>
                    <p class="card-text">{{$pelamar}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        <div class="card text-center mx-4 my-2 shadow rounded" style="background-color: #e2faff;">
                <img src="/img/user.png" class="card-img-top mx-auto mt-4" style="width: 30%;" alt="Your Image"> <!-- Menambahkan mx-auto dan mt-3 untuk memusatkan gambar secara horizontal dan memberikan margin top -->
                <div class="card-body text-dark">
                    <h4 class="">User</h4>
                    <p class="card-text">{{$user}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
