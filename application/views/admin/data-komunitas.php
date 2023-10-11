	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
		<?= $this->session->flashdata('message'); ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Data Komunitas"></div>
		<?= form_error('nama','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<div class="row">
			<div class="col-lg-12">
				<!-- <a href="" class="btn btn-primary mb-3 newKomunitasModalButton" data-toggle="modal" data-target="#newKomunitasModal">Add New Organization</a> -->
				<table class="table table-hover" id="dataTable">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nama Creator</th>
							<th scope="col">Nama Komunitas</th>
							<th scope="col">Deskripsi</th>
							<th scope="col">Status</th>
							<th scope="col">Logo</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; ?>
						<?php foreach ($komunitas as $key): ?>
							<tr>
								<th scope="row"><?= $no ?></th>
								<td><?= $key['name'] ?></td>
								<td><?= $key['nama'] ?></td>
								<td><?= $key['detail'] ?></td>
								<td>
									<?php if ($key['is_valid'] == 1){
										echo "Valid";
									} else{
										echo "Tidak Valid";
									} ?>
								</td>
								<td><img src="<?= base_url2('assets/images/komunitas/'.$key['logo']) ?>" class="img-thumbnail" style="width: 100px;"></td>
            					<td>
                                    <?php if ($key['is_valid']==1): ?>
                                        <a href="<?= base_url('Komunitas/activated/'.$key['idk'].'/0') ?>" class="badge badge-danger">Tidak Valid</a>
                                    <?php else: ?>
                                        <a href="<?= base_url('Komunitas/activated/'.$key['idk'].'/1') ?>" class="badge badge-success">Validasi</a>
                                    <?php endif ?>
                                </td>
            				</tr>
            			<?php $no++; ?>
        				<?php endforeach ?>
        			</tbody>
        		</table>
        	</div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="newKomunitasModal" tabindex="-1" aria-labelledby="newKomunitasModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newKomunitasModalLabel">Add New Community</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('Admin/komunitas') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
    				<div class="form-group">
    					<label for="nama_komunitas"></label>
    					<input type="text" class="form-control" id="nama_komunitas" name="nama_komunitas" placeholder="Religion">
                        <?= form_error('nama_komunitas','<small class="text-danger pl-3">','</small>'); ?>
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

