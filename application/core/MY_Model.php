<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//annotate for autocomplete

class MY_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    protected function createQuery($where =[],$limit = null,$order = []) {
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
    }
}
