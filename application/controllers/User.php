<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('User_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$data['title'] = "My Profile";
		$this->db->join('agama', 'agama.id = user.religion_id');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if ($this->session->userdata('role_id') == 2) {
		}
		$data['admin_organisasi'] = $this->db->get_where('organisasi', ['id_pengurus' => $this->session->userdata('id')])->result_array();

		$this->db->select('*, organisasi.id AS ido');
		$this->db->join('organisasi', 'ikuti_organisasi.id_organisasi = organisasi.id');
		$data['organisasi_diikuti'] = $this->db->get_where('ikuti_organisasi', ['id_user' => $this->session->userdata('id')])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('user/index', $data);
		$this->load->view('templates/footer');
	}

	public function organisasi($id_organisasi = null)
	{
		$data['title'] = "Organisasi";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->db->select("*, organisasi.id AS ido");
		$this->db->join('kategori_organisasi', 'kategori_organisasi.id = organisasi.id_kategori_organisasi');
		$data['organisasi'] = $this->db->get_where('organisasi', ['organisasi.id' => $id_organisasi])->row();

		$this->db->select('*, tiket.id AS idt, acara.id AS ida');
		$this->db->join('acara', 'tiket.id_acara=acara.id');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');

		$this->db->order_by('tiket.id', 'DESC');
		$data['tiket'] = $this->db->get_where('tiket', ['id_organisasi' => $id_organisasi])->result_array();

		$this->db->select('*, rekruitasi.id AS idr, acara.id AS ida');
		$this->db->join('acara', 'rekruitasi.id_acara=acara.id');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		$this->db->order_by('rekruitasi.batas_waktu', 'DESC');
		$data['rekruitasi'] = $this->db->get_where('rekruitasi', ['id_organisasi' => $id_organisasi])->result_array();


		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('user/organisasi', $data);
		$this->load->view('templates/footer');
	}


	public function edit()
	{
		$data['title'] = "Edit Profile";
		$this->db->join('agama', 'agama.id = user.religion_id');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
		$data['agama'] = $this->db->get('agama')->result_array();
		if ($this->form_validation->run() ==  false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer');
		} else {
			$name = $this->input->post('name');
			$email = $this->input->post('email');

			//jika ada gambar
			$upload_image = $_FILES['image']['name'];
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png|svg';
				$config['upload_path'] = './assets/img/profile';
				$config['max_size']     = '2048';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image')) {
					$old_image = $data['user']['image'];
					if ($old_image != 'default.jpg' || $old_image != 'default.svg') {
						unlink(FCPATH . 'assets/img/profile/' . $old_image);
					}
					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
					redirect('user');
				}
			}

			$data = [
				'name' => $this->input->post('name'),
				'gender' => $this->input->post('gender'),
				'place_of_birth' => $this->input->post('place_of_birth'),
				'birthday' => $this->input->post('birthday'),
				'phone_number' => $this->input->post('phone_number'),
				'religion_id' => $this->input->post('religion_id'),
				'address' => $this->input->post('address')
			];
			$this->db->where('email', $email);
			$this->db->update('user', $data);
			$this->session->set_flashdata('flash', 'Berhasil diubah');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Congratulation! Your profile has been updated!
				</div>');
			redirect('user');
		}
	}

	public function delete()
	{
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() ==  false) {
			$this->session->set_flashdata('flash_gagal', 'Kata sandi wajib diisi');
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				The Password is required.
				</div>');
			redirect('user/edit');
		} else {
			$email = $this->session->userdata('email');
			$password = $this->input->post('password');

			$user = $this->db->get_where('user', ['email' => $email])->row_array();
			$id = $user['id'];

			if (password_verify($password, $user['password'])) {
				$this->db->delete('user', ['id' => $id]);
				redirect('auth/logout');
			} else {
				$this->session->set_flashdata('flash_gagal', 'Kata Sandi salah');
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Wrong Password!
					</div>');
				redirect('user/edit');
			}
		}
	}

	public function changePassword()
	{

		$data['title'] = "Change Password";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
		$this->form_validation->set_rules('new_password1', 'New Password', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('new_password2', 'Repeat New Password', 'trim|required|matches[new_password1]');
		if ($this->form_validation->run() ==  false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/change_password', $data);
			$this->load->view('templates/footer');
		} else {
			$current_password = $this->input->post('current_password');
			$new_password1 = $this->input->post('new_password1');
			$new_password2 = $this->input->post('new_password2');
			if (!password_verify($current_password, $data['user']['password'])) {
				$this->session->set_flashdata('flash_gagal', 'Password saat ini salah');
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
				redirect('user/changePassword');
			} else {
				if ($current_password == $new_password1) {
					$this->session->set_flashdata('flash_gagal', 'Kata Sandi baru tidak boleh sama dengan kata sandi yang lama');
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
					redirect('user/changePassword');
				} else {
					$password_hash = password_hash($new_password1, PASSWORD_DEFAULT);

					$this->db->set('password', $password_hash);
					$this->db->where('email', $this->session->userdata('email'));
					$this->db->update('user');
					$this->session->set_flashdata('flash', 'Berhasil diubah');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">password changed!</div>');
					redirect('user/changePassword');
				}
			}
		}
	}

	public function readAllNotification()
	{
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->where('id_user', $user['id']);
		$this->db->update('notifikasi', ['is_read' => 1]);
	}
	public function notifikasi()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/notification', $data);
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
			'pesan' => $user['name'] . ' ingin menjadi teman Anda',
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


	public function terimaPertemanan($id_pertemanan, $id_notifikasi = null)
	{
		$this->db->where('id', $id_pertemanan);
		$this->db->update('pertemanan', ['status' => 1]);
		if ($id_notifikasi) {
			$this->db->delete('notifikasi', ['id' => $id_notifikasi]);
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Permintaan pertemanan diterima!</div>');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function tolakPertemanan($id_pertemanan, $id_notifikasi = null)
	{
		$this->db->delete('pertemanan', ['id' => $id_pertemanan]);
		if ($id_notifikasi) {
			$this->db->delete('notifikasi', ['id' => $id_notifikasi]);
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Permintaan pertemanan ditolak!</div>');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function hapusPertemanan($id_pertemanan, $id_notifikasi = null)
	{
		$this->db->delete('pertemanan', ['id' => $id_pertemanan]);
		if ($id_notifikasi) {
			$this->db->delete('notifikasi', ['id' => $id_notifikasi]);
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pertemanan dibatalkan!</div>');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function terimaUndangan($id_undangan, $id_notifikasi = null)
	{
		$this->db->where('id', $id_undangan);
		$this->db->update('ikuti_organisasi', ['status' => 1]);
		if ($id_notifikasi) {
			$this->db->delete('notifikasi', ['id' => $id_notifikasi]);
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Undangan diterima!</div>');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function pertemanan()
	{
		$data['title'] = "Daftar Teman";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['users'] = $this->db->get_where('user', ['is_active' => 1])->result_array();
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();
		$data['pertemanan'] = $this->db->query("
			SELECT *, pertemanan.id AS idp, user.id AS idu FROM pertemanan 

			JOIN user ON IF(id_user1 = $user->id, id_user2, id_user1) = user.id 
			
			WHERE (id_user1 = $user->id OR id_user2 = $user->id) AND status = 1

			ORDER BY pertemanan.id DESC
			")->result_array();
		$data['permintaan_teman'] = $this->db->query("
			SELECT *, pertemanan.id AS idp FROM pertemanan 

			JOIN user ON id_user1 = user.id 
			
			WHERE id_user2 = $user->id AND status = 0

			ORDER BY pertemanan.id DESC
			")->result_array();
		$data['permintaan_terkirim'] = $this->db->query("
			SELECT *, pertemanan.id AS idp FROM pertemanan 

			JOIN user ON id_user2 = user.id 
			
			WHERE id_user1 = $user->id AND status = 0

			ORDER BY pertemanan.id DESC
			")->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('user/pertemanan', $data);
		$this->load->view('templates/footer');
	}
	public function tolakUndangan($id_undangan, $id_notifikasi = null)
	{
		$this->db->delete('ikuti_organisasi', ['id' => $id_undangan]);
		if ($id_notifikasi) {
			$this->db->delete('notifikasi', ['id' => $id_notifikasi]);
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Undangan ditolak!</div>');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function chat($id_teman = null)
	{
		$data['id_tmn'] = $id_teman;
		// if ($this->input->get('search') != '') {
		// 	$search = $this->input->get('search');
		// } else{
		// 	$search = '';
		// }
		$search = $this->input->get('search');
		$data['title'] = "Chat";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();
		$data['chat'] = $this->db->query("
			SELECT *, user.id AS id_user, MAX(time) as max_time  FROM chat 

			JOIN user ON IF(chat.id_user_from = $user->id, chat.id_user_to, chat.id_user_from) = user.id 
			
			WHERE (id_user_from = $user->id OR id_user_to = $user->id) AND user.id != $user->id 
			-- AND chat.time = (SELECT MAX(c2.time) FROM chat c2 WHERE c2.id_user_from = chat.id_user_from OR c2.id_user_to = chat.id_user_to)

			AND name LIKE '%$search%'

			GROUP BY IF(id_user_to = $user->id, id_user_from, id_user_to) ORDER BY chat.id DESC
		")->result();
		$data['pertemanan'] = $this->db->query("
			SELECT *, pertemanan.id AS idp, user.id AS idu FROM pertemanan 

			JOIN user ON IF(id_user1 = $user->id, id_user2, id_user1) = user.id 
			
			WHERE (id_user1 = $user->id OR id_user2 = $user->id) AND status = 1

			ORDER BY pertemanan.id DESC
			")->result_array();
		//PERCOBAAN 2
		// $data['chat'] = $this->db->query("
		// 	SELECT * FROM chat c1

		// 	JOIN user ON IF(c1.id_user_from = $user->id, c1.id_user_to, c1.id_user_from) = user.id 

		// 	WHERE (c1.id_user_from = $user->id OR c1.id_user_to = $user->id) AND user.id != $user->id AND c1.time = (SELECT MAX(c2.time) FROM chat c2 WHERE c2.id_user_from = c1.id_user_from OR c2.id_user_to = c1.id_user_to)

		// 	GROUP BY IF(c1.id_user_to = $user->id, c1.id_user_from, c1.id_user_to) ORDER BY c1.time DESC
		// 	")->result();

		//PERCOBAAN 1
		// $data['chat'] = $this->db->query("
		// 	SELECT * FROM chat JOIN user ON chat.id_user_to=user.id WHERE id_user_from = $user->id AND user.id != $user->id GROUP BY id_user_to HAVING time = MAX(time) UNION 
		// 	SELECT * FROM chat JOIN user ON chat.id_user_from=user.id WHERE id_user_to = $user->id AND user.id != $user->id GROUP BY id_user_from HAVING time = MAX(time)")->result();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('user/chat', $data);
		$this->load->view('templates/footer');
	}

	public function getChat()
	{
		$id_teman = $this->input->post('id_teman');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['teman'] = $this->db->get_where('user', ['id' => $id_teman])->row_array();
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();

		$this->db->where('id_user_from', $id_teman);
		$this->db->where('id_user_to', $user->id);
		$this->db->update('chat', ['is_read' => 1]);

		$this->db->where('id_creator', $id_teman);
		$this->db->where('id_user', $user->id);
		$this->db->where('id_kategori_notifikasi', 5);
		$this->db->update('notifikasi', ['is_read' => 1]);

		$data['chat'] = $this->db->query("
			SELECT * FROM chat 

			JOIN user ON IF(chat.id_user_from = $user->id, chat.id_user_to, chat.id_user_from) = user.id 
			
			WHERE (id_user_from = $user->id AND id_user_to = $id_teman) 
			OR (id_user_to = $user->id AND id_user_from = $id_teman)

			ORDER BY time ASC
		")->result();

		return $this->load->view('user/message', $data);
	}


	public function getChat2($id_teman = null)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['teman'] = $this->db->get_where('user', ['id' => $id_teman])->row_array();
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();

		$this->db->where('id_user_from', $id_teman);
		$this->db->where('id_user_to', $user->id);
		$this->db->update('chat', ['is_read' => 1]);

		$data['chat'] = $this->db->query("
			SELECT * FROM chat 

			JOIN user ON IF(chat.id_user_from = $user->id, chat.id_user_to, chat.id_user_from) = user.id 
			
			WHERE (id_user_from = $user->id AND id_user_to = $id_teman) 
			OR (id_user_to = $user->id AND id_user_from = $id_teman)

			ORDER BY time ASC
		")->result();

		return $this->load->view('user/message-2', $data);
	}


	public function kirimChat()
	{
		$id_teman = $this->input->post('id_teman');
		$pesan = $this->input->post('pesan');

		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['teman'] = $this->db->get_where('user', ['id' => $id_teman])->row_array();
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();

		$this->db->insert('chat', [
			'id_user_from' => $user->id,
			'id_user_to' => $id_teman,
			'message' => nl2br($pesan),
			'time' => date('Y-m-d H:i:s'),
			'status' => 1,
			'is_read' => 0
		]);

		$this->db->insert('notifikasi', [
			'id_user' => $id_teman,
			'id_kategori_notifikasi' => 5,
			'sub_id' => $this->db->insert_id(),
			'waktu_notifikasi' => date('Y-m-d H:i:s'),
			'subjek' => 'Pesan baru',
			'pesan' => nl2br($pesan),
			'is_read' => 0,
			'id_creator' => $user->id
		]);

		$this->getChat2($id_teman);
	}

	public function kirimPesan()
	{
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();
		$message = $this->input->post('message');
		$id_user_to = $this->input->post('id_user_to');
		$this->db->insert('chat', [
			'id_user_from' => $user->id,
			'id_user_to' => $id_user_to,
			'message' => nl2br($message),
			'time' => date('Y-m-d H:i:s'),
			'status' => 1,
			'is_read' => 0
		]);

		$this->db->insert('notifikasi', [
			'id_user' => $id_user_to,
			'id_kategori_notifikasi' => 5,
			'sub_id' => $this->db->insert_id(),
			'waktu_notifikasi' => date('Y-m-d H:i:s'),
			'subjek' => 'Pesan baru',
			'pesan' => nl2br($message),
			'is_read' => 0,
			'id_creator' => $user->id
		]);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pesan telah terkirim!</div>');
		redirect($_SERVER['HTTP_REFERER']);
	}
}
