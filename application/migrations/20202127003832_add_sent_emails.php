<?php


class Migration_Add_Sent_Emails extends CI_Migration
{
    //insert default SMTP settings as migration as they are provided in SQL file
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
            'to_email'=> array(
                'type'=>'VARCHAR',
                'constraint' =>'255',
                'null' => false
            ),
            'subject'=> array(
                'type'=>'VARCHAR',
                'constraint' =>'255',
                'null' => false
            ),
            'body'=> array(
                'type'=>'TEXT',
                'null' => false
            ),
            //create field as strings because of codeigniter escaping the values
            'created TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',

        )
        );
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('sent_emails');
    }

    public function down() {
        //id's hardcoded from above query and database_schema.sql
        $this->dbforge->drop_table('sent_emails');
    }

}