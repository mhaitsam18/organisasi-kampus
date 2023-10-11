	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<!-- <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1> -->
		<?= $this->session->flashdata('message'); ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Data Rekruitasi"></div>
		<?= form_error('id_acara','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('batas_waktu','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('batas_tanggal','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('batas_jam','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('catatan','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<?= $title ?>
					</div>
					<div class="card-body">
						<a href="" class="btn btn-primary mb-3 newRekruitasiModalButton" data-toggle="modal" data-target="#newRekruitasiModal">Add New Recruitment</a>
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nama Acara</th>
									<th scope="col">Batas Waktu Pendaftaran</th>
									<th scope="col">Catatan</th>
									<th scope="col">Status</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; ?>
								<?php foreach ($rekruitasi as $key): ?>
									<?php $num = $this->db->get_where('divisi', ['id_rekruitasi' => $key['idr']])->num_rows(); ?>
									<?php if ($num < 1): ?>
										<?php $color = 'table-danger' ?>
										<?php $status = 'Divisi Tidak Tersedia' ?>
									<?php else: ?>
										<?php $color = '' ?>
										<?php $status = '' ?>
									<?php endif ?>
									<tr class="<?= $color ?>">
										<th scope="row"><?= $no ?></th>
										<td><?= $key['nama_acara'] ?></td>
										<td><?= $key['batas_waktu'] ?></td>
										<td><?= $key['catatan'] ?></td>
										<td><?= $status ?></td>
										<td>
											<a href="<?= base_url("Pengurus/updateRekruitasi/$key[idr]"); ?>" class="badge badge-success updateRekruitasiModalButton" data-toggle="modal" data-target="#newRekruitasiModal" data-id="<?=$key['idr']?>">Edit</a>
											<a href="<?= base_url("Pengurus/deleteRekruitasi/$key[idr]"); ?>" class="badge badge-danger tombol-hapus" data-hapus="Rekruitasi">Delete</a>
											<a href="<?= base_url("Pengurus/divisi/$key[idr]"); ?>" class="badge badge-info">Pilihan Divisi</a>
										</td>
									</tr>
									<?php $no++; ?>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<!-- Modal -->
<div class="modal fade" id="newRekruitasiModal" tabindex="-1" aria-labelledby="newRekruitasiModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newRekruitasiModalLabel">Add New Recruitment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('Pengurus/rekruitasi') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<label for="id_acara">ID | Nama Acara</label>
						<select class="form-control" id="id_acara" name="id_acara">
								<option value="" selected disabled>Pilih Acara</option>
							<?php foreach ($acara as $item): ?>
								<option value="<?= $item['aid'] ?>"><?= $item['aid'] ?> | <?= $item['nama_acara'] ?></option>
							<?php endforeach ?>
						</select>
						<?= form_error('id_acara','<small class="text-danger pl-3">','</small>'); ?>
					</div>
					<div class="form-group">
						<label for="batas_waktu">Batas Waktu Rekruitasi</label>
						<div class="form-row">
							<div class="col">
								<input type="date" class="form-control" id="batas_tanggal" name="batas_tanggal">
								<?= form_error('batas_tanggal','<small class="text-danger pl-3">','</small>'); ?>
							</div>
							<div class="col">
								<input type="time" class="form-control" id="batas_jam" name="batas_jam">
								<?= form_error('batas_jam','<small class="text-danger pl-3">','</small>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="catatan">Catatan</label>
						<textarea class="form-control" id="catatan" name="catatan"></textarea>
						<?= form_error('catatan','<small class="text-danger pl-3">','</small>'); ?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>