<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku_model extends CI_Model
{
    public function ambildata()
    {
        $result = $this->db->query('select * from buku order by idBuku ASC');
        return $result;
    }
    // Fungsi Tambah Data
    public function tambahdata($data, $table)
    {
        $this->db->insert($table, $data);
    }

    public function ambilBuku($table, $where)
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
        $cols = $this->db->query("select * from buku");
        return $cols;
    }
}
