<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Petugas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('petugas_model');
    }

    public function index()
    {
        $this->load->view('petugas_view');
    }
    // Fungsi Mengambil data dari Database dan menampilkannya di View
    public function getdata()
    {
        $datapetugas = $this->petugas_model->ambildata('petugas')->result();
        echo json_encode($datapetugas);
    }
    // fungsi tambah data
    public function tambahdata()
    {
        $IdPetugas = $this->input->post('IdPetugas');
        $pass = $this->input->post('password');
        $confpass = $this->input->post('confpass');
        $nama = $this->input->post('nama');
        $jk = $this->input->post('jk');
        $alamat = $this->input->post('alamat');
        $telp = $this->input->post('telp');
        $role = $this->input->post('role');
        
        if($pass != $confpass){
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Password yang anda masukkan tidak sama.
            </div>';
        } else if($pass == '' || $confpass == ''){
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Password atau Konfirmasi Password belum terisi.
            </div>';
        } else if ($IdPetugas == ''){
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Username belum terisi.
            </div>';
        } else if ($nama == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Nama anda belum terisi.
            </div>';
        } else if ($alamat == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Alamat belum terisi.
            </div>';
        } else if ($telp == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Nomor Telepon belum terisi.
            </div>';
        } else {
            $result['pesan'] = "";

            $data = array(
                'IdPetugas' => $IdPetugas,
                'password' => $pass,
                'NamaPetugas' => $nama,
                'jk' => $jk,
                'Alamat' => $alamat,
                'Tlp' => $telp,
                'hakAkses' => $role
            );
            $this->petugas_model->tambahdata($data, 'petugas');
        }

        echo json_encode($result);
    }
    
    public function ambilId(){
        $idPetugas = $this->input->post('IdPetugas');
        $where = array('IdPetugas'=>$idPetugas);
        $datapetugas = $this->petugas_model->ambilId('petugas',$where)->result();

        echo json_encode($datapetugas);
    }

    public function editdata(){
        $IdPetugas = $this->input->post('IdPetugas');
        $pass = $this->input->post('password');
        $confpass = $this->input->post('confpass');
        $nama = $this->input->post('nama');
        $jk = $this->input->post('jk');
        $alamat = $this->input->post('alamat');
        $telp = $this->input->post('telp');
        $role = $this->input->post('role');
        if($pass != $confpass){
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Password yang anda masukkan tidak sama.
            </div>';
        } else if($pass == '' || $confpass == ''){
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Password atau Konfirmasi Password belum terisi.
            </div>';
        } else if ($IdPetugas == ''){
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Username belum terisi.
            </div>';
        } else if ($nama == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Nama anda belum terisi.
            </div>';
        } else if ($alamat == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Alamat belum terisi.
            </div>';
        } else if ($telp == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Nomor Telepon belum terisi.
            </div>';
        } else {
            $result['pesan'] = "";

            $where = array('IdPetugas'=>$IdPetugas);

            $data = array(
                'IdPetugas' => $IdPetugas,
                'password' => $pass,
                'NamaPetugas' => $nama,
                'jk' => $jk,
                'Alamat' => $alamat,
                'Tlp' => $telp,
                'hakAkses' => $role
            );
            $this->petugas_model->editdata($where, $data, 'petugas');
        }
        echo json_encode($result);
    }

    public function deleteData(){
        $IdPetugas = $this->input->post('IdPetugas');
        $where = array('IdPetugas'=>$IdPetugas);
        $this->petugas_model->deleteData($where, 'petugas');
    }
    
    public function export_csv(){
	// Load DB Utility Class
	$this->load->dbutil();

	$query = $this->petugas_model->get_columns();
	$data = $this->dbutil->csv_from_result($query);

	$dbname='exp-' . date("Y-m-d-H-i-s") . '.csv';
	$this->load->helper('download');
	force_download($dbname, $data);
    }
    function export_sql(){
    	$this->load->dbutil();

	$prefs = array(
		'tables' => array('petugas'),
		'format' => 'txt',
		'filename' => 'snippets.sql'
	);

	$backup =& $this->dbutil->backup($prefs);
	$db_name = 'snippets-' . date("Y-m-d-H-i-s") . '.sql';

	$this->load->helper('file');
	write_file('backup_db/' . $db_name, $backup);
    }

}
