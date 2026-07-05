<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddDeletedAtToMenus extends Migration
{
    public function up()
    {
        $this->forge->addColumn('menus', [
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
                'after'   => 'updated_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('menus', 'deleted_at');
    }
}