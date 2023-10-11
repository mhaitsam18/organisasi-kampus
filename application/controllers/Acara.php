<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acara extends CI_Controller {

	public function __construct(){    
		parent::__construct();
		$this->load->model('Acara_model'); 
	}

	public function index(){

		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		
		{
		$data['title'] = 'Dashboard Admin';
		$data['acara'] = $this->AcaraModel->view();
		//$data['acara'] = $this->db->get_where('acara', ['id_acara' => $this->session->userdata('id_acara')])->row_array();

		
		$this->load->view('admin/kelola_acara', $data);
		}

		$this->load->view('templates/footer');
	}

	public function tambah(){

		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

	  	if($this->input->post('submit')){ 
	  // Jika user mengklik tombol submit yang ada di form      
	  		if($this->AcaraModel->validation("save")){ 
	  		// Jika validasi sukses atau hasil validasi adalah TRUE        
	  			$this->AcaraModel->save(); 
      
	  				redirect('acara');      
	  		}    
		}   		
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);     
			$this->load->view('admin/form_tambah');
			$this->load->view('templates/footer');  
	}    

	public function ubah($id_acara){  
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();  

		if($this->input->post('fdf_set_submit_form_action(fdf_document, fieldname, trigger, script, flags)')){ // Jika user mengklik tombol submit yang ada di form      
			if($this->AcaraModel->validation("update")){ // Jika validasi sukses atau hasil validasi adalah TRUE        
				$this->AcaraModel->edit($id_acara);         
				redirect('Acara');      
			}    
		}        

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);     
			$data['acara'] = $this->AcaraModel->view_by($id_acara);    
			$this->load->view('admin/form_ubah', $data);  

			$this->load->view('templates/footer');
	
		}    

	public function hapus($id_acara){    
		$this->AcaraModel->delete($id_acara);   
		redirect('acara');  
	}
}