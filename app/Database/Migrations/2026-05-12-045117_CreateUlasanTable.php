<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUlasanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'pelanggan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'rating' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 5,
            ],
            'komentar' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addForeignKey('id_barang', 'barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pelanggan_id', 'pelanggan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ulasan');
    }

    public function down()
    {
        $this->forge->dropTable('ulasan');
    }
}