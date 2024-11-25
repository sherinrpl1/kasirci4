<?php

namespace App\Controllers;
  use App\Controllers\BaseController;
use App\Models\PelangganModel; // Menambahkan model PelangganModel
use CodeIgniter\HTTP\ResponseInterface;

class Pelanggan extends BaseController
{
    protected $pelangganmodel;

    public function __construct()
    {
        // Inisialisasi model PelangganModel
        $this->pelangganmodel = new PelangganModel();
    }

    // Halaman utama pelanggan
    public function index()
    {
        // Mengembalikan view pelanggan
        return view('v_pelanggan');
    }

    // Menampilkan data pelanggan
    public function tampil_pelanggan()
    {
        try {
            // Mendapatkan semua data pelanggan
            $pelanggan = $this->pelangganmodel->findAll();

            // Jika data ditemukan, kembalikan dalam format JSON
            return $this->response->setJSON([
                'status'    => 'success',
                'pelanggan' => $pelanggan
            ]);
        } catch (\Exception $e) {
            // Jika ada kesalahan dalam query atau lainnya, kembalikan status error
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data pelanggan: ' . $e->getMessage()
            ], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR); // HTTP 500
        }
    }

    // Menyimpan data pelanggan
    public function simpan_pelanggan()
    {
        // Menggunakan validation service untuk memvalidasi input
        $validation = \Config\Services::validation();

        // Menetapkan aturan validasi
        $validation->setRules([
            'nama_pelanggan' => 'required',
            'alamat'         => 'required',
            'no_tlp'         => 'required',
        ]);

        // Jika validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            // Mengembalikan response dengan error dan pesan validasi
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ], ResponseInterface::HTTP_BAD_REQUEST); // Menggunakan status HTTP 400
        }

        // Menyusun data yang akan disimpan
        $data = [
            'nama_pelanggan' => $this->request->getVar('nama_pelanggan'),
            'alamat'         => $this->request->getVar('alamat'),
            'no_tlp'         => $this->request->getVar('no_tlp'),
        ];

        try {
            // Menyimpan data ke dalam database
            $this->pelangganmodel->save($data);

            // Mengembalikan response sukses
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Data pelanggan berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            // Jika ada kesalahan saat menyimpan data
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data pelanggan: ' . $e->getMessage()
            ], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR); // HTTP 500
        }
    }

    public function delete($id)
    {
     $model = new PelangganModel();
     if($model->delete($id)) {
         return $this->response->setJSON(['success' => true]);
     } else{
         return $this->response->setJSON(['success' => false, 'message' => 'gagal menghapus data']);
     }
    }

    public function update_pelanggan()
    {
        // Fetch the customer ID and data from the request
        $id = $this->request->getVar('id_pelanggan');
        $data = [
            'nama_pelanggan' => $this->request->getVar('nama_pelanggan'),
            'alamat'         => $this->request->getVar('alamat'),
            'no_tlp'         => $this->request->getVar('no_tlp'),
        ];

        // Ensure that the ID exists and data is updated in the database
        if ($id && $this->pelangganmodel->update($id, $data)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Data pelanggan berhasil diperbarui',  // Success message
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal memperbarui data pelanggan',  // Error message
            ]);
        }
    }


    

    public function detail($id) {
        $pelanggan = $this->pelangganmodel->find($id);
        if ($pelanggan) {
            return $this->response->setJSON([
                'status' => 'success',
                'pelanggan' => $pelanggan,
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    // Fungsi untuk mengambil data produk yang akan diedit
    public function edit_pelanggan()
    {
        $id_pelanggan = $this->request->getVar('id');
        $pelanggan = $this->pelangganmodel->find($id_pelanggan);

        if ($pelanggan) {
            return $this->response->setJSON([
                'status' => 'success',
                'pelanggan' => $pelanggan
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pelanggan Tidak Ditemukan'], 404);
        }
    }
}
