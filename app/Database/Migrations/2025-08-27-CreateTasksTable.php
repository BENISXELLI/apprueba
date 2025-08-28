<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTasksTable extends Migration
{
    public function up()
    {
        // Crear la base de datos si no existe (opcional)
        $this->db->query('CREATE DATABASE IF NOT EXISTS apprueba_db');
        $this->db->query('USE apprueba_db');

        // Crear la tabla
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'title'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false
            ],
            'completed'   => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'created_at'  => [
                'type'       => 'TIMESTAMP',
                'default'    => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tasks');
    }

    public function down()
    {
        $this->db->query('USE apprueba_db');
        $this->forge->dropTable('tasks', true);
    }
}

