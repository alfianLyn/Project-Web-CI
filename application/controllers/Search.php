<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('search_view');
    }

    public function user()
    {
        $query = '';
        $this->load->model('search_model');
        if  ($this->input->post('query'))
        {
            $query = $this->input->post('query');
        }
        $data = $this->search_model->search_data($query)->result();
        echo json_encode($data);
    }
}
