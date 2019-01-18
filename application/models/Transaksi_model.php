<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{
    public function ambildata()
    {
        $result = $this->db->query('select * from peminjaman order by idPinjam ASC');
        return $result;
    }
    // Fungsi Tambah Data
    public function pinjambuku($data, $table)
    {
        $this->db->insert($table, $data);
    }

    public function kembalikanBuku($table, $where, $data)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
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

    public function ambilkembali()
    {
        $result = $this->db->query('select * from kembali');
        return $result;
    }

    public function get_columns()
    {
        $cols = $this->db->query("select * from pinjam");
        return $cols;
    }
}
