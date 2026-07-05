<?php
namespace App\Libraries;

use CodeIgniter\Session\Session;

class Cart
{
    protected $session;
    protected $cartKey = 'burjo_cart';

    public function __construct()
    {
        $this->session = session();
        if ($this->session->get($this->cartKey) === null) {
            $this->session->set($this->cartKey, []);
        }
    }

    /**
     * insert() — Menambah item ke keranjang
     */
    public function insert(array $item): bool
    {
        if (empty($item['id']) || empty($item['nama']) || empty($item['harga'])) {
            return false;
        }

        $cart = $this->session->get($this->cartKey);
        $id   = $item['id'];

        if (isset($cart[$id])) {
            // Sudah ada, tambah qty
            $cart[$id]['jumlah'] += $item['jumlah'] ?? 1;
        } else {
            $cart[$id] = [
                'id'       => $id,
                'nama'     => $item['nama'],
                'harga'    => $item['harga'],
                'jumlah'   => $item['jumlah'] ?? 1,
                'subtotal' => 0,
            ];
        }

        $cart[$id]['subtotal'] = $cart[$id]['harga'] * $cart[$id]['jumlah'];
        $this->session->set($this->cartKey, $cart);
        return true;
    }

    /**
     * update() — Mengubah quantity item
     */
    public function update(int $id, int $jumlah): bool
    {
        $cart = $this->session->get($this->cartKey);

        if (!isset($cart[$id])) {
            return false;
        }

        if ($jumlah <= 0) {
            return $this->remove($id);
        }

        $cart[$id]['jumlah']   = $jumlah;
        $cart[$id]['subtotal'] = $cart[$id]['harga'] * $jumlah;
        $this->session->set($this->cartKey, $cart);
        return true;
    }

    /**
     * total() — Menghitung total harga
     */
    public function total(): int
    {
        $cart = $this->session->get($this->cartKey);
        return array_sum(array_column($cart, 'subtotal'));
    }

    /**
     * remove() — Menghapus satu item dari cart
     */
    public function remove(int $id): bool
    {
        $cart = $this->session->get($this->cartKey);

        if (!isset($cart[$id])) {
            return false;
        }

        unset($cart[$id]);
        $this->session->set($this->cartKey, $cart);
        return true;
    }

    /**
     * destroy() — Mengosongkan seluruh keranjang
     */
    public function destroy(): void
    {
        $this->session->remove($this->cartKey);
        $this->session->set($this->cartKey, []);
    }

    /**
     * contents() — Mengambil semua isi cart
     */
    public function contents(): array
    {
        return $this->session->get($this->cartKey) ?? [];
    }

    /**
     * totalItems() — Jumlah item berbeda di cart
     */
    public function totalItems(): int
    {
        return count($this->session->get($this->cartKey) ?? []);
    }
}