<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_model');
    }

    public function index()
    {
        $this->load->view('member_view');
    }
    // Fungsi Mengambil data dari Database dan menampilkannya di View
    public function getdata()
    {
        $datamember = $this->member_model->ambildata('member')->result();
        echo json_encode($datamember);
    }
    // fungsi tambah data
    public function tambahdata()
    {
        $IdMember = $this->input->post('IdMember');
        $IdPetugas = $this->session->userdata('idPetugas');
        $nama = $this->input->post('nama');
        $jk = $this->input->post('jk');
        $alamat = $this->input->post('alamat');
        $telp = $this->input->post('telp');
        
        if ($IdMember == ''){
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
        } else if ($jk == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Jenis Kelamin belum terisi.
            </div>';
        }else if ($telp == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Nomor Telepon belum terisi.
            </div>';
        } else {
            $result['pesan'] = "";

            $data = array(
                'IdMember' => $IdMember,
                'IdPetugas' => $IdPetugas,
                'NamaMember' => $nama,
                'JenisKelamin' => $jk,
                'Alamat' => $alamat,
                'Tlp' => $telp
            );
            $this->member_model->tambahdata($data, 'member');
        }

        echo json_encode($result);
    }
    
    public function ambilId(){
        $idmember = $this->input->post('IdMember');
        $where = array('IdMember'=>$idmember);
        $datamember = $this->member_model->ambilId('member',$where)->result();

        echo json_encode($datamember);
    }

    public function editdata(){
        $IdMember = $this->input->post('IdMember');
        $IdPetugas = $this->session->userdata('idPetugas');
        $nama = $this->input->post('nama');
        $jk = $this->input->post('jk');
        $alamat = $this->input->post('alamat');
        $telp = $this->input->post('telp');
        // if ($IdMember == ''){
        //     $result['pesan'] = '<div class="alert alert-warning">
        //     <strong>Warning!</strong> Username belum terisi.
        //     </div>';
        // } else if ($nama == '') {
        //     $result['pesan'] = '<div class="alert alert-warning">
        //     <strong>Warning!</strong> Nama anda belum terisi.
        //     </div>';
        // } else if ($alamat == '') {
        //     $result['pesan'] = '<div class="alert alert-warning">
        //     <strong>Warning!</strong> Alamat belum terisi.
        //     </div>';
        // } else if ($jk == '') {
        //     $result['pesan'] = '<div class="alert alert-warning">
        //     <strong>Warning!</strong> Jenis Kelamin belum terisi.
        //     </div>';
        // } else if ($telp == '') {
        //     $result['pesan'] = '<div class="alert alert-warning">
        //     <strong>Warning!</strong> Nomor Telepon belum terisi.
        //     </div>';
        // } else {
            $result['pesan'] = "";

            $where = array('IdMember'=>$IdMember);

            $data = array(
                'IdMember' => $IdMember,
                'idPetugas' => $IdPetugas,
                'NamaMember' => $nama,
                'JenisKelamin' => $jk,
                'Alamat' => $alamat,
                'Tlp' => $telp
            );
            $this->member_model->editdata($where, $data, 'member');
        // }
        echo json_encode($result);
    }

    public function deleteData(){
        $IdMember = $this->input->post('IdMember');
        $where = array('IdMember'=>$IdMember);
        $this->member_model->deleteData($where, 'member');
    }
    
    public function export_csv(){
	// Load DB Utility Class
	$this->load->dbutil();

	$query = $this->member_model->get_columns();
	$data = $this->dbutil->csv_from_result($query);

	$dbname='exp-' . date("Y-m-d-H-i-s") . '.csv';
	$this->load->helper('download');
	force_download($dbname, $data);
    }
    function export_sql(){
    	$this->load->dbutil();

	$prefs = array(
		'tables' => array('member'),
		'format' => 'txt',
		'filename' => 'snippets.sql'
	);

	$backup =& $this->dbutil->backup($prefs);
	$db_name = 'snippets-' . date("Y-m-d-H-i-s") . '.sql';

	$this->load->helper('file');
	write_file('backup_db/' . $db_name, $backup);
    }

}
