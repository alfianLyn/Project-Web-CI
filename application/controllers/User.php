<?php
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function login()
    {
        if  (!isset($_SESSION['hakAkses'])){
        $this->load->view('login_view');
    } else {
        if($_SESSION["hakAkses"] == 'Book'){
            redirect("index.php/buku");
        } else if($_SESSION["hakAkses"] == 'Desk'){
            redirect("index.php/transaksi");
        } else if($_SESSION["hakAkses"] == 'Admin'){
            redirect("index.php/transaksi");
        } else {
        redirect("index.php/user/login");
    }
    }
    }

    public function ceklogin()
    {
        if(!isset($_SESSION["hakAkses"])){
            $user = $this->input->post('user', true);
            $pass = $this->input->post('pass', true);
            $cek = $this->user_model->proseslogin($user, $pass);
            $hasil = count($cek);

            if ($hasil > 0) {
                $pelogin = $this->db->get_where('petugas', array('IdPetugas' => $user, 'password' => $pass))->row();
                $hakAkses = $pelogin->hakAkses;
                $nama = $pelogin->NamaPetugas;
                $data = array('hakAkses' => $hakAkses, 'idPetugas' => $user, 'NamaPetugas' => $nama);
                $this->session->set_userdata($data);
                if($hakAkses == 'Book'){
                    redirect("index.php/buku");
                } else if($hakAkses == 'Desk'){
                    redirect("index.php/transaksi");
                } else if($hakAkses == 'Admin'){
                    redirect("index.php/transaksi");
                } else {
                redirect("index.php/user/login");
                }
            } else {
                redirect("index.php/user/login");
            }
        }
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect("index.php/user/login");
    }
}
?>
