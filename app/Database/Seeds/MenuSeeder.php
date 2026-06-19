<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            // ==== Makanan ====
            [
                'nama' => 'Indomie Goreng Telur', 'kategori' => 'makanan', 'harga' => 8000,
                'deskripsi' => 'Indomie goreng dengan tambahan telur ceplok.',
                'gambar' => null, 'status' => 'tersedia', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Indomie Rebus Telur', 'kategori' => 'makanan', 'harga' => 8000,
                'deskripsi' => 'Indomie rebus kuah gurih dengan telur.',
                'gambar' => null, 'status' => 'tersedia', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Nasi Telur Dadar', 'kategori' => 'makanan', 'harga' => 9000,
                'deskripsi' => 'Nasi putih hangat dengan telur dadar dan kerupuk.',
                'gambar' => null, 'status' => 'tersedia', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Magelangan', 'kategori' => 'makanan', 'harga' => 12000,
                'deskripsi' => 'Campuran indomie goreng, rebus, dan nasi khas burjo.',
                'gambar' => null, 'status' => 'tersedia', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Roti Bakar Coklat Keju', 'kategori' => 'makanan', 'harga' => 10000,
                'deskripsi' => 'Roti bakar isi coklat dan keju melimpah.',
                'gambar' => null, 'status' => 'habis', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Nasi Goreng Spesial', 'kategori' => 'makanan', 'harga' => 13000,
                'deskripsi' => 'Nasi goreng dengan telur, ayam suwir, dan acar segar.',
                'gambar' => null, 'status' => 'tersedia', 'created_at' => $now, 'updated_at' => $now,
            ],
            // ==== Minuman ====
            [
                'nama' => 'Es Teh Manis', 'kategori' => 'minuman', 'harga' => 4000,
                'deskripsi' => 'Teh manis dingin yang menyegarkan.',
                'gambar' => null, 'status' => 'tersedia', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Es Jeruk', 'kategori' => 'minuman', 'harga' => 5000,
                'deskripsi' => 'Perasan jeruk asli dengan es batu.',
                'gambar' => null, 'status' => 'tersedia', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Kopi Hitam', 'kategori' => 'minuman', 'harga' => 4000,
                'deskripsi' => 'Kopi hitam khas warung, pahit nikmat.',
                'gambar' => null, 'status' => 'tersedia', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Susu Coklat Panas', 'kategori' => 'minuman', 'harga' => 6000,
                'deskripsi' => 'Susu coklat hangat untuk menemani malam.',
                'gambar' => null, 'status' => 'tersedia', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Wedang Jahe', 'kategori' => 'minuman', 'harga' => 5000,
                'deskripsi' => 'Minuman jahe hangat, penghangat badan di malam hari.',
                'gambar' => null, 'status' => 'tersedia', 'created_at' => $now, 'updated_at' => $now,
            ],
        ];

        $this->db->table('menus')->insertBatch($data);
    }
}
