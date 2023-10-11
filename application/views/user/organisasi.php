	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- ​
		<picture>
			<source srcset="<?= base_url('assets/img/logo-organisasi/').$organisasi->logo ?>" type="image/svg+xml">
			<img src="<?= base_url('assets/img/logo-organisasi/').$organisasi->logo ?>" class="img-fluid img-thumbnail" alt="...">
		</picture> -->
		<div class="text-center">
			<img src="<?= base_url('assets/img/logo-organisasi/').$organisasi->logo ?>" class="rounded" style="width: 200px; height: 200px;">
		</div>
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><?= $organisasi->nama_organisasi ?></h4>
				<?php if (getIkutiOrganisasi($organisasi->ido, $user['id']) > 0): ?>
					<a href="<?= base_url('member/batalMengikuti/'.$organisasi->ido) ?>" class="btn btn-secondary btn-sm mb-2">mengikuti</a>
				<?php else: ?>
					<a href="<?= base_url('member/ikutiOrganisasi/'.$organisasi->ido) ?>" class="btn btn-primary btn-sm mb-2">Ikuti</a>
				<?php endif ?>
				<button type="button" class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#pengikutModal">
					Lihat Pengikut
				</button>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profil Organisasi</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Acara</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Kepanitiaan</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<p class="card-text">
							<div class="row mb-3">
								<div class="col-md-2">
									Nama Organisasi
								</div>
								<div class="col-md-10">
									: <?= $organisasi->nama_organisasi ?> / <?= $organisasi->singkatan ?>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-2">
									Deskripsi
								</div>
								<div class="col-md-10">
									: <?= $organisasi->deskripsi ?>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-2">
									Kategori Organisasi
								</div>
								<div class="col-md-10">
									: <?= $organisasi->kategori_organisasi ?>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-2">
									Status
								</div>
								<div class="col-md-10">
									: 
									<?php if ($organisasi->status == 0): ?>
										<span class="badge badge-danger">Tidak Aktif</span>
									<?php else: ?>
										<span class="badge badge-success">Aktif</span>
									<?php endif ?>
								</div>
							</div>
							
						</p>
					</div>
					<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<div class="row">
							<?php foreach ($tiket as $row): ?>
								<div class="card mb-1 mr-1" style="width: 49%;">
									<div class="row no-gutters">
										<div class="col-md-4">
											<img src="<?= base_url('assets/img/acara/').$row['poster'] ?>" alt="<?= $row['poster'] ?>" style="width: 180px;">
										</div>
										<div class="col-md-8">
											<div class="card-body">
												<h4 class="card-title" style="color: #a36362;"><?= $row['nama_acara'] ?></h5>
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
						</div>
					</div>
					<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
						<div class="row">
							<?php foreach ($rekruitasi as $row): ?>
								<div class="card mb-1 mr-1" style="width: 49%;">
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
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="pengikutModal" tabindex="-1" aria-labelledby="pengikutModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="pengikutModalLabel">Daftar Pengikut</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php if (numPengikut($organisasi->ido) < 1): ?>
					Pengikut Tidak Tersedia
				<?php else: ?>
					<?php foreach (getPengikut($organisasi->ido) as $p): ?>
						<img class="img-profile rounded-circle" src="<?= base_url("assets/img/profile/$p[image]"); ?>" style="height: 50px;">
						<span><?= $p['name'] ?></span>
						<?php if ($p['id_user'] != $user['id']): ?>
							<?php if (cekPertemanan($user['id'], $p['id_user']) < 1): ?>
								<a href="<?= base_url('Member/berteman/'.$p['id_user']); ?>" class="btn btn-link float-right"><i class="fas fa-user-plus"></i></a>
							<?php elseif(cekStatusPertemanan($user['id'], $p['id_user']) < 1): ?>
								<a href="<?= base_url('Member/batalkanPertemanan/'.$p['id_user']); ?>" class="btn btn-link float-right"><i class="fas fa-user-times text-danger"></i></a>
							<?php else: ?>
								<a href="<?= base_url('Member/batalkanPertemanan/'.$p['id_user']); ?>" class="btn btn-link float-right"><i class="fas fa-user-check text-success pengikut<?= $p['idio']; ?>" id="hov<?= $p['idio']; ?>"></i></a>
							<?php endif ?>
						<?php endif ?>
						<hr>
					<?php endforeach ?>
				<?php endif ?>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>
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
<!-- Modal -->
<?php foreach ($rekruitasi as $row): ?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	<?php 
	$pengikut = $this->db->get('ikuti_organisasi')->result();
	 ?>
	<?php foreach ($pengikut as $pe): ?>
		$("#hov<?= $pe->id; ?>").hover(function(){
			$(".pengikut<?= $pe->id; ?>").switchClass("text-success", "text-danger", 500);
			$(".pengikut<?= $pe->id; ?>").switchClass("fa-user-check", "fa-user-times", 500);
		}, function(){
			$(".pengikut<?= $pe->id; ?>").switchClass("text-danger", "text-success", 500);
			$(".pengikut<?= $pe->id; ?>").switchClass("fa-user-times", "fa-user-check", 500);
		});
	<?php endforeach ?>
	// var modal = document.getElementById('kirimUndanganModal');
	// modal.style.display = "block";
</script>