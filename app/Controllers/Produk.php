<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukModel;

class Produk extends BaseController
{
   protected $produkmodel;

   public function __construct()
   {
    $this->produkmodel = new ProdukModel();
   }

   public function index()
   {
        return view('v_produk');
   }

   public function tampil_produk()
   {
        $produk = $this->produkmodel->findAll();

        return $this->response->setJSON([
            'status'    => 'success',
            'produk'    => $produk
        ]);
   }

   public function simpan_produk()
   {
    $validation = \Config\Services::validation();

    $validation->setRules([
        'nama_produk'   => 'required',
        'harga'         => 'required|decimal',
        'stok'          => 'required|integer',
    ]);

    if(!$validation->withRequest($this->request)->run()){
        return $this->response->setJSON([
            'status'    => 'error',
            'errors'    => $validation->getErrors(),
        ]);
    }

    $data = [
        'nama_produk' => $this->request->getVar('nama_produk'),
        'harga'       => $this->request->getVar('harga'),
        'stok'        => $this->request->getVar('stok'),
    ];

    $this->produkmodel->save($data);

    return $this->response->setJSON([
        'status'    => 'success',
        'message'   => 'Data produk berhasil disimpan'
    ]);
   }

 
   public function delete($id)
   {
    $model = new ProdukModel();
    if($model->delete($id)) {
        return $this->response->setJSON(['success' => true]);
    } else{
        return $this->response->setJSON(['success' => false, 'message' => 'gagal menghapus data']);
    }
   }

   public function update_produk()
{
    $id = $this->request->getVar('produkId'); // Ambil ID produk dari request
    $data = [
        'nama_produk' => $this->request->getVar('nama_produk'),
        'harga'       => $this->request->getVar('harga'),
        'stok'        => $this->request->getVar('stok'),
    ];
    
    if ($id && $this->produkmodel->update($id, $data)) { // Update produk dengan ID spesifik
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data produk berhasil diperbarui',
        ]);
    } else {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal memperbarui data produk',
        ]);
    }
}

    

    public function detail($id) {
        $produk = $this->produkmodel->find($id);
        if ($produk) {
            return $this->response->setJSON([
                'status' => 'success',
                'produk' => $produk,
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    // Fungsi untuk mengambil data produk yang akan diedit
    public function edit_produk()
    {
        $produkID = $this->request->getVar('id');
        $produk = $this->produkmodel->find($produkID);

        if ($produk) {
            return $this->response->setJSON([
                'status' => 'success',
                'produk' => $produk
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produk Tidak Ditemukan'], 404);
        }
    }
   }
