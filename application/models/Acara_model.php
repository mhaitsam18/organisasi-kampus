<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acara_model extends CI_Model {

	public function getAcaraById($id)
	{
		return $this->db->get_where('acara', ['id' => $id])->row_array();
	}
	public function countAllAcara()
	{
		return $this->db->get('acara')->num_rows();
	}
	public function getAllAcara()
	{
		return $this->db->get_where('acara')->result_array();
	}
	public function getAcaraByLimit($limit, $start, $keyword = null)
	{
		if ($keyword) {
			$this->db->like('nama_Acara', $keyword);
			$this->db->or_like('penyelenggara', $keyword);
		}
		$this->db->order_by('id', 'DESC');
		return $this->db->get('acara', $limit, $start)->result_array();
	}

	public function getTiketAcaraById($id)
	{
		$this->db->join('acara', 'tiket.id_acara=acara.id');
		return $this->db->get_where('tiket', ['id' => $id])->row_array();
	}
	public function countAllTiketAcara()
	{
		$this->db->join('acara', 'tiket.id_acara=acara.id');
		return $this->db->get('tiket')->num_rows();
	}
	public function getAllTiketAcara()
	{
		$this->db->join('acara', 'tiket.id_acara=acara.id');
		return $this->db->get('tiket')->result_array();
	}
	public function getTiketAcaraByLimit($limit, $start, $keyword = null)
	{
		$this->db->select('*, tiket.id AS idt, acara.id AS ida');
		$this->db->join('acara', 'tiket.id_acara=acara.id');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		if ($keyword) {
			$this->db->like('nama_acara', $keyword);
			$this->db->or_like('penyelenggara', $keyword);
		}
		$this->db->order_by('tiket.id', 'DESC');
		return $this->db->get('tiket', $limit, $start)->result_array();
	}

	public function getTiketById($id)
	{
		return $this->db->get_where('tiket', ['id' => $id])->row_array();
	}

	public function getRekruitasiAcaraById($id)
	{
		$this->db->join('acara', 'rekruitasi.id_acara=acara.id');
		return $this->db->get_where('rekruitasi', ['id' => $id])->row_array();
	}
	public function countAllRekruitasiAcara()
	{
		$this->db->join('acara', 'rekruitasi.id_acara=acara.id');
		return $this->db->get('rekruitasi')->num_rows();
	}
	public function getAllRekruitasiAcara()
	{
		$this->db->join('acara', 'rekruitasi.id_acara=acara.id');
		return $this->db->get('rekruitasi')->result_array();
	}
	public function getRekruitasiAcaraByLimit($limit, $start, $keyword = null)
	{
		$this->db->select('*, rekruitasi.id AS idr, acara.id AS ida');
		$this->db->join('acara', 'rekruitasi.id_acara=acara.id');
		$this->db->join('organisasi', 'acara.id_organisasi = organisasi.id');
		if ($keyword) {
			$this->db->like('nama_acara', $keyword);
			$this->db->or_like('penyelenggara', $keyword);
		}
		$this->db->order_by('rekruitasi.batas_waktu', 'DESC');
		return $this->db->get('rekruitasi', $limit, $start)->result_array();
	}

	public function getRekruitasiById($id)
	{
		return $this->db->get_where('rekruitasi', ['id' => $id])->row_array();
	}

	public function getOrganisasiById($id)
	{
		return $this->db->get_where('organisasi', ['id' => $id])->row_array();
	}
	public function countAllOrganisasi()
	{
		return $this->db->get('organisasi')->num_rows();
	}
	public function getAllOrganisasi()
	{
		return $this->db->get('organisasi')->result_array();
	}
	public function getOrganisasiByLimit($limit, $start, $keyword = null)
	{
		if ($keyword) {
			$this->db->like('nama_organisasi', $keyword);
			$this->db->or_like('singkatan', $keyword);
		}
		$this->db->where('status', 1);
		$this->db->order_by('nama_organisasi', 'ASC');
		return $this->db->get('organisasi', $limit, $start)->result_array();
	}
	
}