<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table         = 'menus';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nama', 'kategori', 'harga', 'deskripsi', 'gambar', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nama'     => 'required|min_length[3]|max_length[150]',
        'kategori' => 'required|in_list[makanan,minuman]',
        'harga'    => 'required|numeric|greater_than[0]',
        'status'   => 'required|in_list[tersedia,habis]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama menu wajib diisi.',
            'min_length' => 'Nama menu minimal 3 karakter.',
        ],
        'kategori' => [
            'required' => 'Kategori wajib dipilih.',
            'in_list'  => 'Kategori harus makanan atau minuman.',
        ],
        'harga' => [
            'required'     => 'Harga wajib diisi.',
            'numeric'      => 'Harga harus berupa angka.',
            'greater_than' => 'Harga harus lebih dari 0.',
        ],
    ];

    /**
     * Ambil semua menu berdasarkan kategori (makanan/minuman), urut nama A-Z.
     */
    public function getByCategory(string $kategori): array
    {
        return $this->where('kategori', $kategori)->orderBy('nama', 'ASC')->findAll();
    }

    /**
     * Hitung jumlah menu pada kategori tertentu.
     */
    public function countByCategory(string $kategori): int
    {
        return $this->where('kategori', $kategori)->countAllResults();
    }
}
