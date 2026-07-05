<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table         = 'order_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'order_id', 'menu_id', 'nama_menu',
        'harga_menu', 'jumlah', 'subtotal',
    ];
}
