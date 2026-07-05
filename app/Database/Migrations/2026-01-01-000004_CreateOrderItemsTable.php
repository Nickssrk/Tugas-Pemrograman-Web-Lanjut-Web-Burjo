<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'menu_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'nama_menu' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'harga_menu' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'jumlah' => [
                'type'     => 'INT',
                'unsigned' => true,
                'default'  => 1,
            ],
            'subtotal' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('order_id');
        $this->forge->createTable('order_items');
    }

    public function down(): void
    {
        $this->forge->dropTable('order_items');
    }
}
