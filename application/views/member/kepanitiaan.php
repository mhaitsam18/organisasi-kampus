	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
		<?= $this->session->flashdata('message'); ?>
		<?= form_error('nim','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('nama_lengkap','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('id_pilihan_divisi_1','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('id_rekruitasi','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Pesanan"></div>
		<div class="row">
			<div class="col-lg-8">
				<div class="row mb-3">
					<div class="col-md">
						<h5>Results: <?= $total_rows ?></h5>
						<form action="" method="post">
							<div class="form-row">
								<div class="col">
									<input type="text" class="form-control" placeholder="Search" name="keyword" id="keyword" value="<?= set_value('keyword') ?>">
								</div>
								<div class="col">
									<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Search">
								</div>
								
							</div>
						</form>
					</div>
				</div>
				<?php foreach ($acara as $row): ?>
					<div class="card mb-3" style="max-width: 540px;">
						<div class="row no-gutters">
							<div class="col-md-4">
								<img src="<?= base_url('assets/img/acara/').$row['poster'] ?>" alt="<?= $row['poster'] ?>" style="width: 180px;">
							</div>
							<div class="col-md-8">
								<div class="card-body">
									<h4 class="card-title" style="color: #a36362;"><?= $row['nama_acara'] ?></h5>
									<?php 
										$deadline  = strtotime($row['batas_waktu']);
										$sekarang    = time();
										$diff   = $deadline - $sekarang;
										$total_hari = floor($diff / (60 * 60 * 24));
									?>
									<?php if ($total_hari < 0): ?>
										<?php $color = 'text-danger' ?>
									<?php else: ?>
										<?php $color = 'text-info' ?>
									<?php endif ?>
									<p class="card-text <?= $color ?>">Deadline Pendaftaran: <?= date('j F Y', strtotime($row['batas_waktu'])) ?></p>
									<p class="card-text">
										<?= $row['catatan'] ?>
									</p>
									<?php if ($total_hari < 0): ?>
										<span class="btn btn-secondary">Daftar</span>
									<?php else: ?>
										<button class="btn btn-primary daftarPanitiaModalButton" data-toggle="modal" data-target="#daftarPanitiaModal<?= $row['idr'] ?>" data-id="<?= $row['idr'] ?>">Daftar</button>
									<?php endif ?>
									<a href="<?= base_url('Member/rekruitasi/'.$row['idr']) ?>" class="btn btn-success"><i class="fas fa-list"></i> List Pendaftar</a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
				<?php if (empty($acara)): ?>
					Data not Found
				<?php endif ?>
				<div class="row justify-content-center mt-5">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			</div>
		</div>
	</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<!-- Button trigger modal -->

<!-- Modal -->
<?php foreach ($acara as $row): ?>
	<div class="modal fade" id="daftarPanitiaModal<?= $row['idr'] ?>" tabindex="-1" aria-labelledby="daftarPanitiaModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="daftarPanitiaModalLabel">Daftar Panitia</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('Member/daftarPanitia') ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id_rekruitasi" id="id_rekruitasi" value="<?= $row['idr'] ?>">
					<div class="modal-body">
						<div class="form-group">
							<label for="nim">NIM</label>
							<input type="number" class="form-control" name="nim" id="nim">
						</div>
						<div class="form-group">
							<label for="nama_lengkap">Nama Lengkap</label>
							<input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" name="email" id="email">
						</div>
						<?php $divisi = $this->db->get_where('divisi', ['id_rekruitasi' => $row['idr']])->result_array(); ?>
						<div class="form-group">
							<label for="id_pilihan_divisi_1">Pilihan Divisi 1</label>
							<select class="form-control" name="id_pilihan_divisi_1" id="id_pilihan_divisi_1">
								<option selected disabled value="">Pilih Divisi</option>
								<?php foreach ($divisi as $item): ?>
									<option value="<?= $item['id'] ?>"><?= $item['nama_divisi'] ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group">
							<label for="id_pilihan_divisi_2">Pilihan Divisi 2</label>
							<select class="form-control" name="id_pilihan_divisi_2" id="id_pilihan_divisi_2">
								<option selected value="0">Pilih Divisi</option>
								<?php foreach ($divisi as $item): ?>
									<option value="<?= $item['id'] ?>"><?= $item['nama_divisi'] ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group">
							<label for="file_cv">File CV (.pdf)</label>
							<input type="file" class="form-control" name="file_cv" id="file_cv" max="3">
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-outline-success">Daftar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endforeach ?>