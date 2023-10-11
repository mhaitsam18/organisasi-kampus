<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organisasi extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		$this->load->model('Organisasi_model');
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{

	}
	public function activated($id, $status)
	{
		$this->db->where('id', $id);
		$this->db->update('organisasi', ['status' => $status]);
		if ($status == 1) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Organisasi telah diaktifkan
				</div>');
		} else{
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Organisasi telah dinonaktifkan
				</div>');
		}
		redirect('Admin/organisasi');
	}
}
