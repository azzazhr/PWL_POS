@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-sm btn-info mt-1">
                    Import Penjualan
                </button>
                <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-sm btn-primary mt-1"><i
                        class="fa fa-file-excel"></i>
                    Export Data Penjualan
                </a>
                <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-sm btn-warning mt-1"><i class="fa fa-file-pdf"></i>
                    Export Data Penjualan
                </a>
                <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-sm btn-success mt-1">
                    Tambah Ajax
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
                <table class="table table-bordered table-sm table-striped table-hover" id="table-penjualan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal penjualan</th>
                            <th>Nama Kasir</th>
                            <th>Nama Pembeli</th>
                            <th>Barang</th>
                            <th>Jumlah</th> 
                            <th>Harga</th>
                            <th>Total Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
            data-width="75%"></div>
@endsection
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }
        var tablePenjualan;
        $(document).ready(function () {
            tablePenjualan = $('#table-penjualan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.filter_kategori = $('.filter_kategori').val();
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "penjualan_tanggal",
                    className: "",
                    width: "15%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "user.nama",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "pembeli",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "barang",
                    className: "",
                    width: "15%",
                    orderable: false,
                    searchable: false
                },
                {
                        data: "jumlah",
                        width: "8%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "harga",
                        width: "10%",
                        orderable: false,
                        searchable: false
                    },
                {
                    data: "total_transaksi",
                    className: "",
                    width: "10%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "aksi",
                    className: "text-center",
                    width: "25%",
                    orderable: false,
                    searchable: false
                }
                ]
            });
            $('#table_penjualan_filter input').unbind().bind().on('keyup', function (e) {
                if (e.keyCode == 13) { // enter key
                    tablePenjualan.search(this.value).draw();
                }
            });
            $('.filter_kategori').change(function () {
                tablePenjualan.draw();
            });
        });
    </script>
@endpush