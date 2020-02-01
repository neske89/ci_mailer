<?php

use app\application\entities\SentEmailEntity;

class Sent_Email_model extends MY_Model
{
    CONST TABLE = 'sent_emails';
    /**
     * General_Settings_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array GeneralSettingsEntity
     * @throws Exception
     */
    public function save_sent_email(SentEmailEntity $sentEmail) {
        return $this->db->insert(static::TABLE,$sentEmail);
    }
    public function delete_sent_email($id) {
        return $this->db->delete(static::TABLE,['id'=>$id]);
    }
    public function get_sent_emails($where =[],$limit = null,$order = []) {
        $this->createQuery($where,$limit,$order);
        $query = $this->db->get(self::TABLE);
        return  $query->result();
    }

}