        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Data Organisasi"></div>
                    <?= form_error('nama_organisasi','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                    	<div class="col-lg-12">
                		  <!-- <a href="" class="btn btn-primary mb-3 newOrganisasiModalButton" data-toggle="modal" data-target="#newOrganisasiModal">Add New Organization</a> -->
                        	<table class="table table-hover" id="dataTable">
                    			<thead>
                    				<tr>
                    					<th scope="col">#</th>
                                        <th scope="col">Nama Pengurus</th>
                                        <th scope="col">Nama Organisasi</th>
                                        <th scope="col">Nama Lain (Singkatan)</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Logo</th>
                    					<th scope="col">Action</th>
                    				</tr>
                    			</thead>
                    			<tbody>
                					<?php $no=1; ?>
                    				<?php foreach ($organisasi as $key): ?>
	                    				<tr>
	                    					<th scope="row"><?= $no ?></th>
                                            <td><?= $key['name'] ?></td>
                                            <td><?= $key['nama_organisasi'] ?></td>
                                            <td><?= $key['singkatan'] ?></td>
                                            <td><?= $key['deskripsi'] ?></td>
                                            <td><?= $key['kategori_organisasi'] ?></td>
                                            <td>
                                                <?php if ($key['status'] == 1){
                                                    echo "Aktif";
                                                } else{
                                                    echo "Tidak Aktif";
                                                } ?>
                                            </td>
                                            <td><img src="<?= base_url('assets/img/logo-organisasi/'.$key['logo']) ?>" class="img-thumbnail" style="width: 100px;"></td>
	                    					<td>
                                                <?php if ($key['status']==1): ?>
                                                    <a href="<?= base_url('Organisasi/activated/'.$key['ido'].'/0') ?>" class="badge badge-danger">Deactive</a>
                                                <?php else: ?>
                                                    <a href="<?= base_url('Organisasi/activated/'.$key['ido'].'/1') ?>" class="badge badge-success">Active</a>
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
            <div class="modal fade" id="newOrganisasiModal" tabindex="-1" aria-labelledby="newOrganisasiModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="newOrganisasiModalLabel">Add New Organization</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('Admin/organisasi') ?>" method="post">
            				<input type="hidden" name="id" id="id">
	            			<div class="modal-body">
	            				<div class="form-group">
	            					<label for="nama_organisasi"></label>
	            					<input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" placeholder="Religion">
                                    <?= form_error('nama_organisasi','<small class="text-danger pl-3">','</small>'); ?>
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

