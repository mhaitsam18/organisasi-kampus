	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
		<?= $this->session->flashdata('message'); ?>
		<?= form_error('id_tiket','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('jumlah','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('email','<div class="alert alert-danger" role="alert">','</div>'); ?>
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
										<span class="badge badge-primary">Penyelenggara: <?= $row['nama_organisasi'] ?></span>
									<p class="card-text"><?= $row['keterangan'] ?></p>
									<p class="card-text">
										<?php 
										$result = $this->db->get_where('tiket',['id_acara' => $row['ida']])->row_array();
										if ($result) : ?>
											<?php if ($result['stok_tiket']-$result['jumlah_terjual']> 10): ?>
												<small class="text-muted font-weight-bold">
													Stok: <?= $result['stok_tiket']-$result['jumlah_terjual'] ?>
												</small>
											<?php elseif($result['stok_tiket']-$result['jumlah_terjual']> 0): ?>
												<small class="text-danger font-weight-bold">
													Stok Tiket tersisa <?= $result['stok_tiket']-$result['jumlah_terjual'] ?> buah
												</small>
											<?php else: ?>
												<small class="text-danger font-weight-bold">
													Stok Tiket Habis
												</small>
											<?php endif ?>
										<?php endif  ?>
									</p>
									<div class="btn btn-sm btn-success">Rp. <?= number_format($result['harga'],2,',','.') ?></div>
									<?php if ($result['stok_tiket']-$result['jumlah_terjual'] < 1): ?>
										<span class="btn btn-sm btn-secondary">Beli Tiket</span>
									<?php else: ?>
										<button type="button" class="btn btn-sm btn-primary checkoutModalButton" data-toggle="modal" data-target="#checkoutModal" data-id="<?= $result['id'] ?>">
											<?php if ($result['harga'] == 0): ?>
												Klaim Tiket
											<?php else: ?>
												Beli Tiket
											<?php endif ?>
										</button>
									<?php endif ?>
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
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('Member/checkout') ?>" method="post">
				<input type="hidden" name="id_tiket" id="id_tiket">
				<div class="modal-body">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" id="email">
					</div>
					<div class="form-group">
						<label for="jumlah">Jumlah Tiket</label>
						<input type="number" class="form-control" name="jumlah" id="jumlah" max="3">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Checkout</button>
				</div>
			</form>
		</div>
	</div>
</div>