<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataMaster extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('DataMaster_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$data['title'] = "Data Master";
		$data['dataMaster'] = $this->db->get_where('user_sub_menu',['menu_id' => 14])->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('data-master/index', $data);
		$this->load->view('templates/footer');
	}

	public function agama()
	{
		$data['title'] = "Data Agama";
		$data['agama'] = $this->db->get('agama')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('agama', 'Religion Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-agama', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('agama', [
				'agama' => $this->input->post('agama')
			]);
			$this->session->set_flashdata('flash', 'Berhasil ditambahkan');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Religion Added!
				</div>');
			redirect('DataMaster/agama');
		}
	}

	public function metodeBayar()
	{
		$data['title'] = "Data Metode Bayar";
		$data['metodeBayar'] = $this->db->get('metode_bayar')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('metode_bayar', 'Payment Method', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-metode-bayar', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('metode_bayar', [
				'metode_bayar' => $this->input->post('metode_bayar')
			]);
			$this->session->set_flashdata('flash', 'Berhasil ditambahkan');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Payment Method Added!
				</div>');
			redirect('DataMaster/metodeBayar/');
		}
	}

	public function kategoriOrganisasi()
	{
		$data['title'] = "Data Kategori Organisasi";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['kategori_organisasi'] = $this->db->get('kategori_organisasi')->result_array();
		$this->form_validation->set_rules('kategori_organisasi', 'Kategori Organisasi', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-kategori-organisasi', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('kategori_organisasi', [
				'kategori_organisasi' => $this->input->post('kategori_organisasi')
			]);
			$this->session->set_flashdata('flash', 'Berhasil ditambahkan');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Organization Categories Added!
				</div>');
			redirect('DataMaster/kategoriOrganisasi/');
		}
	}

	public function deleteAgama($id)
	{
		$this->db->delete('agama', ['id' => $id]);
		$this->session->set_flashdata('flash', 'Berhasil dihapus');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Religion Deleted!
			</div>');
		redirect('DataMaster/agama');
	}

	public function deleteMetodeBayar($id)
	{
		$this->db->delete('metode_bayar', ['id' => $id]);
		$this->session->set_flashdata('flash', 'Berhasil dihapus');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Payment Method Deleted!
			</div>');
		redirect('DataMaster/metodeBayar');
	}

	public function deleteKategoriOrganisasi($id)
	{
		$this->db->delete('kategori_organisasi', ['id' => $id]);
		$this->session->set_flashdata('flash', 'Berhasil dihapus');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Organization Category Deleted!
			</div>');
		redirect('DataMaster/kategoriOrganisasi');
	}

	public function updateAgama()
	{
		$this->form_validation->set_rules('agama', 'Religion Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/agama');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('agama', [
				'agama' => $this->input->post('agama')
			]);
			$this->session->set_flashdata('flash', 'Berhasil diubah');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Religion Updated!
				</div>');
			redirect('DataMaster/agama');
		}
	}
	
	public function updateMetodeBayar()
	{
		$this->form_validation->set_rules('metode_bayar', 'Payment Method', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/metodeBayar');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('metode_bayar', [
				'metode_bayar' => $this->input->post('metode_bayar')
			]);
			$this->session->set_flashdata('flash', 'Berhasil diubah');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Payment Method Updated!
				</div>');
			redirect('DataMaster/metodeBayar');
		}
	}
	
	public function updateKategoriOrganisasi()
	{
		$this->form_validation->set_rules('kategori_organisasi', 'Category', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->kategoriOrganisasi();
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('kategori_organisasi', [
				'kategori_organisasi' => $this->input->post('kategori_organisasi')
			]);
			$this->session->set_flashdata('flash', 'Berhasil diubah');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Organizations Category Updated!
				</div>');
			redirect('DataMaster/kategoriOrganisasi');
		}
	}
	
	public function dashboard()
	{
		$data['title'] = "Data Dashboard";
		$data['dashboard'] = $this->db->get('dashboard')->row_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('header', 'Header', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		$this->form_validation->set_rules('footer', 'Footer', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-dashboard', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('dashboard', [
				'header' => $this->input->post('header'),
				'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'footer' => $this->input->post('footer'),
				'icon' => $this->input->post('icon')
			]);
			$this->session->set_flashdata('flash', 'Berhasil diubah');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Content Updated!
				</div>');
			redirect('DataMaster/dashboard');
		}
	}

	
	public function getUpdateAgama(){
		echo json_encode($this->DataMaster_model->getAgamaById($this->input->post('id')));
	}
	public function getUpdateMetodeBayar(){
		echo json_encode($this->DataMaster_model->getMetodeBayarById($this->input->post('id')));
	}
	public function getUpdateKategoriOrganisasi(){
		echo json_encode($this->DataMaster_model->getKategoriOrganisasiById($this->input->post('id')));
	}
	
}