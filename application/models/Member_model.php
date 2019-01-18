<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member_model extends CI_Model
{
    public function ambildata()
    {
        $result = $this->db->query('select * from member order by IdMember ASC');
        return $result;
    }

    // Fungsi Tambah Data
    public function tambahdata($data, $table)
    {
        $this->db->insert($table, $data);
    }

    public function ambilId($table, $where)
    {
        return $this->db->get_where($table, $where);
    }
    public function editdata($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function deleteData($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function get_columns()
    {
        $cols = $this->db->query("select * from member");
        return $cols;
    }
}
