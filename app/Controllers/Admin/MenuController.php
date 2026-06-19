<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class MenuController extends BaseController
{
    protected MenuModel $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    /**
     * Daftar semua menu (bisa dicari & difilter per kategori) + pagination.
     */
    public function index()
    {
        $keyword  = $this->request->getGet('q');
        $kategori = $this->request->getGet('kategori');

        $builder = $this->menuModel->orderBy('created_at', 'DESC');

        if (! empty($keyword)) {
            $builder = $builder->like('nama', $keyword);
        }

        if (! empty($kategori)) {
            $builder = $builder->where('kategori', $kategori);
        }

        $data = [
            'title'    => 'Kelola Menu',
            'menus'    => $builder->paginate(8),
            'pager'    => $this->menuModel->pager,
            'keyword'  => $keyword,
            'kategori' => $kategori,
        ];

        return view('admin/menu/index', $data);
    }

    public function create()
    {
        return view('admin/menu/create', ['title' => 'Tambah Menu']);
    }

    public function store()
    {
        $rules = [
            'nama'     => 'required|min_length[3]|max_length[150]',
            'kategori' => 'required|in_list[makanan,minuman]',
            'harga'    => 'required|numeric|greater_than[0]',
            'status'   => 'required|in_list[tersedia,habis]',
            'gambar'   => 'permit_empty|is_image[gambar]|max_size[gambar,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambarName = $this->uploadGambar();

        $this->menuModel->insert([
            'nama'      => $this->request->getPost('nama'),
            'kategori'  => $this->request->getPost('kategori'),
            'harga'     => $this->request->getPost('harga'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar'    => $gambarName,
            'status'    => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/menu')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $menu = $this->menuModel->find($id);

        if (! $menu) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan.');
        }

        return view('admin/menu/edit', ['title' => 'Edit Menu', 'menu' => $menu]);
    }

    public function update($id)
    {
        $menu = $this->menuModel->find($id);

        if (! $menu) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan.');
        }

        $rules = [
            'nama'     => 'required|min_length[3]|max_length[150]',
            'kategori' => 'required|in_list[makanan,minuman]',
            'harga'    => 'required|numeric|greater_than[0]',
            'status'   => 'required|in_list[tersedia,habis]',
            'gambar'   => 'permit_empty|is_image[gambar]|max_size[gambar,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambarName = $this->uploadGambar($menu['gambar']);

        $this->menuModel->update($id, [
            'nama'      => $this->request->getPost('nama'),
            'kategori'  => $this->request->getPost('kategori'),
            'harga'     => $this->request->getPost('harga'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar'    => $gambarName,
            'status'    => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/menu')->with('success', 'Menu berhasil diperbarui.');
    }

    public function delete($id)
    {
        $menu = $this->menuModel->find($id);

        if (! $menu) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan.');
        }

        if (! empty($menu['gambar'])) {
            $path = FCPATH . 'assets/uploads/menu/' . $menu['gambar'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        $this->menuModel->delete($id);

        return redirect()->to('/admin/menu')->with('success', 'Menu berhasil dihapus.');
    }

    /**
     * Helper: proses upload gambar (opsional).
     * Jika ada gambar lama dan diganti, gambar lama akan dihapus.
     * Mengembalikan nama file baru, atau nama file lama jika tidak ada upload baru.
     */
    private function uploadGambar(?string $oldFile = null): ?string
    {
        $file = $this->request->getFile('gambar');

        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return $oldFile;
        }

        if ($oldFile) {
            $oldPath = FCPATH . 'assets/uploads/menu/' . $oldFile;
            if (is_file($oldPath)) {
                unlink($oldPath);
            }
        }

        $newName = $file->getRandomName();
        $file->move(FCPATH . 'assets/uploads/menu', $newName);

        return $newName;
    }
}
