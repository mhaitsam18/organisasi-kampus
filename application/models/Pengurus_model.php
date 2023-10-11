<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengurus_model extends CI_Model {
	public function getAcaraById($id)
	{
		return $this->db->get_where('acara', ['id' => $id])->row_array();
	}
	public function getTiketById($id)
	{
		return $this->db->get_where('tiket', ['id' => $id])->row_array();
	}
	public function getRekruitasiById($id)
	{
		return $this->db->get_where('rekruitasi', ['id' => $id])->row_array();
	}
	public function getRekeningById($id)
	{
		return $this->db->get_where('rekening', ['id' => $id])->row_array();
	}
	public function getDivisiById($id)
	{
		return $this->db->get_where('divisi', ['id' => $id])->row_array();
	}
	public function getPanitiaById($id)
	{
		return $this->db->get_where('panitia', ['id' => $id])->row_array();
	}
	
}