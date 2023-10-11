<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('Member_model');
		$this->load->model('Acara_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$data['title'] = "Beranda";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();
		$data['dashboard'] = $this->db->get('dashboard')->row_array();
		$data['tiket'] = $this->Acara_model->getTiketAcaraByLimit(3,0);
		
		$data['kepanitiaan'] = $this->Acara_model->getRekruitasiAcaraByLimit(3,0);
		
		$this->db->join('organisasi', 'organisasi.id = ikuti_organisasi.id_organisasi');
		$data['group_saya'] = $this->db->get_where('ikuti_organisasi', ['id_user' => $data['user']['id']])->result_array();
		
		$data['teman_saya'] = $this->db->query("
			SELECT *, pertemanan.id AS idp, user.id AS idu FROM pertemanan 

			JOIN user ON IF(id_user1 = $user->id, id_user2, id_user1) = user.id 
			
			WHERE (id_user1 = $user->id OR id_user2 = $user->id) AND status = 1

			ORDER BY pertemanan.id DESC
		")->result_array();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/index', $data);
		$this->load->view('templates/footer');
	}

	public function event()
	{
		$data['title'] = "Event";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$config['base_url'] = base_url('Member/event/');
		if ($this->input->post('keyword')) {
			$data['keyword'] = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $data['keyword']);
		} else{
			$data['keyword'] = $this->session->set_userdata('keyword');
		}
		$this->db->like('nama_acara', $data['keyword']);
		$this->db->or_like('penyelenggara', $data['keyword']);
		$this->db->from('tiket');
		$this->db->join('acara', 'tiket.id_acara=acara.id');
		$config['total_rows'] = $this->db->count_all_results();
		$data['total_rows'] = $config['total_rows'];
		$config['per_page'] = 3;
		$config['num_links'] = 2;

		//styling
		$config['full_tag_open'] = '<nav aria-label="pagination"><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</nav></ul>';

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		if ($config['total_rows']-$this->uri->segment(3)>7) {
		  $config['next_link'] = '&raquo';
		} else{
		  $config['next_link'] = 'Next';
		}
		$config['next_tag_open'] = '
								<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		if ($this->uri->segment(3)>7) {
		  $config['prev_link'] = '&laquo';
		} else{
		  $config['prev_link'] = 'Prev';
		}
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		if (empty($this->uri->segment(3))) {
			$prev = '<li class="page-item disabled"><span class="page-link">Prev</span></li>';
			$next = '';
		} elseif ($config['total_rows']-$this->uri->segment(3)<3) {
			$prev = '';
			$next = '<li class="page-item disabled"><span class="page-link">Next</span></li>';
		} else {
			$next = '';
			$prev = '';
		}
		$config['cur_tag_open'] = $prev.'<li class="page-item active" aria-current="page"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>'.$next;

		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';

		$config['attributes'] = array('class' => 'page-link');

		// $config['display_pages'] = TRUE;
		// $config['attributes']['rel'] = FALSE;
		$this->pagination->initialize($config);
		$data['start'] = $this->uri->segment(3);
		$data['acara'] = $this->Acara_model->getTiketAcaraByLimit($config['per_page'],$data['start'], $data['keyword']);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/event', $data);
		$this->load->view('templates/footer');
	}

	public function checkout()
	{
		$data['title'] = "Data Metode Bayar";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('id_tiket', 'Ticket', 'trim|required');
		$this->form_validation->set_rules('jumlah', 'Jumlah Tiket', 'trim|required', ['required' => 'Jumlah Tiket Harus diisi']);
		$this->form_validation->set_rules('email', 'Email', 'trim|required', ['required' => 'Email Harus diisi']);
		if ($this->form_validation->run() == false) {
			$this->event();
		} else{
			$kode_bayar = strtoupper(bin2hex(random_bytes(10)));
			$tiket = $this->db->get_where('tiket', ['id' => $this->input->post('id_tiket')])->row_array();
			$data = array(
				'id_member' => $data['user']['id'],
				'id_tiket' => $this->input->post('id_tiket'),
				'kode_bayar' => $kode_bayar,
				'email' => $this->input->post('email'),
				'jumlah' => $this->input->post('jumlah'),
				'total_harga' => $this->input->post('jumlah')*$tiket['harga'],
				'waktu_pemesanan' => date("Y-m-d H:i:s"),
				'id_metode_bayar' => 1,
				'status' => 'Belum dibayar',
			);
			$this->db->insert('invoice', $data);
			$new_sold = $tiket['jumlah_terjual'] + $this->input->post('jumlah');
			$this->db->where('id', $this->input->post('id_tiket'));
			$this->db->update('tiket',['jumlah_terjual' => $new_sold]);
			$this->session->set_flashdata('flash', 'Berhasil');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				checkout berhasil!
				</div>');
			redirect("Member/pembayaran/$kode_bayar/".$this->input->post('id_tiket'));
		}
	}

	public function pembayaran($kode_bayar = '', $id_tiket = null)
	{
		$data['title'] = "Pembayaran Tiket";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['rekening_tujuan'] = $this->db->get_where('rekening', ['id_tiket' => $id_tiket])->result_array();
		$data['kode_bayar'] = $kode_bayar;
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/pembayaran', $data);
		$this->load->view('templates/footer');
	}

	public function uploadBuktiPembayaran()
	{
		$invoice = $this->db->get_where('invoice', ['kode_bayar' => $this->input->post('kode_bayar')])->row_array();
		$num_invoice = $this->db->get_where('invoice', ['kode_bayar' => $this->input->post('kode_bayar')])->num_rows();
		if ($num_invoice < 1) {
			$this->session->set_flashdata('flash_gagal', 'Kode Bayar tidak terdaftar');
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Kode Bayar tidak terdaftar
				</div>');
			redirect('Member/pembayaran');
		}
		$upload_image = $_FILES['bukti_pembayaran']['name'];
		if ($upload_image) {
			$config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
			$config['upload_path'] = './assets/img/bukti-pembayaran';
			$config['max_size']     = '2048';
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('bukti_pembayaran')) {
				$new_image = $this->upload->data('file_name');
				$data = array(
					'id_invoice' => $invoice['id'],
					'id_rekening_tujuan' => $this->input->post('id_rekening_tujuan'),
					'rekening_pengirim' => $this->input->post('rekening_pengirim'),
					'bank_pengirim' => $this->input->post('bank_pengirim'),
					'nama_pengirim' => $this->input->post('nama_pengirim'),
					'waktu_transfer' => $this->input->post('tanggal_transfer').' '.$this->input->post('waktu_transfer'),
					'nominal_transfer' => $this->input->post('nominal_transfer'),
					'bukti_pembayaran' => $new_image,
					'catatan' => $this->input->post('catatan'),
					'status' => 'Belum dikonfirmasi',
				);
				$this->db->insert('bukti_transfer', $data);

				$this->db->where('id', $invoice['id']);
				$this->db->update('invoice', ['status' => 'Menunggu konfirmasi pembayaran']);
				$this->session->set_flashdata('flash', 'Terkirim');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Bukti Pembayaran Terkirim
					</div>');
				redirect('Member/tiketSaya');
			} else{
				$this->session->set_flashdata('flash_error', $this->upload->display_errors());
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
				redirect('Member/pembayaran');
			}
		} else{
			$this->session->set_flashdata('flash_gagal', 'Bukti Pembayaran Wajib diupload');
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Bukti Pembayaran Wajib diupload
				</div>');
			redirect('Member/pembayaran');
		}
	}

	public function tiketSaya($value='')
	{
		$data['title'] = "Tiket Saya";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, invoice.id AS idi');
		$this->db->join('metode_bayar', 'invoice.id_metode_bayar = metode_bayar.id');
		$this->db->join('tiket', 'tiket.id = invoice.id_tiket');
		$this->db->join('acara', 'acara.id = tiket.id_acara');
		$this->db->order_by('invoice.id', 'DESC');
		$data['invoice'] = $this->db->get_where('invoice', ['id_member' => $data['user']['id']])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/tiket-saya', $data);
		$this->load->view('templates/footer');
	}

	private function _kirimEmail($email='', $subjek = '', $pesan = '')
	{
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'alyayapm@gmail.com',
			'smtp_pass' => 'alyaya.25',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'chatset' => 'utf-8',
			'newline' => "\r\n"
		];

		$this->load->library('email', $config);
		$this->email->initialize($config); 
		$this->email->from('alyayapm@gmail.com', 'Alya Putri Maharani');
		$this->email->to($email);

		$this->email->subject($subjek);
		$this->email->message($pesan);

		if ($this->email->send()) {
			return true;
		} else{
			echo $this->email->print_debugger();
			die;
		}
	}

	public function riwayatPembayaran($id_invoice = null)
	{
		$data['title'] = "Riwayat Pembayaran";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if ($id_invoice) {
			$where = ['id_member' => $data['user']['id'], 'id_invoice' => $id_invoice];
		} else{
			$where = ['id_member' => $data['user']['id']];
		}
		$this->db->select('*, bukti_transfer.id AS idbt, bukti_transfer.status AS sbt');
		$this->db->join('invoice', 'bukti_transfer.id_invoice = invoice.id');
		$this->db->join('tiket', 'tiket.id = invoice.id_tiket');
		$this->db->join('acara', 'acara.id = tiket.id_acara');
		$this->db->join('user', 'invoice.id_member = user.id');
		$this->db->join('rekening', 'bukti_transfer.id_rekening_tujuan = rekening.id');
		$this->db->order_by('bukti_transfer.id', 'DESC');
		$data['bukti_transfer'] = $this->db->get_where('bukti_transfer',$where)->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/riwayat-pembayaran', $data);
		$this->load->view('templates/footer');
	}

	public function getJsonTiketById()
	{
		echo json_encode($this->Acara_model->getTiketById($this->input->post('id')));
	}



	public function kepanitiaan()
	{
		$data['title'] = "Kepanitiaan";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$config['base_url'] = base_url('Member/kepanitiaan/');
		if ($this->input->post('keyword')) {
			$data['keyword'] = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $data['keyword']);
		} else{
			$data['keyword'] = $this->session->set_userdata('keyword');
		}
		$this->db->like('nama_acara', $data['keyword']);
		$this->db->or_like('penyelenggara', $data['keyword']);
		$this->db->from('rekruitasi');
		$this->db->join('acara', 'rekruitasi.id_acara=acara.id');
		$config['total_rows'] = $this->db->count_all_results();
		$data['total_rows'] = $config['total_rows'];
		$config['per_page'] = 3;
		$config['num_links'] = 2;

		//styling
		$config['full_tag_open'] = '<nav aria-label="pagination"><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</nav></ul>';

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		if ($config['total_rows']-$this->uri->segment(3)>7) {
		  $config['next_link'] = '&raquo';
		} else{
		  $config['next_link'] = 'Next';
		}
		$config['next_tag_open'] = '
								<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		if ($this->uri->segment(3)>7) {
		  $config['prev_link'] = '&laquo';
		} else{
		  $config['prev_link'] = 'Prev';
		}
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		if (empty($this->uri->segment(3))) {
			$prev = '<li class="page-item disabled"><span class="page-link">Prev</span></li>';
			$next = '';
		} elseif ($config['total_rows']-$this->uri->segment(3)<3) {
			$prev = '';
			$next = '<li class="page-item disabled"><span class="page-link">Next</span></li>';
		} else {
			$next = '';
			$prev = '';
		}
		$config['cur_tag_open'] = $prev.'<li class="page-item active" aria-current="page"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>'.$next;

		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';

		$config['attributes'] = array('class' => 'page-link');

		// $config['display_pages'] = TRUE;
		// $config['attributes']['rel'] = FALSE;
		$this->pagination->initialize($config);
		$data['start'] = $this->uri->segment(3);
		$data['acara'] = $this->Acara_model->getRekruitasiAcaraByLimit($config['per_page'],$data['start'], $data['keyword']);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/kepanitiaan', $data);
		$this->load->view('templates/footer');
	}

	public function daftarPanitia()
	{
		$data['title'] = "Daftar Panitia";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('nim', 'NIM', 'trim|required');
		$this->form_validation->set_rules('nama_lengkap', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('id_pilihan_divisi_1', 'First Choice', 'trim|required');
		// $this->form_validation->set_rules('id_rekruitasi', 'Recruitment', 'trim|required');
		if ($this->form_validation->run() == false) {
			// redirect('Member/kepanitiaan');
			$this->kepanitiaan();
		} else{
			$upload_image = $_FILES['file_cv']['name'];
			if ($upload_image) {
				$config['allowed_types'] = 'pdf|docx';
				$config['upload_path'] = './assets/doc/file-cv';
				$config['max_size']     = '15000000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('file_cv')) {
					$new_file = $this->upload->data('file_name');
					$data = array(
						'nim' => $this->input->post('nim'),
						'nama_lengkap' => $this->input->post('nama_lengkap'),
						'email' => $this->input->post('email'),
						'file_cv' => $new_file,
						'id_pilihan_divisi_1' => $this->input->post('id_pilihan_divisi_1'),
						'id_pilihan_divisi_2' => $this->input->post('id_pilihan_divisi_2'),
						'divisi' => 0,
						'id_rekruitasi' => $this->input->post('id_rekruitasi'),
						'status' => 'Belum diterima'
					);
					$this->db->insert('panitia', $data);
					$this->session->set_flashdata('flash', 'Berhasil mendaftar');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
						Selamat, Anda berhasil terdaftar!
						</div>');
					redirect("Member/rekruitasi/".$this->input->post('id_rekruitasi'));
				} else{
					$this->session->set_flashdata('flash_error', 'Gagal diunggah');
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
				}
			} else{
				$this->session->set_flashdata('flash_gagal', 'File CV Wajib diupload');
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					File CV Wajib diupload!
					</div>');
			}
			redirect("Member/kepanitiaan/");
		}
	}

	public function getJsonRekruitasiById()
	{
		echo json_encode($this->Acara_model->getRekruitasiById($this->input->post('id')));
	}

	public function rekruitasi($id_rekruitasi = null)
	{
		$data['title'] = "List Rekruitasi";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if ($id_rekruitasi) {
			$this->db->where('id_rekruitasi', $id_rekruitasi);
		}
		$this->db->join('rekruitasi', 'rekruitasi.id = panitia.id_rekruitasi');
		$this->db->join('acara', 'acara.id = rekruitasi.id_acara');
		$this->db->order_by('panitia.id', 'DESC');
		$data['panitia'] = $this->db->get('panitia')->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/rekruitasi', $data);
		$this->load->view('templates/footer');
	}

	public function updateStatusPesanan($id, $status = '')
	{
		$this->db->where('id', $id);
		$this->db->update('invoice', ['status' => 'Pesanan '.$status]);
		if ($status == 'dibatalkan') {
			$invoice = $this->db->get_where('invoice', ['id' => $id])->row_array();
			$tiket = $this->db->get_where('tiket',['id' => $invoice['id_tiket']])->row_array();
			$new_sold = $tiket['jumlah_terjual'] - $invoice['jumlah'];
			$this->db->where('id', $tiket['id']);
			$this->db->update('tiket',['jumlah_terjual' => $new_sold]);
		}
		$this->session->set_flashdata('flash', 'Pesanan telah '.$status);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Pesanan telah '.$status.'
			</div>');
		redirect('Member/tiketSaya');
	}


	public function organisasi()
	{
		$data['title'] = "Organisasi";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$config['base_url'] = base_url('Member/organisasi/');
		if ($this->input->post('keyword')) {
			$data['keyword'] = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $data['keyword']);
		} else{
			$data['keyword'] = $this->session->set_userdata('keyword');
		}
		$this->db->where('status', 1);
		$this->db->like('nama_organisasi', $data['keyword']);
		// $this->db->or_like('singkatan', $data['keyword']);
		$this->db->from('organisasi');
		$config['total_rows'] = $this->db->count_all_results();
		$data['total_rows'] = $config['total_rows'];
		$config['per_page'] = 3;
		$config['num_links'] = 2;

		//styling
		$config['full_tag_open'] = '<nav aria-label="pagination"><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</nav></ul>';

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		if ($config['total_rows']-$this->uri->segment(3)>7) {
		  $config['next_link'] = '&raquo';
		} else{
		  $config['next_link'] = 'Next';
		}
		$config['next_tag_open'] = '
								<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		if ($this->uri->segment(3)>7) {
		  $config['prev_link'] = '&laquo';
		} else{
		  $config['prev_link'] = 'Prev';
		}
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		if (empty($this->uri->segment(3))) {
			$prev = '<li class="page-item disabled"><span class="page-link">Prev</span></li>';
			$next = '';
		} elseif ($config['total_rows']-$this->uri->segment(3)<3) {
			$prev = '';
			$next = '<li class="page-item disabled"><span class="page-link">Next</span></li>';
		} else {
			$next = '';
			$prev = '';
		}
		$config['cur_tag_open'] = $prev.'<li class="page-item active" aria-current="page"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>'.$next;

		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';

		$config['attributes'] = array('class' => 'page-link');

		// $config['display_pages'] = TRUE;
		// $config['attributes']['rel'] = FALSE;
		$this->pagination->initialize($config);
		$data['start'] = $this->uri->segment(3);
		$data['organisasi'] = $this->Acara_model->getOrganisasiByLimit($config['per_page'],$data['start'], $data['keyword']);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/organisasi', $data);
		$this->load->view('templates/footer');
	}

	public function ikutiOrganisasi($id_organisasi)
	{
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->db->where('id_organisasi', $id_organisasi);
		$this->db->where('id_user', $user['id']);
		$this->db->where('status', 0);
		$result = $this->db->get('ikuti_organisasi');
		if ($result->num_rows() > 0) {
			$this->db->where('id_organisasi', $id_organisasi);
			$this->db->where('id_user', $user['id']);
			$this->db->update('ikuti_organisasi', ['status' => 1]);
		} else{
			$this->db->insert('ikuti_organisasi', [
				'id_organisasi' => $id_organisasi,
				'id_user' => $user['id'],
				'status' => 1,
			]);
		}
		$this->session->set_flashdata('flash', 'Telah difollow');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Organisasi berhasil diikuti!
			</div>');
		redirect("Member/organisasi/");
	}

	public function batalMengikuti($id_organisasi)
	{
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->delete('ikuti_organisasi', [
			'id_organisasi' => $id_organisasi,
			'id_user' => $user['id']
		]);
		$this->session->set_flashdata('flash', 'Telah diunfollow');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Organisasi berhasil diunfollow!
			</div>');
		// redirect("Member/organisasi/");
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function berteman($id_teman = null)
	{
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->insert('pertemanan', [
			'id_user1' => $user['id'],
			'id_user2' => $id_teman,
			'waktu' => date('Y-m-d H:i:s'),
			'status' => 0,
		]);
		$this->db->insert('notifikasi', [
			'id_user' => $id_teman,
			'id_kategori_notifikasi' => 2,
			'sub_id' => $this->db->insert_id(),
			'waktu_notifikasi' => date('Y-m-d H:i:s'),
			'subjek' => 'Permintaan Teman',
			'pesan' => $user['name'].' ingin menjadi teman Anda',
			'is_read' => 0,
			'id_creator' => $user['id']
		]);
		// $this->session->set_flashdata('flash', 'Terkirim');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Permintaan berteman telah terkirim!
			</div>');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function batalkanPertemanan($id_teman = null)
	{
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$result = $this->db->get_where('pertemanan', [
			'id_user1' => $user['id'],
			'id_user2' => $id_teman,
		])->num_rows();
		if ($result > 0) {
			$this->db->delete('pertemanan', [
				'id_user1' => $user['id'],
				'id_user2' => $id_teman
			]);
		}
		$result = $this->db->get_where('pertemanan', [
			'id_user1' => $id_teman,
			'id_user2' => $user['id'],
		])->num_rows();
		if ($result > 0) {
			$this->db->delete('pertemanan', [
				'id_user1' => $id_teman,
				'id_user2' => $user['id'],
			]);
		}
		
		// $this->session->set_flashdata('flash', 'Telah difollow');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Pertemanan dibatalkan!
			</div>');
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}
