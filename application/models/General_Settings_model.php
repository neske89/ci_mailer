<?php

use app\application\entities\GeneralSettingsEntity;

class General_Settings_model extends CI_Model
{
    CONST TABLE = 'general_settings';
    /**
     * General_Settings_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param array $where
     * @param null|integer $limit
     * @return array GeneralSettingsEntity
     * @throws Exception
     */
    public function get_smtp_settings($where =[],$limit = null,$order = []) {
        foreach ($where as $column => $value){
            if (is_array($value)) {
                $this->db->where_in($column,$value);
            }
            else {
                $this->db->where($column,$value);
            }
        }
        foreach ($order as $column => $value){
                $this->db->order_by($column,$value);
        }
        if (!empty($limit)) {
            $this->db->limit($limit);
        }
        $query = $this->db->get(self::TABLE);
        $results = $query->result();
        $returnArray = [];
        foreach ($results as $result) {
            //store name as index for easier access when setting up SMTP
            $returnArray[$result->name] = GeneralSettingsEntity::FromArray($result);
        }
        return $returnArray;
    }

    public function insert_batch($data) {
        return $this->db->insert_batch(self::TABLE,$data);
    }

    public function delete($id) {
        return $this->db->delete(self::TABLE,array('id'=>$id));
    }

}