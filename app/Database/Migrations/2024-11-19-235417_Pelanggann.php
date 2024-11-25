<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggann extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pelanggan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_pelanggan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'no_tlp' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addKey('id_pelanggan', true);
        $this->forge->createTable('tb_pelanggan');
    }
    
    public function down()
    {
        $this->forge->dropTable('tb_pelanggan');
    }
}
