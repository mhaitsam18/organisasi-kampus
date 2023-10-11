	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<!-- <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1> -->
		<?= $this->session->flashdata('message'); ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Data Divisi"></div>
		<?= form_error('id_rekruitasi','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('nama_divisi','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<?= $title ?>
					</div>
					<div class="card-body">
						<a href="" class="btn btn-primary mb-3 newDivisiModalButton" data-toggle="modal" data-target="#newDivisiModal">Add New Division</a>
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nama Rekruitasi Acara</th>
									<th scope="col">Divisi</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; ?>
								<?php foreach ($divisi as $key): ?>
									<tr>
										<th scope="row"><?= $no ?></th>
										<td><?= $key['nama_acara'] ?></td>
										<td><?= $key['nama_divisi'] ?></td>
										<td>
											<a href="<?= base_url("Pengurus/updateDivisi/$key[idd]"); ?>" class="badge badge-success updateDivisiModalButton" data-toggle="modal" data-target="#newDivisiModal" data-id="<?=$key['idd']?>">Edit</a>
											<a href="<?= base_url("Pengurus/deleteDivisi/$key[idd]"); ?>" class="badge badge-danger tombol-hapus" data-hapus="Divisi">Delete</a>
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
<div class="modal fade" id="newDivisiModal" tabindex="-1" aria-labelledby="newDivisiModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newDivisiModalLabel">Add New Division</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('Pengurus/divisi') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<label for="id_rekruitasi">ID | Nama Acara</label>
						<select class="form-control" id="id_rekruitasi" name="id_rekruitasi">
								<option value="" selected disabled>Pilih Acara</option>
							<?php foreach ($rekruitasi as $item): ?>
								<option value="<?= $item['idr'] ?>">ID Rekruitasi <?= $item['idr'] ?> | <?= $item['nama_acara'] ?></option>
							<?php endforeach ?>
						</select>
						<?= form_error('id_rekruitasi','<small class="text-danger pl-3">','</small>'); ?>
					</div>
					<div class="form-group">
						<label for="nama_divisi">Nama Divisi</label>
						<input class="form-control" id="nama_divisi" name="nama_divisi">
						<?= form_error('nama_divisi','<small class="text-danger pl-3">','</small>'); ?>
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