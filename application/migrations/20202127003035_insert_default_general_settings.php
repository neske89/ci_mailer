<?php


class Migration_Insert_Default_General_Settings extends CI_Migration
{
    //insert default SMTP settings as migration as they are provided in SQL file
    public function up() {
        if ( $this->db->table_exists($this->_migration_table)) {
            $data = array (
                array('id'=>1, 'name'=>'smtp_host', 'value'=>'smtp_host', 'created'=>'2016-10-06 00:00:00','modified'=> '0000-00-00 00:00:00'),
                array('id'=>6, 'name'=>'smtp_ssl', 'value'=>'smtp_ssl', 'created'=>'2016-10-06 00:00:00','modified'=> '2016-10-06 00:00:00'),
                array('id'=>3, 'name'=>'smtp_port', 'value'=>'smtp_port', 'created'=>'2016-10-06 00:00:00','modified'=> '2016-10-06 00:00:00'),
                array('id'=>4, 'name'=>'smtp_username', 'value'=>'smtp_username', 'created'=>'2016-10-06 00:00:00','modified'=> '2016-10-06 00:00:00'),
                array('id'=>5, 'name'=>'smtp_password', 'value'=>'smtp_password', 'created'=>'2016-10-06 00:00:00','modified'=> '2016-10-06 00:00:00'),
                array('id'=>7, 'name'=>'smtp_tls', 'value'=>'smtp_tls', 'created'=>'2016-10-06 00:00:00','modified'=> '2016-10-06 00:00:00')
            );
            $this->db->insert_batch('general_settings',$data);
        }
        else {
            throw new \RuntimeException('general_settings table does not exist!');
        }
    }

    public function down() {
        //id's hardcoded from above query and database_schema.sql
        $this->db->where_in('id',array(1,3,4,5,6,7));
        $this->db->delete('general_settings');
    }

}