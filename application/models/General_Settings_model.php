<?php
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

    public function get_smtp_settings() {
        $query = $this->db->get(self::TABLE);
        $results = $query->result();
        $returnArray = [];
        foreach ($results as $result) {
            //store name as index for easier access when setting up SMTP
            $returnArray[$result->name] = \app\application\entities\GeneralSettingsEntity::FromArray($result);
        }
        return $returnArray;
    }

}