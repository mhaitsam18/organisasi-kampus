        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Data Kategori Organisasi"></div>
                    <?= form_error('kategori_organisasi','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                    	<div class="col-lg-6">
                		  <a href="" class="btn btn-primary mb-3 newKategoriOrganisasiModalButton" data-toggle="modal" data-target="#newKategoriOrganisasiModal">Tambah Kategori Organisasi</a>
                        	<table class="table table-hover">
                    			<thead>
                    				<tr>
                    					<th scope="col">#</th>
                                        <th scope="col">Kategori Organisasi</th>
                    					<th scope="col">Action</th>
                    				</tr>
                    			</thead>
                    			<tbody>
                					<?php $no=1; ?>
                    				<?php foreach ($kategori_organisasi as $key): ?>
	                    				<tr>
	                    					<th scope="row"><?= $no ?></th>
                                            <td><?= $key['kategori_organisasi'] ?></td>
	                    					<td>
	                    						<a href="<?= base_url("DataMaster/updateKategoriOrganisasi/$key[id]"); ?>" class="badge badge-success updateKategoriOrganisasiModalButton" data-toggle="modal" data-target="#newKategoriOrganisasiModal" data-id="<?=$key['id']?>">Edit</a>
	                    						<a href="<?= base_url("DataMaster/deleteKategoriOrganisasi/$key[id]"); ?>" class="badge badge-danger tombol-hapus" data-hapus="Kategori Organisasi">Delete</a>
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
            <div class="modal fade" id="newKategoriOrganisasiModal" tabindex="-1" aria-labelledby="newKategoriOrganisasiModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="newKategoriOrganisasiModalLabel">Tambah Kategori Organisasi</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('DataMaster/KategoriOrganisasi') ?>" method="post">
            				<input type="hidden" name="id" id="id">
	            			<div class="modal-body">
	            				<div class="form-group">
	            					<label for="kategori_organisasi">Kategori Organisasi</label>
	            					<input type="text" class="form-control" id="kategori_organisasi" name="kategori_organisasi" placeholder="Kategori Organisasi">
                                    <?= form_error('kategori_organisasi','<small class="text-danger pl-3">','</small>'); ?>
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

