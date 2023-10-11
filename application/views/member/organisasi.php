	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
		<?= $this->session->flashdata('message'); ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Organisasi"></div>
		<div class="row">
			<div class="col-lg-12">
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
				<div class="row">
					<?php foreach ($organisasi as $row): ?>
						<div class="card mb-3 mr-3" style="width: 45%;">
							<div class="row no-gutters">
								<div class="col-md-4">
									<img src="<?= base_url('assets/img/logo-organisasi/').$row['logo'] ?>" alt="<?= $row['logo'] ?>" style="width: 180px;">
								</div>
								<div class="col-md-8">
									<div class="card-body">
										<a href="<?= base_url('User/organisasi/'.$row['id']) ?>">
											<h4 class="card-title" style="color: #a36362;"><?= $row['nama_organisasi'] ?> (<?= $row['singkatan'] ?>)</h5>
										</a>
										<p class="card-text">
											<?= $row['deskripsi'] ?>
										</p>
										<p class="card-text">
											<?= numPengikut($row['id']); ?> Pengikut
										</p>
										<?php if (getIkutiOrganisasi($row['id'], $user['id']) > 0): ?>
											<a href="<?= base_url('member/batalMengikuti/'.$row['id']) ?>" class="btn btn-secondary btn-sm">mengikuti</a>
										<?php else: ?>
											<a href="<?= base_url('member/ikutiOrganisasi/'.$row['id']) ?>" class="btn btn-primary btn-sm">Ikuti</a>
										<?php endif ?>
										<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#pengikutModal<?= $row['id'] ?>">
											Lihat Pengikut
										</button>

									</div>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
				<?php if (empty($organisasi)): ?>
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
<?php foreach ($organisasi as $modal): ?>
	<div class="modal fade" id="pengikutModal<?= $modal['id'] ?>" tabindex="-1" aria-labelledby="pengikutModalLabel<?= $modal['id'] ?>" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="pengikutModalLabel<?= $modal['id'] ?>">Daftar Pengikut</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php if (numPengikut($modal['id']) < 1): ?>
						Pengikut Tidak Tersedia
					<?php else: ?>
						<?php foreach (getPengikut($modal['id']) as $p): ?>
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