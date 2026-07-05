<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PelangganModel;

class PelangganController extends BaseController
{
    protected $pelangganModel;

    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
    }

    public function index()
    {
        $q = $this->request->getGet('q');

        $builder = $this->pelangganModel;
        if ($q) {
            $builder = $this->pelangganModel->like('nama', $q)
                           ->orLike('no_hp', $q)
                           ->orLike('email', $q);
        }

        $data = [
            'title'      => 'Kelola Pelanggan',
            'pelanggans' => $builder->paginate(10),
            'pager'      => $this->pelangganModel->pager,
            'q'          => $q,
        ];

        return view('admin/pelanggan/index', $data);
    }

    public function create()
    {
        return view('admin/pelanggan/create', ['title' => 'Tambah Pelanggan']);
    }

    public function store()
    {
        if (!$this->pelangganModel->save($this->request->getPost())) {
            return redirect()->back()->withInput()
                ->with('errors', $this->pelangganModel->errors());
        }
        return redirect()->to(base_url('admin/pelanggan'))
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggan = $this->pelangganModel->find($id);
        if (!$pelanggan) {
            return redirect()->to(base_url('admin/pelanggan'))
                ->with('error', 'Data pelanggan tidak ditemukan.');
        }
        return view('admin/pelanggan/edit', [
            'title'     => 'Edit Pelanggan',
            'pelanggan' => $pelanggan,
        ]);
    }

    public function update($id)
    {
        $pelanggan = $this->pelangganModel->find($id);
        if (!$pelanggan) {
            return redirect()->to(base_url('admin/pelanggan'))
                ->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $data = $this->request->getPost();
        if (!$this->pelangganModel->update($id, $data)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->pelangganModel->errors());
        }
        return redirect()->to(base_url('admin/pelanggan'))
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $pelanggan = $this->pelangganModel->find($id);
        if (!$pelanggan) {
            return redirect()->to(base_url('admin/pelanggan'))
                ->with('error', 'Data pelanggan tidak ditemukan.');
        }
        // Soft delete — mengisi deleted_at, tidak hapus permanen
        $this->pelangganModel->delete($id);
        return redirect()->to(base_url('admin/pelanggan'))
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}