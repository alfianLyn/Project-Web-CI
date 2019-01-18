<?php
class User_model extends CI_Model{

    // Fungsi untuk memasukkan data register ke tabel user
    public function prosesregister($user,$pass, $level){
        $data = array(
        'username' => $user,
        'password' => $pass,
        'level' => $level
        );
        $this->db->insert('user',$data);
    }

    // Check database
    public function proseslogin($user,$pass){
        $this->db->where('IdPetugas', $user);
        $this->db->where('password', $pass);
        return $this->db->get('petugas')->row();
    }

}