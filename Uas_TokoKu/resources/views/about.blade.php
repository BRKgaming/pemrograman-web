@extends('layouts.app')

@section('title', 'Tentang Kami - TokoKU')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 bg-white text-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold">Tentang <span class="text-danger">Aplikasi Kami</span></h1>
                    <p class="lead mt-3">TokoKU adalah solusi terbaik untuk Anda yang mencari barang elektronik bekas namun tetap berkualitas. Kami menghadirkan beragam pilihan produk seperti laptop, gadget, TV, hingga aksesoris teknologi dengan harga terjangkau dan kondisi terjamin. Semua barang telah melalui proses inspeksi dan uji kelayakan, sehingga Anda bisa berbelanja dengan tenang tanpa khawatir soal performa. Hemat budget, tetap cerdas dalam memilih!
</p>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('img/Logo TokoKU.jpg') }}" class="img-fluid" alt="Logo TokoKU">
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5">

        <!-- Visi & Misi Section -->
        <section class="mb-5">
            <div class="container text-center pt-5 mt-5">
                <h2 class="mb-4">Visi & Misi Kami</h2>
                <div class="row">
                    <div class="col-md-4">
                        <i class="fas fa-bullseye fa-2x text-primary mb-3"></i>
                        <h5>Visi</h5>
                        <p>Menjadi platform andalan untuk mencari barang second dengan harga terjangkau kualitas terpercaya.</p>
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-handshake fa-2x text-success mb-3"></i>
                        <h5>Nilai</h5>
                        <p>Transparansi, kolaborasi, dan inovasi sebagai fondasi pengembangan.</p>
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-rocket fa-2x text-danger mb-3"></i>
                        <h5>Misi</h5>
                        <p>Memudahkan pengguna untuk mencari barang elektronik dengan harga terjangkau dan terpercaya.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Meet Our Team -->
        <section class="mb-5">
            <div class="container pt-5 mt-5">
                <h2 class="mb-5">Team</h2>
                <div class="row justify-content-center">
                    
                    <!-- Anggota 1 -->
                    <div class="col-md-3 mt-3">
                        <div class="card border-0 shadow-sm">
                            <img src="https://gapura.uisi.ac.id/assets/upload/user/300x300/64aba0c314fa86782d12738198b2bb4f.jpg" class="card-img-top" alt="Abinaya arya zaidan">
                            <div class="card-body">
                                <h5 class="card-title">Abinaya arya zaidan</h5>
                                <p class="card-text">Founder & CEO</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="https://www.instagram.com/abiny_yu" target="_blank" class="text-danger">
                                        <i class="fab fa-instagram fa-lg"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/in/ABINAYA ZAIDAN" target="_blank" class="text-primary">
                                        <i class="fab fa-linkedin fa-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Anggota 2 -->
                    <div class="col-md-3 mt-3">
                        <div class="card border-0 shadow-sm">
                            <img src="https://gapura.uisi.ac.id/assets/upload/user/300x300/32ab0edb9a27af8fb3906ca90b9783ed.JPG" class="card-img-top" alt="Moh.farizal Sholahuddin ghonni">
                            <div class="card-body">
                                <h5 class="card-title">Moh.farizal Sholahuddin ghonni</h5>
                                <p class="card-text">Technology Director</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="https://www.instagram.com/faisal_sudah" target="_blank" class="text-danger">
                                        <i class="fab fa-instagram fa-lg"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/in/moh.farizal sholahuddin ghonni" target="_blank" class="text-primary">
                                        <i class="fab fa-linkedin fa-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Anggota 3 -->
                    <div class="col-md-3 mt-3">
                        <div class="card border-0 shadow-sm">
                            <img src="https://gapura.uisi.ac.id/assets/upload/user/300x300/8e3d9afb2ef8869809f66835458d9bbb.JPG" class="card-img-top" alt="Muhammad Rif'at syauqy">
                            <div class="card-body">
                                <h5 class="card-title">Muhammad Rif'at syauqy</h5>
                                <p class="card-text">Operations Manager</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="https://www.instagram.com/m.rifatsyauqy?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="text-danger">
                                        <i class="fab fa-instagram fa-lg"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/in/" target="_blank" class="text-primary">
                                        <i class="fab fa-linkedin fa-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
@endsection

@push('styles')
<style>
    .team-card {
        transition: transform 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
