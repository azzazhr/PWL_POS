<form action="{{ url('/stok/ajax') }}" method="POST" id="form-tambah-stok">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Tambah Data Stok</h5>
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
                    <option value="{{ $b->barang_id }}" data-kategori="{{ $b->kategori_id }}">
                        {{ $b->barang_nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-barang_id" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label>Nama Kategori</label>
            <select id="kategori_id" class="form-control">
                <option value="">- Pilih Kategori -</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->kategori_id }}" data-kode="{{ $k->kategori_kode }}">
                        {{ $k->kategori_nama }}
                    </option>
                @endforeach
            </select>
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
            <input type="date" name="stok_tanggal" id="stok_tanggal" class="form-control" value="{{ $stok->stok_tanggal }}"
                required>
            <small id="error-stok_tanggal" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label>Jumlah Stok</label>
            <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" value="{{ $stok->stok_jumlah }}"
                required>
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
            // Fungsi untuk memilih kategori berdasarkan barang
            $('#barang_id').on('change', function () {
                var kategoriId = $(this).find(':selected').data('kategori'); // Ambil kategori_id dari data atribut

                // Set kategori yang sesuai
                $('#kategori_id').val(kategoriId); // Pilih kategori berdasarkan kategori_id yang ada pada barang
            });

            $("#form-tambah-stok").validate({
                rules: {
                    barang_id: { required: true },
                    user_id: { required: true },
                    supplier_id: { required: true },
                    stok_tanggal: { required: true, date: true },
                    stok_jumlah: { required: true, number: true, min: 1 },
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            console.log("Response:", response);
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
                        },
                        error: function (xhr) {
                            console.error("AJAX Error:", xhr.responseText);
                            Swal.fire({ icon: 'error', title: 'Server Error', text: 'Terjadi kesalahan pada server.' });
                        }
                    });
                    return false;
                }
            });
        });
</script>