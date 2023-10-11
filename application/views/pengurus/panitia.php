	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Status"></div>
		<?= $this->session->flashdata('message'); ?>
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">Data Panitia</div>
				<div class="card-body">
					<table class="table table-hover" style="background-color: white;" id="dataTable">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">NIM</th>
								<th scope="col">Nama Lengkap</th>
								<th scope="col">Email</th>
								<th scope="col">Nama Acara</th>
								<th scope="col">Pilihan Divisi 1</th>
								<th scope="col">Pilihan Divisi 2</th>
								<th scope="col">Divisi Saat ini</th>
								<th scope="col">Status</th>
								<th scope="col">Aksi</th>
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
									<td><?= $row['email'] ?></td>
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
									<td>
										<a href="<?= base_url("Pengurus/updatePanitia/$row[idp]"); ?>" class="badge badge-success panitiaModalButton" data-toggle="modal" data-target="#panitiaModal" data-id="<?=$row['idp']?>">Edit Status</a>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<!-- Modal -->
<div class="modal fade" id="panitiaModal" tabindex="-1" aria-labelledby="panitiaModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="panitiaModalLabel">Update Status</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('Pengurus/updatePanitia') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<label for="email">Status</label>
						<select class="form-control" name="status" id="status">
							<option value="" selected disabled>Pilih Status</option>
							<option value="Belum diterima">Belum diterima</option>
							<option value="Lolos seleksi tahap 1">Lolos seleksi tahap 1</option>
							<option value="Lolos seleksi tahap 2">Lolos seleksi tahap 2</option>
							<option value="Lolos seleksi tahap 3">Lolos seleksi tahap 3</option>
							<option value="Sudah diterima">Sudah diterima</option>
							<option value="ditangguhkan">ditangguhkan</option>
							<option value="Tidak diterima">Tidak diterima</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>