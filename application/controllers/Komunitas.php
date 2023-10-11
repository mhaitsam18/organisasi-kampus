<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komunitas extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		// $this->load->model('Komunitas_model');
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{

	}
	public function activated($id, $is_valid)
	{
		$this->db->where('id', $id);
		$this->db->update('komunitas', ['is_valid' => $is_valid]);
		if ($is_valid == 1) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Komunitas telah diaktifkan
				</div>');
		} else{
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Komunitas telah dinonaktifkan
				</div>');
		}
		redirect('Admin/komunitas');
	}
}
