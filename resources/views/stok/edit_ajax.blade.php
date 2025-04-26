@empty($stok)
    <div id="modal-crud" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/stok/' . $stok->stok_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select name="barang_id" id="barang_id" class="form-control" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach($barang as $b)
                                    <option value="{{ $b->barang_id }}" {{ $b->barang_id == $stok->barang->barang_id ? 'selected' : '' }}>
                                        {{ $b->barang_nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-barang_id" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">- Pilih Nama Kategori -</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->kategori_id }}" {{ $k->kategori_id == $stok->barang->kategori_id ? 'selected' : '' }}>
                                        {{ $k->kategori_nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-kategori_nama" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>User</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">- Pilih User -</option>
                                @foreach($user as $u)
                                    <option value="{{ $u->user_id }}" {{ $u->user_id == $stok->user_id ? 'selected' : '' }}>
                                        {{ $u->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-user_id" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                <option value="">- Pilih Supplier -</option>
                                @foreach($supplier as $s)
                                    <option value="{{ $s->supplier_id }}" {{ $s->supplier_id == $stok->supplier_id ? 'selected' : '' }}>
                                        {{ $s->supplier_nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-supplier_id" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Stok</label>
                            <input type="date" name="stok_tanggal" id="stok_tanggal" class="form-control"
                                value="{{ $stok->stok_tanggal }}" required>
                            <small id="error-stok_tanggal" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Stok</label>
                            <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control"
                                value="{{ $stok->stok_jumlah }}" required>
                            <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            <script>
                    $(document).ready(function () {
                        $("#form-edit").validate({
                            rules: {
                                user_id: { required: true, number: true },
                                kategori_id: { required: true },
                                supplier_id: { required: true, number: true },
                                stok_tanggal: { required: true, date: true },
                                stok_jumlah: { required: true, number: true, min: 1 },
                            },
                            submitHandler: function (form) {
                                $.ajax({
                                    url: form.action,
                                    type: form.method,
                                    data: $(form).serialize(),
                                    success: function (response) {
                                        if (response.status) {
                                            $('#modal-crud').modal('hide');
                                            Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                                            dataStok.ajax.reload();
                                        } else {
                                            $('.error-text').text('');
                                            $.each(response.msgField, function (prefix, val) {
                                                $('#error-' + prefix).text(val[0]);
                                            });
                                            Swal.fire({ icon: 'error', title: 'Terjadi Kesalahan', text: response.message });
                                        }
                                    }
                                });
                                return false;
                            }
                        });
                    });
        </script>
@endempty