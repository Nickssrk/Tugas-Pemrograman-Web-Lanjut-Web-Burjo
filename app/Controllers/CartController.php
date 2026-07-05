<?php
namespace App\Controllers;

use App\Libraries\Cart;
use App\Models\MenuModel;

class CartController extends BaseController
{
    protected $cart;
    protected $menuModel;

    public function __construct()
    {
        $this->cart      = new Cart();
        $this->menuModel = new MenuModel();
    }

    // Tampilkan isi cart
    public function index()
    {
        return view('cart/index', [
            'title'   => 'Keranjang Belanja',
            'items'   => $this->cart->contents(),
            'total'   => $this->cart->total(),
        ]);
    }

    // insert() — Tambah item ke cart
    public function insert()
    {
        $id   = $this->request->getPost('menu_id');
        $menu = $this->menuModel->find($id);

        if (!$menu || $menu['status'] === 'habis') {
            return redirect()->back()->with('error', 'Menu tidak tersedia.');
        }

        $this->cart->insert([
            'id'     => $menu['id'],
            'nama'   => $menu['nama'],
            'harga'  => $menu['harga'],
            'jumlah' => (int) $this->request->getPost('jumlah') ?: 1,
        ]);

        return redirect()->to(base_url('cart'))
            ->with('success', $menu['nama'] . ' ditambahkan ke keranjang.');
    }

    // update() — Ubah quantity
    public function update()
    {
        $id     = (int) $this->request->getPost('menu_id');
        $jumlah = (int) $this->request->getPost('jumlah');

        $this->cart->update($id, $jumlah);

        return redirect()->to(base_url('cart'))
            ->with('success', 'Keranjang diperbarui.');
    }

    // remove() — Hapus satu item
    public function remove($id)
    {
        $this->cart->remove((int) $id);
        return redirect()->to(base_url('cart'))
            ->with('success', 'Item dihapus dari keranjang.');
    }

    // destroy() — Kosongkan cart
    public function destroy()
    {
        $this->cart->destroy();
        return redirect()->to(base_url('cart'))
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }
}