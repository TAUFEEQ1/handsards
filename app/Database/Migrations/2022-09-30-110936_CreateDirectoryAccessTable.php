<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDirectoryAccessTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => FALSE,
            ],
            'publish_date' => [
                'type' => 'DATE',
                'unique' => TRUE,
                'null' => FALSE
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('directory_access');
    }

    public function down()
    {
        //
        $this->forge->dropTable('directory_access');
    }
}
