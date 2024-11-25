<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kasirci4</title>
    <script src="<?= base_url('assets/jquery-3.7.1.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.0.2-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free-6.6.0-web/css/all.min.css') ?>">
</head>
<body>
    <div class="container mt-5">
        <div class="row mt-3">
            <div class="col-12">
                <h3 class="text-center">Data Pelanggan</h3>
                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">
                    <i class="fa-regular fa-user"></i> Tambah Pelanggan
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="container mt-5">
                    <table class="table table-bordered" id="pelangganTabel">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>No.Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimasukkan melalui ajax -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal tambah pelanggan -->
        <div class="modal fade" id="modalTambahPelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modelTambahPelanggan" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h1 class="modal-title fs-5" id="modalTambahPelangganLabel">Tambah Pelanggan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="fromPelanggan">
                            <div class="row mb-3">
                                <label for="namaPelanggan" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="alamatPelanggan" class="col-sm-4 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="alamatPelanggan" name="alamatPelanggan">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="telponPelanggan" class="col-sm-4 col-form-label">No.Telpon</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="telponPelanggan" name="telponPelanggan">
                                </div>
                            </div>
                            <button type="button" id="simpanPelanggan" class="btn btn-primary float-end">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk edit pelanggan -->
        <div class="modal fade" id="modalEditPelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditPelangganLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h1 class="modal-title fs-5" id="modalEditPelangganLabel">Edit Pelanggan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditPelanggan">
                            <input type="hidden" id="pelanganIdEdit" name="pelangganIdEdit">
                            <div class="row mb-3">
                                <label for="namaPelanggaEdit" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="namaPelangganEdit" name="namaPelangganEdit">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="alamatPelangganEdit" class="col-sm-4 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="alamatPelangganEdit" name="alamatPelangganEdit">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="telponPelangganEdit" class="col-sm-4 col-form-label">No.Telpon</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="telponPelangganEdit">
                                </div>
                            </div>
                            <button type="button" id="editPelanggan" class="btn btn-primary float-end">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function tampilPelanggan() {
            $.ajax({
                url: '<?= base_url('pelanggan/tampil'); ?>',
                type: "GET",
                dataType: 'json',
                success: function (hasil) {
                    if (hasil.status === "success") {
                        var pelangganTable = $('#pelangganTabel tbody');
                        pelangganTable.empty();
                        var pelanggan = hasil.pelanggan;
                        var no = 1;

                        pelanggan.forEach(function (item) {
                            var row = `<tr>
                                <td>${no}</td>
                                <td>${item.nama_pelanggan}</td>
                                <td>${item.alamat}</td>
                                <td>${item.no_tlp}</td>
                                <td>
                                    <button class="btn btn-warning btn-edit" data-id="${item.id_pelanggan}">Edit</button>
                                    <button class="btn btn-danger btn-hapus" data-id="${item.id_pelanggan}">Hapus</button>
                                </td>
                            </tr>`;
                            pelangganTable.append(row);
                            no++;
                        });
                    } else {
                        alert("Gagal mengambil data.");
                    }
                },
                error: function (xhr, status, error) {
                    alert("Terjadi kesalahan: " + error);
                }
            });
        }

        $(document).ready(function () {
            tampilPelanggan();

            $("#simpanPelanggan").on("click", function () {
                var formData = {
                    nama_pelanggan: $("#namaPelanggan").val(),
                    alamat: $('#alamatPelanggan').val(),
                    no_tlp: $('#telponPelanggan').val()
                };

                $.ajax({
                    url: '<?= base_url('pelanggan/simpan'); ?>',
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status === 'success') {
                            Swal.fire({
                                title: "Success",
                                text: "Data berhasil disimpan",
                                icon: "success"
                            });
                            $('#modalTambahPelanggan').modal("hide");
                            $('#fromPelanggan')[0].reset();
                            tampilPelanggan();
                        } else {
                            alert('Gagal menyimpan data: ' + JSON.stringify(hasil.errors));
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("Terjadi kesalahan: " + error);
                    }
                });
            });
        });

         // Event handler untuk tombol hapus
         $(document).on('click', '.btn-hapus', function() {
                var row = $(this).closest('tr');
                document.get
                var id = $(this).data('id');
                if (confirm("Apakah Anda yakin ingin menghapus pelanggan ini?")) {
                    $.ajax({
                        url: '<?= base_url('pelanggan/hapus/') ?>' + id,
                        type: "DELETE",
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                row.remove();
                                alert("Pelanggan berhasil dihapus.");
                                tampilPelanggan();
                            } else {
                                alert("Gagal menghapus pelanggan.");
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
                    url: '<?=base_url('/pelanggan/detail/')?>' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                    console.log(data);
                        if(data.status==='success') {
                            $('#pelangganIdEdit').val(data.pelanggan.id_pelanggan);
                            $('#namaPelangganEdit').val(data.pelanggan.nama_pelanggan);
                            $('#alamatPelangganEdit').val(data.pelanggan.alamat);
                            $('#telponPelangganEdit').val(data.pelanggan.no_tlp);

                            $('#modalEditPelangganLabel').text('Edit Pelanggan');

                            $('#modalEditPelanggan').modal('show');

                        } else {
                            alert('Gagal mengambil data pelanggan');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan:' + error);
                    }
                })
            });

            $('#editPelanggan').on('click', function(){
                var formData = {
                    id_pelanggan: $('#pelanganIdEdit').val(),
                    nama_pelanggan: $('#namaPelangganEdit').val(),
                    alamat: $('#alamatPelangganEdit').val(),
                    no_tlp: $('#telponPelangganEdit').val(),
                };

                $.ajax({
                    url: '<?=base_url('/pelanggan/update'); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (hasil) {
                        console.log(hasil);
                        
                        if (hasil.status === 'success') {
                            $('#modalEditPelanggan').modal("hide");
                            tampilPelanggan();
                        } else {
                            alert('Gagal mengedit data');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Terjadi kesalahan:" + error);
                    }
                })
            });
    </script>
    <script src="<?= base_url('assets/bootstrap-5.0.2-dist/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/fontawesome-free-6.6.0-web/js/all.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
