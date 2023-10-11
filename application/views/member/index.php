	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Dashboard"></div>
		<div class="row">
            <!-- Profil Pengguna -->
            <div class="col-md-3 mx-auto">
        	    <div class="card shadow py-2 mb-4" style="border-top-color: #781010; border-top-width: 4px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mr-2">
                            	<div class="row">
                            		<img class="rounded-circle" style="width: 50px; height: 50px;" src="<?= base_url('assets/img/profile/') . $user['image']; ?>"><p class="ml-2"><b><?= $user['name'] ?></b></p>
                            	</div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow py-2" style="border-top-color: #781010; border-top-width: 4px;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="sidebar-heading">Group Saya</div>
                        </div>
                        <?php foreach ($group_saya as $gs): ?>
	                        <div class="row mb-2">
	                            <div class="col mr-2">
	                            	<div class="row">
	                            		<div class="col-sm-3">
		                            		<a href="">
			                            		<img class="rounded-circle" style="width: 50px; height: 50px;" src="<?= base_url('assets/img/logo-organisasi/') . $gs['logo']; ?>">
		                            		</a>
	                            		</div>
	                            		<div class="col-sm-9">
	                            			<p class="ml-2">
	                            				<a href=""><b><?= $gs['nama_organisasi'] ?></b></a><br>
	                            				<a href="<?= base_url('Member/batalMengikuti/'.$gs['id_organisasi']) ?>" class="badge badge-sm badge-danger">Unfollow</a>
	                            			</p>
	                            		</div>
			                        </div>
	                            </div>
	                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <!-- konten -->
            <div class="col-md-5 mx-auto">
                <div class="card shadow h-100 py-2" style="border-top-color: #781010; border-top-width: 4px;">
                    <div class="card-body">
                    	<div class="card-title h4">Tiket</div>
                        <div class="row no-gutters">
                            <div class="">
                                <div class="py-3">
                                	<?php foreach ($tiket as $row): ?>
										<div class="row no-gutters mb-4">
											<div class="col-md-5">
												<img src="<?= base_url('assets/img/acara/').$row['poster'] ?>" alt="<?= $row['poster'] ?>" style="width: 160px;">
											</div>
											<div class="col-md-7">
												<div class="">
													<h4 class="card-title" style="color: #a36362;"><?= $row['nama_acara'] ?></h5>
													<p class="card-text mb-0"><?= $row['keterangan'] ?></p>
													<p class="card-text">Penyelenggara : <?= $row['singkatan'] ?></p>
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
														<button type="button" class="btn btn-sm btn-primary checkoutModalButton" data-toggle="modal" data-target="#checkoutModal" data-id="<?= $result['id'] ?>">Beli Tiket</button>
													<?php endif ?>
												</div>
											</div>
										</div>
									<?php endforeach ?>
                                	<div class="card-title h4">Kepanitiaan</div>
									<?php foreach ($kepanitiaan as $row): ?>
										<div class="row no-gutters mb-4">
											<div class="col-md-5">
												<img src="<?= base_url('assets/img/acara/').$row['poster'] ?>" alt="<?= $row['poster'] ?>" style="width: 160px;">
											</div>
											<div class="col-md-7">
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
													<span class="badge badge-primary">Penyelenggara : <?= $row['singkatan'] ?></span>
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
									<?php endforeach ?>
									<div class="row justify-content-center mt-5">
										<?php echo $this->pagination->create_links(); ?>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4 mx-auto">
                <div class="card shadow py-2" style="border-top-color: #781010; border-top-width: 4px;">
                    <div class="card-body">
                    	<div class="card-title h4">
                    		Teman
                    	</div>
                    	<?php foreach ($teman_saya as $ts): ?>
	                        <div class="row mb-2">
	                            <div class="col mr-2">
	                            	<div class="row">
	                            		<div class="col-sm-3">
		                            		<a href="">
			                            		<img class="rounded-circle" style="width: 50px; height: 50px;" src="<?= base_url('assets/img/profile/') . $ts['image']; ?>">
		                            		</a>
	                            		</div>
	                            		<div class="col-sm-9">
	                            			<p class="ml-2">
	                            				<a href=""><b><?= $ts['name'] ?></b></a><br>
	                            				<a href="<?= base_url('Member/batalkanPertemanan/'.$ts['idu']) ?>" class="badge badge-sm badge-danger">Hapus Teman</a>
	                            			</p>
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
	<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

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


<?php foreach ($kepanitiaan as $row): ?>
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