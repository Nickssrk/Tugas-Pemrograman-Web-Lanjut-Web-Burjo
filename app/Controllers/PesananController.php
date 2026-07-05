<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use CodeIgniter\HTTP\RedirectResponse;

class PesananController extends BaseController
{
    protected OrderModel     $orderModel;
    protected OrderItemModel $orderItemModel;
    protected MenuModel      $menuModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->menuModel      = new MenuModel();
    }

    /**
     * Halaman form pemesanan menu oleh pelanggan
     */
    public function index(): string
    {
        $makanan = $this->menuModel->getByCategory('makanan');
        $minuman = $this->menuModel->getByCategory('minuman');

        return view('pesanan/form', [
            'title'   => 'Pesan Menu — Warung Burjo Barokah',
            'makanan' => $makanan,
            'minuman' => $minuman,
        ]);
    }

    /**
     * Proses checkout pesanan
     */
    public function checkout(): RedirectResponse
    {
        if (! $this->validate(['nama_pemesan' => 'required|min_length[2]|max_length[100]'])) {
            return redirect()->to('/pesan')->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Kumpulkan item yang dipilih
        $qtys  = $this->request->getPost('qty') ?? [];
        $items = [];
        $total = 0;

        foreach ($qtys as $menuId => $jumlah) {
            $jumlah = (int) $jumlah;
            if ($jumlah <= 0) {
                continue;
            }

            $menu = $this->menuModel->find((int) $menuId);
            if (! $menu || $menu['status'] !== 'tersedia') {
                continue;
            }

            $subtotal = $menu['harga'] * $jumlah;
            $total   += $subtotal;

            $items[] = [
                'menu_id'    => $menu['id'],
                'nama_menu'  => $menu['nama'],
                'harga_menu' => $menu['harga'],
                'jumlah'     => $jumlah,
                'subtotal'   => $subtotal,
            ];
        }

        if (empty($items)) {
            return redirect()->to('/pesan')
                ->with('error', 'Pilih minimal 1 menu untuk dipesan.');
        }

        // Simpan order
        $kode    = $this->orderModel->generateKodeOrder();
        $orderId = $this->orderModel->insert([
            'kode_order'   => $kode,
            'nama_pemesan' => $this->request->getPost('nama_pemesan'),
            'nomor_meja'   => $this->request->getPost('nomor_meja') ?: null,
            'catatan'      => $this->request->getPost('catatan') ?: null,
            'total_harga'  => $total,
            'status'       => 'menunggu',
        ]);

        // Simpan item-item pesanan
        foreach ($items as &$item) {
            $item['order_id'] = $orderId;
        }
        $this->orderItemModel->insertBatch($items);

        return redirect()->to('/pesan/status/' . $kode);
    }

    /**
     * Halaman status pesanan + QR code pembayaran
     */
    public function status(string $kode): string
    {
        $order = $this->orderModel->getByKode($kode);
        if (! $order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Pesanan tidak ditemukan: ' . esc($kode)
            );
        }

        $order['items'] = $this->orderItemModel->where('order_id', $order['id'])->findAll();

        return view('pesanan/status', [
            'title' => 'Status Pesanan — ' . $kode,
            'order' => $order,
        ]);
    }

    /**
     * Halaman konfirmasi pembayaran (dibuka saat admin scan QR)
     */
    public function bayar(string $kode): string
    {
        $order = $this->orderModel->getByKode($kode);
        if (! $order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Pesanan tidak ditemukan: ' . esc($kode)
            );
        }

        $order['items'] = $this->orderItemModel->where('order_id', $order['id'])->findAll();

        return view('pesanan/bayar', [
            'title'      => 'Konfirmasi Pembayaran — ' . $kode,
            'order'      => $order,
            'sudahLunas' => $order['status'] === 'lunas',
        ]);
    }

    /**
     * POST: tandai pesanan sebagai lunas
     */
    public function konfirmasiBayar(string $kode): RedirectResponse
    {
        $order = $this->orderModel->getByKode($kode);
        if (! $order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Pesanan tidak ditemukan: ' . esc($kode)
            );
        }

        if ($order['status'] !== 'lunas') {
            $this->orderModel->update($order['id'], ['status' => 'lunas']);
        }

        return redirect()->to('/bayar/' . $kode)
            ->with('success', 'Pembayaran berhasil dikonfirmasi! Terima kasih.');
    }
}
