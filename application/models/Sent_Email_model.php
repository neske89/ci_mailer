<?php

use app\application\entities\SentEmailEntity;

class Sent_Email_model extends CI_Model
{
    CONST TABLE = 'sent_emails';
    /**
     * General_Settings_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @return array GeneralSettingsEntity
     * @throws Exception
     */
    public function save_sent_email(SentEmailEntity $sentEmail) {
        return $this->db->insert(static::TABLE,$sentEmail);
    }

}