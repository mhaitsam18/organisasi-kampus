	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Selamat!"></div>
		<?= $this->session->flashdata('message'); ?>
		<div class="col-lg-12">
			<table class="table table-bordered" style="background-color: white;" id="dataTable">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">NIM</th>
						<th scope="col">Nama Lengkap</th>
						<th scope="col">Nama Acara</th>
						<th scope="col">Pilihan Divisi 1</th>
						<th scope="col">Pilihan Divisi 2</th>
						<th scope="col">Divisi Saat ini</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=0; ?>
					<?php foreach ($panitia as $row): ?>
						<?php if ($row['status'] == 'Sudah diterima'){
							$color = 'table-success';
						} elseif($row['status'] == 'Lolos seleksi tahap 1' || $row['status'] == 'Lolos seleksi tahap 2' || $row['status'] == 'Lolos seleksi tahap 3'){
							$color = 'table-info';
						} elseif($row['status'] == 'ditangguhkan'){
							$color = 'table-warning';
						} elseif ($row['status'] == 'Tidak diterima') {
							$color = 'table-danger';
						} else{
							$color = '';
						}

						 ?>

						<tr class="<?= $color ?>">
							<th scope="row"><?= ++$no ?></th>
							<td><?= $row['nim'] ?></td>
							<td><?= $row['nama_lengkap'] ?></td>
							<td><?= $row['nama_acara'] ?></td>
							<?php $divisi1 = $this->db->get_where('divisi', ['id' => $row['id_pilihan_divisi_1']])->row_array(); ?>
							<?php $divisi2 = $this->db->get_where('divisi', ['id' => $row['id_pilihan_divisi_2']])->row_array(); ?>
							<td><?= $divisi1['nama_divisi'] ?></td>
							<td><?= $divisi2['nama_divisi'] ?></td>
							<?php if ($row['divisi'] != 0): ?>
								<?php $divisi = $this->db->get_where('divisi', ['id' => $row['divisi']])->row_array(); ?>
								<td><?= $divisi['nama_divisi'] ?></td>
							<?php else: ?>
								<td>Belum diterima di Divisi mana pun</td>
							<?php endif ?>
							<td><?= $row['status'] ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->