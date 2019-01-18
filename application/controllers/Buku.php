<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('buku_model');
    }

    public function index()
    {
        $this->load->view('buku_view');
    }
    // Fungsi Mengambil data dari Database dan menampilkannya di View
    public function getdata()
    {
        $databuku = $this->buku_model->ambildata('buku')->result();
        echo json_encode($databuku);
    }
    // fungsi tambah data
    public function tambahdata()
    {
        $idBuku = $this->input->post('IdBuku');
        $idPetugas = $this->session->userdata('idPetugas');
        $nama = $this->input->post('nama');
        $stock = $this->input->post('stock');

        if ($idBuku == ''){
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> ID Buku belum terisi.
            </div>';
        } else if ($nama == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Nama Buku belum terisi.
            </div>';
        } else if ($stock == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Stock Buku belum terisi.
            </div>';
        } else {
            $result['pesan'] = "";

            $data = array(
                'IdBuku' => $idBuku,
                'idPetugas' => $idPetugas,
                'NamaBuku' => $nama,
                'Stock' => $stock,
            );
            $this->buku_model->tambahdata($data, 'buku');
        }

        echo json_encode($result);
    }
    
    public function ambilBuku(){
        $idBuku = $this->input->post('IdBuku');
        $where = array('IdBuku'=>$idBuku);
        $databuku = $this->buku_model->ambilBuku('buku',$where)->result();

        echo json_encode($databuku);
    }

    public function editdata(){
        $idBuku = $this->input->post('IdBuku');
        $idPetugas = $this->session->userdata('idPetugas');
        $nama = $this->input->post('nama');
        $stock = $this->input->post('stock');
        if ($nama == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Nama Buku belum terisi.
            </div>';
        } else if ($stock == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> Stock Buku belum terisi.
            </div>';
        } else {
            $result['pesan'] = "";

            $where = array('IdBuku'=>$idBuku);

            $data = array(
                'IdBuku' => $idBuku,
                'idPetugas' => $idPetugas,
                'NamaBuku' => $nama,
                'Stock' => $stock
            );
            $this->buku_model->editdata($where, $data, 'buku');
        }
        echo json_encode($result);
    }

    public function deleteData(){
        $nim = $this->input->post('IdBuku');
        $where = array('IdBuku'=>$nim);
        $this->buku_model->deleteData($where, 'buku');
    }

    public function export_csv(){
	// Load DB Utility Class
	$this->load->dbutil();

	$query = $this->buku_model->get_columns();
	$data = $this->dbutil->csv_from_result($query);

	$dbname='exp-' . date("Y-m-d-H-i-s") . '.csv';
	$this->load->helper('download');
	force_download($dbname, $data);
    }
    function export_sql(){
    	$this->load->dbutil();

	$prefs = array(
		'tables' => array('buku'),
		'format' => 'txt',
		'filename' => 'snippets.sql'
	);

	$backup =& $this->dbutil->backup($prefs);
	$db_name = 'snippets-' . date("Y-m-d-H-i-s") . '.sql';

	$this->load->helper('file');
	write_file('backup_db/' . $db_name, $backup);
    }

}
