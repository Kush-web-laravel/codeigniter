<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'usigned' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => 50
            ],
            'gender' => [
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => 20
            ],
            'email' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => 50
            ],
            'phone_no' => [
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => 20
            ],
            'created_at datetime default current_timestamp'
        ]);
        $this->forge->addPrimaryKey("id");
        $this->forge->createTable('students');
    }

    public function down()
    {
        //
        $this->forge->dropTable('students');
    }
}
