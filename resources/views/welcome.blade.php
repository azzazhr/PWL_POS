@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <!-- Title -->
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard Admin</h1>
            </div>
        </div>

        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total User</span>
                        <span class="info-box-number">1,245</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Penjualan</span>
                        <span class="info-box-number">524</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Barang Tersedia</span>
                        <span class="info-box-number">324</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box bg-danger">
                    <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pendapatan</span>
                        <span class="info-box-number">Rp 45.000.000</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Halo, Admin 👋</h3>
            </div>
            <div class="card-body">
                Selamat datang di dashboard aplikasi. Gunakan panel di samping untuk mengelola data pengguna, penjualan, dan
                barang.
            </div>
        </div>
    </div>
@endsection