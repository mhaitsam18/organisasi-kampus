<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataMaster_model extends CI_Model {

	public function getAgamaById($id)
	{
		return $this->db->get_where('agama', ['id' => $id])->row_array();
	}
	public function getMetodeBayarById($id)
	{
		return $this->db->get_where('metode_bayar', ['id' => $id])->row_array();
	}
	public function getKategoriOrganisasiById($id)
	{
		return $this->db->get_where('kategori_organisasi', ['id' => $id])->row_array();
	}
	
}