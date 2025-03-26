<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlacklistedTokensTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                "type" => "INT",
                "auto_increment" => true,
                "unsigned" => true
            ],
            'token' => [
                "type" => "TEXT",
                "null" => false
            ],
            'created_at datetime default current_timestamp'
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->createTable("blacklistedtokens");
    }

    public function down()
    {
        //
        $this->forge->dropTable('blacklistedtokens');
    }
}
