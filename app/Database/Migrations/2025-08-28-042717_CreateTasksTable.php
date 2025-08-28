<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTasksTable extends Migration
{
     public function up()
    {
        // Definir campos
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'completed' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,  
            ],
        ]);

        // Clave primaria
        $this->forge->addKey('id', true);

        // Crear tabla
        $this->forge->createTable('tasks', true);
    }

    public function down()
    {
        // Eliminar tabla si existe
        $this->forge->dropTable('tasks', true);
    }
}
