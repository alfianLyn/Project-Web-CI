<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi_model');
    }

    public function index()
    {
        $this->load->view('transaksi_view');
    }
    // Fungsi Mengambil data dari Database dan menampilkannya di View
    public function getdata()
    {
        $databuku = $this->transaksi_model->ambildata('peminjaman')->result();
        echo json_encode($databuku);
    }
    // fungsi tambah data
    public function pinjamBuku()
    {
        $idBuku = $this->input->post('IdBuku');
        $idPetugas = $this->session->userdata('idPetugas');
        $idMember = $this->input->post('IdMember');
        $dateNow = date("Y-m-d");

        if ($idBuku == ''){
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> ID Buku belum terisi.
            </div>';
        } else if ($idMember == '') {
            $result['pesan'] = '<div class="alert alert-warning">
            <strong>Warning!</strong> ID Member belum terisi.
            </div>';
        } else {
            $result['pesan'] = "";

            $data = array(
                'IdBuku' => $idBuku,
                'IdPetugas' => $idPetugas,
                'IdMember' => $idMember,
                'JumlahPinjam' => "1",
                'TglPinjam' => $dateNow,
                'status' => "Pinjam"
            );
            $this->transaksi_model->pinjambuku($data, 'pinjam');
        }

        echo json_encode($result);
    }
    
    public function kembalikanBuku(){
        $idPinjam = $this->input->post('idPinjam');
        $dateNow = date("Y-m-d");
        $where = array('idPinjam'=>$idPinjam);

        $result['pesan'] = "";

        $data = array(
            'TglKembali' => $dateNow,
            'status' => "Kembali"
        );
        $this->transaksi_model->kembalikanBuku('pinjam', $where, $data);
        echo json_encode($result);
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
            $this->buku_model->editdata($where, $data, 'pinjam');
        }
        echo json_encode($result);
    }

    public function deleteData(){
        $idPinjam = $this->input->post('idPinjam');
        $where = array('idPinjam'=>$idPinjam);
        $this->transaksi_model->deleteData($where, 'pinjam');
    }

    public function export_csv(){
	// Load DB Utility Class
	$this->load->dbutil();

	$query = $this->transaksi_model->get_columns();
	$data = $this->dbutil->csv_from_result($query);

	$dbname='exp-' . date("Y-m-d-H-i-s") . '.csv';
	$this->load->helper('download');
	force_download($dbname, $data);
    }
    function export_sql(){
    	$this->load->dbutil();

	$prefs = array(
		'tables' => array('pinjam'),
		'format' => 'txt',
		'filename' => 'snippets.sql'
	);

	$backup =& $this->dbutil->backup($prefs);
	$db_name = 'snippets-' . date("Y-m-d-H-i-s") . '.sql';

	$this->load->helper('file');
	write_file('backup_db/' . $db_name, $backup);
    }
    public function kembali()
    {
        $this->load->view('pengembalian_view');
    }
    // Fungsi Mengambil data dari Database dan menampilkannya di View
    public function getkembali()
    {
        $databuku = $this->transaksi_model->ambilkembali('kembali')->result();
        echo json_encode($databuku);
    }
}
