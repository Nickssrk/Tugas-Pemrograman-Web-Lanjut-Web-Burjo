<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use CodeIgniter\HTTP\RedirectResponse;

class PesananController extends BaseController
{
    protected OrderModel     $orderModel;
    protected OrderItemModel $orderItemModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    /**
     * Daftar semua pesanan (dengan filter status & pagination)
     */
    public function index(): string
    {
        $statusFilter = $this->request->getGet('status') ?? '';
        $validStatuses = ['menunggu', 'diproses', 'selesai', 'lunas'];

        $this->orderModel->orderBy('created_at', 'DESC');
        if ($statusFilter && in_array($statusFilter, $validStatuses, true)) {
            $this->orderModel->where('status', $statusFilter);
        }

        $orders = $this->orderModel->paginate(10);
        $pager  = $this->orderModel->pager;

        return view('admin/pesanan/index', [
            'title'        => 'Kelola Pesanan',
            'orders'       => $orders,
            'pager'        => $pager,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Detail satu pesanan
     */
    public function detail(int $id): string
    {
        $order = $this->orderModel->find($id);
        if (! $order) {
            return redirect()->to('admin/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $order['items'] = $this->orderItemModel->where('order_id', $id)->findAll();

        return view('admin/pesanan/detail', [
            'title' => 'Detail Pesanan — ' . $order['kode_order'],
            'order' => $order,
        ]);
    }

    /**
     * POST: update status pesanan
     */
    public function updateStatus(int $id): RedirectResponse
    {
        $order = $this->orderModel->find($id);
        if (! $order) {
            return redirect()->to('admin/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $status        = $this->request->getPost('status');
        $validStatuses = ['menunggu', 'diproses', 'selesai', 'lunas'];

        if (! in_array($status, $validStatuses, true)) {
            return redirect()->to('admin/pesanan/detail/' . $id)
                ->with('error', 'Status tidak valid.');
        }

        $this->orderModel->update($id, ['status' => $status]);

        return redirect()->to('admin/pesanan/detail/' . $id)
            ->with('success', 'Status pesanan berhasil diperbarui menjadi "' . $status . '".');
    }

    /**
     * Halaman QR Code warung (untuk di-print dan ditaruh di meja)
     */
    public function qrWarung(): string
    {
        return view('admin/pesanan/qr_warung', [
            'title' => 'QR Code Pemesanan',
        ]);
    }
}
