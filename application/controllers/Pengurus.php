<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengurus extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('Acara_model');
		$this->load->model('Panitia_model');
		$this->load->model('Tiket_model');
		$this->load->model('Pengurus_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$data['title'] = "Beranda";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['dashboard'] = $this->db->get('dashboard')->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('pengurus/index', $data);
		$this->load->view('templates/footer');
	}

	public function organisasi($id_organisasi = null)
	{
		$data['title'] = "Profil Organisasi";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->where_in('role_id', [0,2]);
		$data['member'] = $this->db->get('user')->result_array();
		
		$this->db->select('*, organisasi.id AS ido');
		$this->db->join('kategori_organisasi', 'kategori_organisasi.id = organisasi.id_kategori_organisasi', 'LEFT');

		if ($id_organisasi) {
			$data['organisasi'] = $this->db->get_where('organisasi', ['organisasi.id' => $id_organisasi])->row_array();
		} else{
			$data['organisasi'] = $this->db->get_where('organisasi', ['id_pengurus' => $data['user']['id']])->row_array();
		}
		
		$data['kategori_organisasi'] = $this->db->get('kategori_organisasi')->result_array();

		$this->form_validation->set_rules('nama_organisasi', 'Organization', 'trim|required');
		if ($this->form_validation->run() ==  false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('pengurus/profil-organisasi', $data);
			$this->load->view('templates/footer');
		} else{
			$upload_image = $_FILES['logo']['name'];
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
				$config['upload_path'] = './assets/img/logo-organisasi';
				$config['max_size']     = '500000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('logo')) {
					$old_image = $data['organisasi']['logo'];
					if ($old_image !='default.png') {
						unlink(FCPATH.'assets/img/logo-organisasi/'.$old_image);
					} 
					$new_image = $this->upload->data('file_name');
					$this->db->set('logo', $new_image);
				} else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
					redirect('Pengurus/organisasi');
				}
			}

			$data = [
				'nama_organisasi' => $this->input->post('nama_organisasi'),
				'singkatan' => $this->input->post('singkatan'),
				'deskripsi' => $this->input->post('deskripsi'),
				'id_kategori_organisasi' => $this->input->post('id_kategori_organisasi')
			];
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('organisasi', $data);
			$this->session->set_flashdata('flash', 'Berhasil diubah');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Congratulation! Your organization profile has been updated!
				</div>');
			redirect('pengurus/organisasi');
		}
	}

	public function kirimUndangan()
	{
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$organisasi = $this->db->get_where('organisasi', ['id' => $this->input->post('idOrganisasi')])->row_array();
		$this->db->insert('ikuti_organisasi', [
			'id_organisasi' => $this->input->post('idOrganisasi'),
			'id_user' => $this->input->post('idUser'),
			'status' => 0,
		]);
		$this->db->insert('notifikasi', [
			'id_user' => $this->input->post('idUser'),
			'id_kategori_notifikasi' => 4,
			'sub_id' => $this->db->insert_id(),
			'waktu_notifikasi' => date('Y-m-d H:i:s'),
			'subjek' => 'Undangan Organisasi',
			'pesan' => 'Undangan '.$organisasi['nama_organisasi'],
			'is_read' => 0,
			'id_creator' => $user['id']
		]);
		// $this->session->set_flashdata('flash', 'Telah difollow');
		// $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
		// 	Undangan Terkirim!
		// 	</div>');
		// redirect("Member/organisasi/");
	}

	public function acara()
	{
		$data['title'] = "Data Acara";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, acara.id AS aid');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$this->db->where('id_pengurus', $data['user']['id']);
		$data['acara'] = $this->db->get('acara')->result_array();
		$data['organisasi'] = $this->db->get_where('organisasi', ['id_pengurus' => $this->session->userdata('id') ])->result_array();
		$this->form_validation->set_rules('nama_acara', 'Event', 'trim|required');
		// $this->form_validation->set_rules('penyelenggara', 'Organizer', 'trim|required');
		$this->form_validation->set_rules('tanggal_dimulai', 'Time', 'trim|required');
		$this->form_validation->set_rules('tanggal_berakhir', 'Time', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'Information', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('pengurus/acara', $data);
			$this->load->view('templates/footer');
		} else{
			$upload_image = $_FILES['poster']['name'];
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
				$config['upload_path'] = './assets/img/acara';
				$config['max_size']     = '2048';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('poster')) {
					$new_image = $this->upload->data('file_name');
					$this->db->insert('acara', [
						'id_organisasi' => $this->input->post('id_organisasi'),
						'nama_acara' => $this->input->post('nama_acara'),
						// 'penyelenggara' => $this->input->post('penyelenggara'),
						'tanggal_dimulai' => $this->input->post('tanggal_dimulai'),
						'waktu_dimulai' => $this->input->post('waktu_dimulai'),
						'tanggal_berakhir' => $this->input->post('tanggal_berakhir'),
						'waktu_berakhir' => $this->input->post('waktu_berakhir'),
						'poster' => $new_image,
						'keterangan' => $this->input->post('keterangan'),
						'tanggal_dibuat' => date('Y-m-d h:i:s'),
					]);
					$this->session->set_flashdata('flash', 'Berhasil ditambahkan');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
						New Event Added!
						</div>');
				} else{
					$this->session->set_flashdata('flash_error', 'Gagal diunggah');
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
				}
			} else{
				$this->session->set_flashdata('flash_gagal', 'poster pengumuman Wajib diupload');
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					poster Acara Wajib diupload!
					</div>');
			}
			redirect('Pengurus/acara');
		}
	}

	public function waktu_diakhiri($date)
	{
		$data['date'] = $date;
		$this->load->view('pengurus/waktu-diakhiri', $data);
	}

	public function updateAcara()
	{
		$upload_image = $_FILES['poster']['name'];
		if ($upload_image) {
			$config['allowed_types'] = 'gif|jpg|png|svg';
			$config['upload_path'] = './assets/img/acara';
			$config['max_size']     = '2048';
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('poster')) {
				$old_image = $data['user']['poster'];
				if ($old_image !='default.jpg') {
					unlink(FCPATH.'assets/img/acara/'.$old_image);
				} 
				$new_image = $this->upload->data('file_name');
				$this->db->set('poster', $new_image);
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
				redirect('Pengurus/acara');
			}
		}

		$data = [
			'nama_acara' => $this->input->post('nama_acara'),
			'penyelenggara' => $this->input->post('penyelenggara'),
			'tanggal_dimulai' => $this->input->post('tanggal_dimulai'),
			'waktu_dimulai' => $this->input->post('waktu_dimulai'),
			'tanggal_berakhir' => $this->input->post('tanggal_berakhir'),
			'waktu_berakhir' => $this->input->post('waktu_berakhir'),
			'keterangan' => $this->input->post('keterangan')
		];
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('acara', $data);
		$this->session->set_flashdata('flash', 'Berhasil diubah');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Congratulation! Your Event has been updated!
			</div>');
		redirect('Pengurus/acara');
	}


	public function deleteAcara($id)
	{
		$this->db->delete('acara', ['id' => $id]);
		$this->session->set_flashdata('flash', 'Berhasil dihapus');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Event Deleted!
			</div>');
		redirect('Pengurus/acara');
	}

	public function getUpdateAcara(){
		echo json_encode($this->Pengurus_model->getAcaraById($this->input->post('id')));
	}

	public function tiket($id_acara = null)
	{
		$data['title'] = "Data Tiket";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, tiket.id AS idt');
		if ($id_acara) {
			$this->db->where('id_acara', $id_acara);
		} else{
			$this->db->where('id_pengurus', $data['user']['id']);
		}
		$this->db->join('acara', 'tiket.id_acara=acara.id');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$data['tiket'] = $this->db->get('tiket')->result_array();
		$this->db->select('*, acara.id AS aid');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$this->db->where('id_pengurus', $data['user']['id']);
		$data['acara'] = $this->db->get('acara')->result_array();
		$this->form_validation->set_rules('harga', 'Price', 'trim|required');
		$this->form_validation->set_rules('id_acara', 'Event', 'trim|required|is_unique[tiket.id_acara]', array(
			'is_unique' => 'Data Tiket Sudah Tersedia'
		));
		$this->form_validation->set_rules('stok_tiket', 'Stock', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('pengurus/tiket', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('tiket', [
				'harga' => $this->input->post('harga'),
				'id_acara' => $this->input->post('id_acara'),
				'stok_tiket' => $this->input->post('stok_tiket'),
				'jumlah_terjual' => 0
			]);
			$this->session->set_flashdata('flash', 'Berhasil ditambahkan');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Ticket Added!
				</div>');
			redirect('Pengurus/tiket');
		}
	}

	public function updateTiket()
	{
		$data = [
			'harga' => $this->input->post('harga'),
			'stok_tiket' => $this->input->post('stok_tiket')
		];
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('tiket', $data);
		$this->session->set_flashdata('flash', 'Berhasil diubah');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Congratulation! Your Ticket has been updated!
			</div>');
		redirect('Pengurus/tiket');
	}


	public function deleteTiket($id)
	{
		$this->db->delete('tiket', ['id' => $id]);
		$this->session->set_flashdata('flash', 'Berhasil dihapus');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Ticket Deleted!
			</div>');
		redirect('Pengurus/tiket');
	}

	public function getUpdateTiket(){
		echo json_encode($this->Pengurus_model->getTiketById($this->input->post('id')));
	}

	public function rekruitasi($id_acara = null)
	{
		$data['title'] = "Data Rekruitasi";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, rekruitasi.id AS idr');
		if ($id_acara) {
			$this->db->where('id_acara', $id_acara);
		} else{
			$this->db->where('id_pengurus', $data['user']['id']);
		}
		
		$this->db->join('acara', 'rekruitasi.id_acara=acara.id');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$data['rekruitasi'] = $this->db->get('rekruitasi')->result_array();
		
		$this->db->select('*, acara.id AS aid');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$this->db->where('id_pengurus', $data['user']['id']);
		$data['acara'] = $this->db->get('acara')->result_array();
		// $this->form_validation->set_rules('batas_waktu', 'Deadline', 'trim|required');
		$this->form_validation->set_rules('batas_tanggal', 'Deadline', 'trim|required');
		$this->form_validation->set_rules('batas_jam', 'Deadline', 'trim|required');
		$this->form_validation->set_rules('id_acara', 'Event', 'trim|required|is_unique[rekruitasi.id_acara]', array(
			'is_unique' => 'Data Rekruitasi Sudah Tersedia'
		));
		$this->form_validation->set_rules('catatan', 'Note', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('pengurus/rekruitasi', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('rekruitasi', [
				'id_acara' => $this->input->post('id_acara'),
				'batas_waktu' => $this->input->post('batas_tanggal').' '.$this->input->post('batas_jam'),
				'catatan' => $this->input->post('catatan')
			]);
			$this->session->set_flashdata('flash', 'Berhasil ditambahkan');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Recruitment Added!
				</div>');
			redirect('Pengurus/rekruitasi');
		}
	}

	public function updateRekruitasi()
	{
		$data = [
			'batas_waktu' => $this->input->post('batas_waktu'),
			'catatan' => $this->input->post('catatan')
		];
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('rekruitasi', $data);
		$this->session->set_flashdata('flash', 'Berhasil diubah');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Congratulation! Your Recruitment has been updated!
			</div>');
		redirect('Pengurus/rekruitasi');
	}


	public function deleteRekruitasi($id)
	{
		$this->db->delete('rekruitasi', ['id' => $id]);
		$this->session->set_flashdata('flash', 'Berhasil dihapus');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Recruitment Deleted!
			</div>');
		redirect('Pengurus/rekruitasi');
	}

	public function getUpdateRekruitasi(){
		echo json_encode($this->Pengurus_model->getRekruitasiById($this->input->post('id')));
	}

	public function divisi($id_rekruitasi = null)
	{
		$data['title'] = "Data Divisi";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, divisi.id AS idd');
		if ($id_rekruitasi) {
			$this->db->where('id_rekruitasi', $id_rekruitasi);
		} else{
			$this->db->where('id_pengurus', $data['user']['id']);
		}
		
		$this->db->join('rekruitasi', 'divisi.id_rekruitasi=rekruitasi.id');
		$this->db->join('acara', 'rekruitasi.id_acara=acara.id');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$data['divisi'] = $this->db->get('divisi')->result_array();
		
		$this->db->select('*, rekruitasi.id AS idr');
		$this->db->where('id_pengurus', $data['user']['id']);
		$this->db->join('acara', 'rekruitasi.id_acara=acara.id');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$data['rekruitasi'] = $this->db->get('rekruitasi')->result_array();
		$this->form_validation->set_rules('id_rekruitasi', 'Event', 'trim|required');
		$this->form_validation->set_rules('nama_divisi', 'Division', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('pengurus/divisi', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('divisi', [
				'id_rekruitasi' => $this->input->post('id_rekruitasi'),
				'nama_divisi' => $this->input->post('nama_divisi')
			]);
			$this->session->set_flashdata('flash', 'Berhasil ditambahkan');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Divison Added!
				</div>');
			redirect('Pengurus/divisi');
		}
	}

	public function updateDivisi()
	{
		$data = [
			'id_rekruitasi' => $this->input->post('id_rekruitasi'),
			'nama_divisi' => $this->input->post('nama_divisi')
		];
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('divisi', $data);
		$this->session->set_flashdata('flash', 'Berhasil diubah');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Congratulation! Your Division has been updated!
			</div>');
		redirect('Pengurus/divisi');
	}


	public function deleteDivisi($id)
	{
		$this->db->delete('divisi', ['id' => $id]);
		$this->session->set_flashdata('flash', 'Berhasil dihapus');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Division Deleted!
			</div>');
		redirect('Pengurus/divisi');
	}

	public function getUpdateDivisi(){
		echo json_encode($this->Pengurus_model->getDivisiById($this->input->post('id')));
	}

	public function rekening($id_tiket = null)
	{
		$data['title'] = "Data Rekening";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, rekening.id AS idr, tiket.id AS idt' );
		if ($id_tiket) {
			$this->db->where('id_tiket', $id_tiket);
		} else{
			$this->db->where('id_pengurus', $data['user']['id']);
		}
		$this->db->join('tiket', 'rekening.id_tiket=tiket.id');
		$this->db->join('acara', 'tiket.id_acara=acara.id');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$data['rekening'] = $this->db->get('rekening')->result_array();
		
		$this->db->select('*, tiket.id AS idt');
		$this->db->where('id_pengurus', $data['user']['id']);
		$this->db->join('acara', 'tiket.id_acara=acara.id');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$this->db->order_by('tiket.id', 'DESC');
		$data['tiket'] = $this->db->get('tiket')->result_array();
		$this->form_validation->set_rules('id_tiket', 'Ticket', 'trim|required');
		$this->form_validation->set_rules('no_rekening', 'Account', 'trim|required');
		$this->form_validation->set_rules('bank', 'Bank', 'trim|required');
		$this->form_validation->set_rules('atas_nama', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('pengurus/data-rekening', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('rekening', [
				'id_tiket' => $this->input->post('id_tiket'),
				'no_rekening' => $this->input->post('no_rekening'),
				'bank' => $this->input->post('bank'),
				'atas_nama' => $this->input->post('atas_nama'),
				'email' => $this->input->post('email')
			]);
			$this->session->set_flashdata('flash', 'Berhasil ditambahkan');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Bank Account Added!
				</div>');
			redirect('Pengurus/rekening');
		}
	}

	public function updateRekening()
	{
		$this->form_validation->set_rules('id_tiket', 'Ticket', 'trim|required');
		$this->form_validation->set_rules('no_rekening', 'Account', 'trim|required');
		$this->form_validation->set_rules('bank', 'Bank', 'trim|required');
		$this->form_validation->set_rules('atas_nama', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('Pengurus/rekening');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('rekening', [
				'id_tiket' => $this->input->post('id_tiket'),
				'no_rekening' => $this->input->post('no_rekening'),
				'bank' => $this->input->post('bank'),
				'atas_nama' => $this->input->post('atas_nama'),
				'email' => $this->input->post('email')
			]);
			$this->session->set_flashdata('flash', 'Berhasil diubah');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Bank Account Updated!
				</div>');
			redirect('Pengurus/rekening');
		}
	}

	public function deleteRekening($id)
	{
		$this->db->delete('rekening', ['id' => $id]);
		$this->session->set_flashdata('flash', 'Berhasil dihapus');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Bank Account Deleted!
			</div>');
		redirect('Pengurus/rekening');
	}

	public function getUpdateRekening(){
		echo json_encode($this->Pengurus_model->getRekeningById($this->input->post('id')));
	}


	public function panitia($id_rekruitasi = null)
	{
		$data['title'] = "Data Panitia";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, panitia.id AS idp');
		if ($id_rekruitasi) {
			$this->db->where('id_rekruitasi', $id_rekruitasi);
		} else{
			$this->db->where('id_pengurus', $data['user']['id']);
		}
		$this->db->join('rekruitasi', 'rekruitasi.id = panitia.id_rekruitasi');
		$this->db->join('acara', 'acara.id = rekruitasi.id_acara');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$this->db->order_by('panitia.id', 'DESC');
		$data['panitia'] = $this->db->get('panitia')->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('pengurus/panitia', $data);
		$this->load->view('templates/footer');
	}

	public function updatePanitia($value='')
	{
		// $this->form_validation->set_rules('nim', 'NIM', 'trim|required');
		// $this->form_validation->set_rules('nama_lengkap', 'Full Name', 'trim|required');
		// $this->form_validation->set_rules('email', 'Email', 'trim|required');
		// $this->form_validation->set_rules('id_pilihan_divisi_1', 'First Choice', 'trim|required');
		// $this->form_validation->set_rules('id_pilihan_divisi_2', 'Second Choice', 'trim|required');
		// $this->form_validation->set_rules('divisi', 'Divisiion', 'trim|required');
		// $this->form_validation->set_rules('id_rekruitasi', 'Recruitment', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('Pengurus/panitia');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('panitia', [
				// 'nim' => $this->input->post('nim'),
				// 'nama_lengkap' => $this->input->post('nama_lengkap'),
				// 'email' => $this->input->post('email'),
				// 'id_pilihan_divisi_1' => $this->input->post('id_pilihan_divisi_1'),
				// 'id_pilihan_divisi_2' => $this->input->post('id_pilihan_divisi_2'),
				// 'divisi' => $this->input->post('divisi'),
				// 'id_rekruitasi' => $this->input->post('id_rekruitasi'),
				'status' => $this->input->post('status')
			]);
			$this->session->set_flashdata('flash', 'Berhasil diubah');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Status Updated!
				</div>');
			redirect('Pengurus/panitia');
		}
	}
	
	public function getJsonPanitiaById(){
		echo json_encode($this->Pengurus_model->getPanitiaById($this->input->post('id')));
	}
	
}