<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kasirci4</title>
    <script src="<?=base_url('assets/jquery-3.7.1.min.js')?>"></script>
    <link rel="stylesheet" href="<?=base_url('assets/bootstrap-5.0.2-dist/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/fontawesome-free-6.6.0-web/css/all.min.css')?>">
</head>
<body>
<div class="container mt-5"> 
    <div class="row mt-3">
     <div class="col-12">
        <h3 class="text-center"> Data Produk </h3>
         <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
            <i class="fa-solid fa-cart-plus">
            </i> Tambah Data </button>
    </div>
</div> 
<div class="row">
    <div class="col-12">
        <div class="container mt-5">
            <table class="table table-bordered" id="produkTabel">
                <thead> 
                 <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <!-- data akan dimasukkan melalui ajax-->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- modal tambah produk-->
<div class="modal fade" id="modalTambahProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modelTambahProduk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"> 
                <h1 class="modal-title fs-5" id="modalTambahProdukLabel"> Tambah Produk </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formProduk">
                    <div class="row mb-3">
                        <label for="namaProduk" class="col-sm-4 col-form-tabel"> Nama Produk </label>
                        <div class="col-sm-8"> 
                            <input type="text" class="form-control" id="namaProduk" name="namaProduk">
                        </div>
                    </div>
                    <div class="row nb-3"> 
                        <label form="hargaProduk" class="col-sm-4 col-form-label">Harga</label>
                        <div class="col-sm-8">
                            <input type="number" step="0.01" class="form-control" id="hargaProduk">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="stokProduk" class="col-sm-4 col-form-label">Stok</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="stokProduk">
                        </div>
                    </div>
                    <button type="button" id="simpanProduk" class="btn btn-primary float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk edit produk -->
<div class="modal fade" id="modalEditProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="modalEditProdukLabel">Edit Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk input data produk -->
                    <form id="formEditProduk">
                        <input type="hidden" id="produkIdEdit" name="produkIdEdit"> <!-- Hidden input untuk ID produk -->
                        <div class="row mb-3">
                            <label for="namaProdukEdit" class="col-sm-4 col-form-label">Nama Produk</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="namaProdukEdit" name="namaProdukEdit">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hargaProdukEdit" class="col-sm-4 col-form-label">Harga</label>
                            <div class="col-sm-8">
                                <input type="number" step="0.01" class="form-control" id="hargaProdukEdit">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="stokProdukEdit" class="col-sm-4 col-form-label">Stok</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="stokProdukEdit">
                            </div>
                        </div>
                        <button type="button" id="editProduk" class="btn btn-primary float-end">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



<script>
        function tampilProduk() {
            $.ajax({
                url: '<?= base_url('produk/tampil'); ?>',
                type: "GET",
                dataType: 'json',
                success: function(hasil) {
                    if (hasil.status === "success") {
                        var produkTable = $('#produkTabel tbody');
                        produkTable.empty();
                        var produk = hasil.produk;
                        var no = 1;

                        produk.forEach(function(item) {
                            var row = `<tr>
                                <td>${no}</td>
                                <td>${item.nama_produk}</td>
                                <td>${item.harga}</td>
                                <td>${item.stok}</td>
                                <td>
                                    <button class="btn btn-warning btn-edit" data-id="${item.produk_id}">Edit</button>
                                    <button class="btn btn-danger btn-hapus" data-id="${item.produk_id}">Hapus</button>
                                </td>
                            </tr>`;
                            produkTable.append(row);
                            no++;
                        });
                    } else {
                        alert("Gagal mengambil data.");
                    }
                },
                error: function(xhr, status, error) {
                    alert("Terjadi kesalahan: " + error);
                }
            });
        }

        $(document).ready(function() {
            // Panggil fungsi saat halaman dimuat
            tampilProduk();

            $("#simpanProduk").on("click", function() { //simpannnn
                var formData = {
                    nama_produk: $("#namaProduk").val(),
                    harga: $('#hargaProduk').val(),
                    stok: $('#stokProduk').val()
                };

                $.ajax({
                    url: '<?= base_url('produk/simpan'); ?>',
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    success: function(hasil) {
                        if (hasil.status === 'success') {
                            Swal.fire({
                                title: "Success",
                                text: "Data berhasil di simpan",
                                icon: "success"
                                });
                            $('#modalTambahProduk').modal("hide");
                            $('#formProduk')[0].reset();
                            tampilProduk();
                        } else {
                            alert('Gagal menyimpan data: ' + JSON.stringify(hasil.errors));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Terjadi kesalahan: " + error);
                    }
                });
            });

            // Event handler untuk tombol hapus
            $(document).on('click', '.btn-hapus', function() {
                var row = $(this).closest('tr');
                // document.get
                var id = $(this).data('id');

                if (id <= 0) {
                    alert("ID produk tidak valid.");
                    return;
                }
                
                if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
                    $.ajax({
                        url: '<?= base_url('produk/hapus/') ?>' + id,
                        type: "DELETE",
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                row.remove();
                                alert("Produk berhasil dihapus.");
                                tampilProduk();
                            } else {
                                alert("Gagal menghapus produk.");
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Terjadi kesalahan saat menghapus: " + error);
                        }
                    });
                }
            });

            // Event handler untuk tombol edit
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
               
                $.ajax({
                    url: '<?=base_url('produk/detail/')?>' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if(data.status==='success') {
                            $('#produkIdEdit').val(data.produk.produk_id);
                            $('#namaProdukEdit').val(data.produk.nama_produk);
                            $('#hargaProdukEdit').val(data.produk.harga);
                            $('#stokProdukEdit').val(data.produk.stok);

                            $('#modalEditProdukLabel').text('Edit Produk');

                            $('#modalEditProduk').modal('show');

                        } else {
                            alert('Gagal mengambil data produk');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan:' + error);
                    }
                })
            });

            $('#editProduk').on('click', function(){
                var formData = {
                    produkId: $('#produkIdEdit').val(),
                    nama_produk: $('#namaProdukEdit').val(),
                    harga: $('#hargaProdukEdit').val(),
                    stok: $('#stokProdukEdit').val(),
                };

                $.ajax({
                    url: '<?=base_url('produk/update'); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status === 'success') {
                            $('#modalEditProduk').modal("hide");
                            tampilProduk();
                        } else {
                            alert('Gagal mengedit data:' + JSON.stringfy(hasil.errors));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Terjadi kesalahan:" + error);
                    }
                })
            })
        });
    </script>
    <script src="<?=base_url('assets/bootstrap-5.0.2-dist/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('assets/fontawesome-free-6.6.0-web/js/all.min.js')?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
