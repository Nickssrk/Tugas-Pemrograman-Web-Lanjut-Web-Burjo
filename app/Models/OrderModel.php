<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'kode_order', 'nama_pemesan', 'nomor_meja',
        'catatan', 'total_harga', 'status',
    ];

    /**
     * Generate kode order unik, format: BRJ-XXXXXXXX
     */
    public function generateKodeOrder(): string
    {
        do {
            $kode = 'BRJ-' . strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 8));
        } while ($this->where('kode_order', $kode)->countAllResults() > 0);

        return $kode;
    }

    /**
     * Ambil order berdasarkan kode unik
     */
    public function getByKode(string $kode): ?array
    {
        return $this->where('kode_order', $kode)->first();
    }

    /**
     * Ambil order beserta items-nya
     */
    public function getWithItems(int $id): ?array
    {
        $order = $this->find($id);
        if (! $order) {
            return null;
        }

        $itemModel      = new OrderItemModel();
        $order['items'] = $itemModel->where('order_id', $id)->findAll();

        return $order;
    }

    /**
     * Hitung order berdasarkan status
     */
    public function countByStatus(string $status): int
    {
        return $this->where('status', $status)->countAllResults();
    }

    /**
     * Hitung pesanan masuk hari ini
     */
    public function countToday(): int
    {
        return $this->where('DATE(created_at)', date('Y-m-d'))->countAllResults();
    }
}
