<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search_model extends CI_Model
{
    public function search_data($query)
    {
        $this->db->select("*");
        $this->db->from("user");
        if  ($query != '')
        {
            $this->db->like('username', $query);
            $this->db->or_like('level', $query);
        }
        $this->db->order_by('username', 'DESC');
        return $this->db->get();
    }
}
