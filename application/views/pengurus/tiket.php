	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<!-- <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1> -->
		<?= $this->session->flashdata('message'); ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Data Tiket"></div>
		<?= form_error('harga','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('id_acara','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('stok_tiket','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<?= $title ?>
					</div>
					<div class="card-body">
						<a href="" class="btn btn-primary mb-3 newTiketModalButton" data-toggle="modal" data-target="#newTiketModal">Add New Ticket</a>
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nama Acara</th>
									<th scope="col">Harga</th>
									<th scope="col">Stok Tiket</th>
									<th scope="col">Jumlah Terjual</th>
									<th scope="col">Status</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; ?>
								<?php foreach ($tiket as $key): ?>
									<?php $num = $this->db->get_where('rekening',['id_tiket' => $key['idt']])->num_rows();
									if ($num < 1) {
										$table = "table-danger";
										$status = "Data Rekening Tidak Tersedia";
									 } else{
										$table = "";
										$status = "";
									 }
									?>
									<tr class="<?= $table ?>">
										<th scope="row"><?= $no ?></th>
										<td><?= $key['nama_acara'] ?></td>
										<td>Rp. <?= number_format($key['harga'],2,',','.') ?></td>
										<td><?= $key['stok_tiket'] ?></td>
										<td><?= $key['jumlah_terjual'] ?></td>
										<td><?= $status ?></td>
										<td>
											<a href="<?= base_url("Pengurus/updateTiket/$key[idt]"); ?>" class="badge badge-success updateTiketModalButton" data-toggle="modal" data-target="#newTiketModal" data-id="<?=$key['idt']?>">Edit</a>
											<a href="<?= base_url("Pengurus/deleteTiket/$key[idt]"); ?>" class="badge badge-danger tombol-hapus" data-hapus="Tiket">Delete</a>
											<a href="<?= base_url("Pengurus/rekening/$key[idt]"); ?>" class="badge badge-info">Kelola Rekening Pembayaran</a>
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
<div class="modal fade" id="newTiketModal" tabindex="-1" aria-labelledby="newTiketModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newTiketModalLabel">Add New Ticket</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('Pengurus/tiket') ?>" method="post">
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
						<label for="harga">Harga</label>
						<input type="number" class="form-control" id="harga" name="harga">
						<?= form_error('harga','<small class="text-danger pl-3">','</small>'); ?>
					</div>
					<div class="form-group">
						<label for="stok_tiket">Stok Tiket</label>
						<input type="number" class="form-control" id="stok_tiket" name="stok_tiket">
						<?= form_error('stok_tiket','<small class="text-danger pl-3">','</small>'); ?>
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