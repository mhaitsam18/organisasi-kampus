<?php 

function getIkutiOrganisasi($id_organisasi, $id_user)
{
	$ci = get_instance();

	$ci->db->where('id_organisasi', $id_organisasi);
	$ci->db->where('id_user', $id_user);
	$ci->db->where('status', 1);
	$result = $ci->db->get('ikuti_organisasi');

	return $result->num_rows();
}

function cekUndangan($id_organisasi, $id_user)
{
	$ci = get_instance();

	$ci->db->where('id_organisasi', $id_organisasi);
	$ci->db->where('id_user', $id_user);
	$ci->db->where('status', 0);
	$result = $ci->db->get('ikuti_organisasi');

	return $result->num_rows();
}

function numPengikut($id_organisasi)
{
	$ci = get_instance();

	$ci->db->where('id_organisasi', $id_organisasi);
	$result = $ci->db->get('ikuti_organisasi');

	return $result->num_rows();
}

function getPengikut($id_organisasi = null)
{
	$ci = get_instance();

	$ci->db->select('*, ikuti_organisasi.id AS idio');
	$ci->db->join('user', 'user.id=ikuti_organisasi.id_user');
	$ci->db->where('id_organisasi', $id_organisasi);
	$result = $ci->db->get('ikuti_organisasi');

	return $result->result_array();
}

function cekPertemanan($id_user = null, $id_teman = null)
{
	$ci = get_instance();

	$ci->db->where('id_user1', $id_user);
	$ci->db->where('id_user2', $id_teman);

	$ci->db->or_where('id_user1', $id_teman);
	$ci->db->where('id_user2', $id_user);
	$result = $ci->db->get('pertemanan');

	return $result->num_rows();
}

function cekStatusPertemanan($id_user = null, $id_teman = null)
{
	$ci = get_instance();

	$ci->db->where('status', 1);

	$ci->db->where('id_user1', $id_user);
	$ci->db->where('id_user2', $id_teman);
	
	$ci->db->or_where('id_user1', $id_teman);
	$ci->db->where('id_user2', $id_user);
	$result = $ci->db->get('pertemanan');

	return $result->num_rows();
}


function base_url2($value = '')
{
	echo "http://localhost/webv3/".$value;
}

function cari_tanggal($tanggal)
{
    $bulan = '';
    switch (date('n',strtotime($tanggal))) {
        case 1: $bulan = 'Januari'; break;
        case 2: $bulan = 'Februari'; break;
        case 3: $bulan = 'Maret'; break;
        case 4: $bulan = 'April'; break;
        case 5: $bulan = 'Mei'; break;
        case 6: $bulan = 'Juni'; break;
        case 7: $bulan = 'Juli'; break;
        case 8: $bulan = 'Agustus'; break;
        case 9: $bulan = 'September'; break;
        case 10: $bulan = 'Okteber'; break;
        case 11: $bulan = 'November'; break;
        case 12: $bulan = 'Desember'; break;
    }

    return date('j',strtotime($tanggal))." $bulan ".date('Y',strtotime($tanggal));
}

?>