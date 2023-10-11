<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
		<?php if (validation_errors()): ?>
			<div class="alert alert-danger" role="alert">
				<?= validation_errors(); ?>
			</div>
		<?php endif ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Data User"></div>
		<?= $this->session->flashdata('message'); ?>
		<button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#cariTemanModal">
			Cari Teman
		</button>
		<div class="row mb-4">
			<div class="col-lg">
				<div class="card">
					<div class="card-header"><i class="fas fa-user-plus mr-1"></i>List Permintaan Teman</div>
					<div class="card-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Name</th>
									<th scope="col">Email</th>
                                    <th scope="col">Image</th>
                					<th scope="col">Action</th>
                				</tr>
                			</thead>
                			<tbody>
            					<?php $no=1; ?>
                				<?php foreach ($permintaan_teman as $key): ?>
                    				<tr>
                    					<th scope="row"><?= $no ?></th>
                    					<td><?= $key['name'] ?></td>
                                        <td><?= $key['email'] ?></td>
                                        <td><img src="<?= base_url("assets/img/profile/$key[image]") ?>" class="img-thumbnail" style="height: 100px;"></td>
                    					<td><a href="<?= base_url('User/terimaPertemanan/'.$key['idp']) ?>" class="badge badge-primary">Terima</a></td>
                    					<td><a href="<?= base_url('User/hapusPertemanan/'.$key['idp']) ?>" class="badge badge-danger">Tolak</a></td>
                    				</tr>
                    			<?php $no++; ?>
                				<?php endforeach ?>
                				<?php if ($no == 1): ?>
                					<tr><td colspan="5">List Tidak Tersedia</td></tr>
                				<?php endif ?>
                			</tbody>
                		</table>
                    </div>
                </div>
        	</div>
        </div>
        <div class="row mb-4">
			<div class="col-lg">
				<div class="card">
					<div class="card-header"><i class="fas fa-user mr-1"></i>Permintaan Teman terkirim</div>
					<div class="card-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Name</th>
									<th scope="col">Email</th>
                                    <th scope="col">Image</th>
                					<th scope="col">Action</th>
                				</tr>
                			</thead>
                			<tbody>
            					<?php $no=1; ?>
                				<?php foreach ($permintaan_terkirim as $key): ?>
                    				<tr>
                    					<th scope="row"><?= $no ?></th>
                    					<td><?= $key['name'] ?></td>
                                        <td><?= $key['email'] ?></td>
                                        <td><img src="<?= base_url("assets/img/profile/$key[image]") ?>" class="img-thumbnail" style="height: 100px;"></td>
                    					<td><a href="<?= base_url('User/hapusPertemanan/'.$key['idp']) ?>" class="badge badge-danger">Batalkan Permintaan</a></td>
                    				</tr>
                    			<?php $no++; ?>
                				<?php endforeach ?>
                				<?php if ($no == 1): ?>
                					<tr><td colspan="5">List Tidak Tersedia</td></tr>
                				<?php endif ?>
                			</tbody>
                		</table>
                    </div>
                </div>
        	</div>
        </div>
        <div class="row">
			<div class="col-lg">
				<div class="card">
					<div class="card-header"><i class="fas fa-user-check mr-1"></i>List Pertemanan</div>
					<div class="card-body">
						<table class="table table-hover" id="dataTable">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Name</th>
									<th scope="col">Email</th>
                                    <th scope="col">Image</th>
                					<th scope="col">Action</th>
                				</tr>
                			</thead>
                			<tbody>
            					<?php $no=1; ?>
                				<?php foreach ($pertemanan as $key): ?>
                    				<tr>
                    					<th scope="row"><?= $no ?></th>
                    					<td><?= $key['name'] ?></td>
                                        <td><?= $key['email'] ?></td>
                                        <td><img src="<?= base_url("assets/img/profile/$key[image]") ?>" class="img-thumbnail" style="height: 100px;"></td>
                    					<td>
                    						<a href="<?= base_url('User/hapusPertemanan/'.$key['idp']) ?>" class="badge badge-danger tombol-hapus" data-hapus="pertemanan">Hapus Pertemanan</a>
                    						<a href="" class="badge badge-info"  data-toggle="modal" data-target="#kirimPesanModal<?= $key['idu'] ?>">Kirim Pesan</a>
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
<div class="modal fade" id="cariTemanModal" tabindex="-1" aria-labelledby="cariTemanModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="cariTemanModalLabel">Cari Teman</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php foreach ($users as $p): ?>
					<img class="img-profile rounded-circle" src="<?= base_url("assets/img/profile/$p[image]"); ?>" style="height: 50px;">
					<span><?= $p['name'] ?></span>
					<?php if ($p['id'] != $user['id']): ?>
						<?php if (cekPertemanan($user['id'], $p['id']) < 1): ?>
							<a href="<?= base_url('User/berteman/'.$p['id']); ?>" class="btn btn-link float-right"><i class="fas fa-user-plus"></i></a>
						<?php elseif(cekStatusPertemanan($user['id'], $p['id']) < 1): ?>
							<a href="<?= base_url('User/batalkanPertemanan/'.$p['id']); ?>" class="btn btn-link float-right"><i class="fas fa-user-times text-danger"></i></a>
						<?php else: ?>
							<span class="btn btn-link float-right"><i class="fas fa-user-check text-success"></i></span>
						<?php endif ?>
					<?php endif ?>
					<hr>
				<?php endforeach ?>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>

<?php foreach ($pertemanan as $per): ?>
	<div class="modal fade" id="kirimPesanModal<?= $per['idu'] ?>" tabindex="-1" aria-labelledby="kirimPesanModalLabel<?= $per['idu'] ?>" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="kirimPesanModalLabel<?= $per['idu'] ?>">Kirim Pesan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('User/kirimPesan') ?>" method="post">
					<div class="modal-body">
						<h5 class="modal-title">To: <?= $per['name'] ?></h5>
						<input type="hidden" name="id_user_to" id="id_user_to" value="<?= $per['idu'] ?>">
						<div class="form-group">
							<label for="message">Pesan</label>
							<textarea class="form-control" name="message" id="message"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Kirim</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endforeach ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	// var modal = document.getElementById('kirimUndanganModal');
	// modal.style.display = "block";
</script>