<?php


class Migration_Add_General_Settings extends CI_Migration
{
    public function up() {
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment'=>true,
                    'null' => false
                ),
                'name'=> array(
                    'type'=>'VARCHAR',
                    'constraint' =>'255',
                    'null' => false
                ),
                'value'=> array(
                    'type'=>'VARCHAR',
                    'constraint' =>'255',
                    'null' => false
                ),
                //create field as strings because of codeigniter escaping the values
                'created TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            )
        );
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('general_settings');

    }

    public function down() {
        $this->dbforge->drop_table('general_settings');
    }

}