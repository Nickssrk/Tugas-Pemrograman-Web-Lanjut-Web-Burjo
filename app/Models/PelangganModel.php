<?php
namespace App\Models;
use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table         = 'pelanggans';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = ['nama', 'no_hp', 'email', 'alamat'];

    protected $validationRules = [
        'nama'  => 'required|min_length[3]|max_length[100]',
        'no_hp' => 'required|min_length[8]|max_length[20]',
        'email' => 'permit_empty|valid_email|max_length[100]',
    ];

    protected $validationMessages = [
        'nama'  => ['required' => 'Nama pelanggan wajib diisi.'],
        'no_hp' => ['required' => 'Nomor HP wajib diisi.'],
        'email' => ['valid_email' => 'Format email tidak valid.'],
    ];
}
