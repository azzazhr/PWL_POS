@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-sm btn-info mt-1">
                    Import Stok
                </button>
                <a href="{{ url('/stok/export_excel') }}" class="btn btn-sm btn-primary mt-1"><i class="fa fa-file-excel"></i>
                    Export Data Stok
                </a>
                <a href="{{ url('/stok/export_pdf') }}" class="btn btn-sm btn-warning mt-1"><i class="fa fa-file-pdf"></i>
                    Export Data Stok
                </a>
                <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-sm btn-success mt-1">
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
            <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Nama Kategori</th>
                        <th>User</th>
                        <th>Supplier</th>
                        <th>Tanggal Stok</th>
                        <th>Jumlah Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    {{-- Modal Container --}}
    <div id="modal-crud" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"></div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function modalAction(url) {

                $("#modal-crud .modal-content").html("");

                $.get(url, function (response) {
                    $("#modal-crud .modal-content").html(response);
                    $("#modal-crud").modal("show");
                });
            }

            $('#modal-crud').on('hidden.bs.modal', function () {
                $("#modal-crud .modal-content").html("");
            });

            var dataSevel
            $(document).ready(function () {
                dataStok = $('#table_stok').DataTable({
                    serverSide: true,
                    ajax: {
                        url: "{{ url('stok/list') }}",
                        dataType: "json",
                        type: "POST",
                    },
                columns: [
                    { data: 'stok_id', name: 'stok_id' },
                    { data: 'barang_nama', name: 'barang_nama' },
                    { data: 'kategori_nama', name: 'kategori_nama' },
                    { data: 'user_nama', name: 'user_nama' },
                    { data: 'supplier_nama', name: 'supplier_nama' },
                    { data: 'stok_tanggal', name: 'stok_tanggal' },
                    { data: 'stok_jumlah', name: 'stok_jumlah' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
