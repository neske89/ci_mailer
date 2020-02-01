<?php

use app\application\entities\GeneralSettingsEntity;

class General_Settings_model extends MY_Model
{
    CONST TABLE = 'general_settings';
    /**
     * General_Settings_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $where
     * @param null|integer $limit
     * @return array GeneralSettingsEntity
     * @throws Exception
     */
    public function get_smtp_settings($where =[],$limit = null,$order = []) {
       $this->createQuery($where,$limit,$order);
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
    public function delete_batch($ids) {
        $this->db->where_in('id',$ids);
        return $this->db->delete(self::TABLE);
    }



}