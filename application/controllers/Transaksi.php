<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('Transaksi_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$data['title'] = "Pemesanan";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, invoice.id AS idi');
		$this->db->join('user', 'invoice.id_member = user.id');
		$this->db->join('metode_bayar', 'invoice.id_metode_bayar = metode_bayar.id');
		$this->db->join('tiket', 'tiket.id = invoice.id_tiket');
		$this->db->join('acara', 'acara.id = tiket.id_acara');
		$data['invoice'] = $this->db->get('invoice')->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('transaksi/pemesanan', $data);
		$this->load->view('templates/footer');
	}
	public function invoice()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$kode_bayar = strtoupper(bin2hex(random_bytes(10)));
		$id_kasir = $data['user']['id'];
		$catatan = $this->input->post('catatan');
		foreach ($this->cart->contents() as $item) {
			$data = array(
				'kode_bayar' => $kode_bayar,
				'id_kasir' => $id_kasir,
				'id_produk' => $item['id'],
				'jumlah' => $item['qty'],
				'sub_total_harga' => $item['subtotal'],
				'waktu_transaksi' => date("Y-m-d H:i:s"),
				'catatan' => $catatan
			);
			$this->db->insert('transaksi', $data);
			$produk = $this->db->get_where('produk',['id' => $item['id']])->row_array();
			$new_stok = $produk['stok'] - $item['qty'];
			$this->db->where('id', $item['id']);
			$this->db->update('produk',['stok' => $new_stok]);
		}
		$this->cart->destroy();
		$this->session->set_flashdata('flash', 'Berhasil');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Transaksi berhasil!
			</div>');
		redirect("Transaksi/offline");
	}

	public function pembayaran()
	{
		$data['title'] = "Pembayaran";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, bukti_transfer.id AS idbt, bukti_transfer.status AS sbt');
		$this->db->join('invoice', 'bukti_transfer.id_invoice = invoice.id');
		$this->db->join('user', 'invoice.id_member = user.id');
		$this->db->join('rekening', 'bukti_transfer.id_rekening_tujuan = rekening.id');
		$this->db->order_by('bukti_transfer.id', 'DESC');
		$data['bukti_transfer'] = $this->db->get('bukti_transfer')->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('transaksi/pembayaran', $data);
		$this->load->view('templates/footer');
	}

	public function updateStatusInvoice($id, $status = '')
	{
		$this->db->where('id', $id);
		$this->db->update('invoice', ['status' => 'Pesanan '.$status]);
		if ($status == 'lunas') {
			$this->db->where('id', $id);
			$this->db->update('invoice', ['status' => 'Sudah dibayar']);
		}
		if ($status == 'dibatalkan') {
			$invoice = $this->db->get_where('invoice', ['id' => $id])->row_array();
			$tiket = $this->db->get_where('tiket',['id' => $invoice['id_tiket']])->row_array();
			$new_sold = $tiket['jumlah_terjual'] - $invoice['jumlah'];
			$this->db->where('id', $invoice['id_tiket']);
			$this->db->update('tiket',['jumlah_terjual' => $new_sold]);
		}
		$this->session->set_flashdata('flash', 'Telah '.$status);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Pesanan telah '.$status.'
			</div>');
		redirect('Transaksi/');
	}

	public function updateStatusPembayaran($id, $status = '')
	{
		$this->db->where('id', $id);
		$this->db->update('bukti_transfer', ['status' => 'Pembayaran '.$status]);
		if ($status == 'valid') {
			$bukti_transfer = $this->db->get_where('bukti_transfer', ['id' => $id])->row_array();
			$this->db->where('id', $bukti_transfer['id_invoice']);
			$this->db->update('invoice', ['status' => 'Sudah dibayar']);
		}
		$this->session->set_flashdata('flash', 'Telah '.$status);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Pembayaran telah '.$status.'
			</div>');
		redirect('Transaksi/pembayaran');
	}

	public function kirimTiket()
	{
		$upload_image = $_FILES['tiket']['name'];
		if ($upload_image) {
			$config['allowed_types'] = 'gif|jpg|png|svg|jpeg|pdf';
			$config['upload_path'] = './assets/img/tiket';
			$config['max_size']     = '15000000';
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('tiket')) {
				$tiket = $this->upload->data('file_name');
				$subjek = 'Tiket '.$this->input->post('nama_acara').' Anda';
				$pesan = 'Terima Kasih sudah memesan Tiket Kami :3 CMIWWW';
				$attach = base_url('assets/img/tiket/'.$tiket);
				$this->_kirimEmail($this->input->post('to'), $subjek, $pesan, $attach);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Email Terkirim</div>');
				redirect('Transaksi');
			} else{
				$this->session->set_flashdata('flash_error', $this->upload->display_errors());
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
				redirect('Transaksi');
			}
		} else{
			$this->session->set_flashdata('flash_gagal', 'Tiket Wajib diupload');
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Tiket Wajib diupload
				</div>');
			redirect('Transaksi');
		}
	}

	private function _kirimEmail($email='', $subjek = '', $pesan = '', $attach = '')
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
		$this->email->attach($attach);

		if ($this->email->send()) {
			return true;
		} else{
			echo $this->email->print_debugger();
			die;
		}
	}
}