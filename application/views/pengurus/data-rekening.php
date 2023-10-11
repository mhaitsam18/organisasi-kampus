        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Data Rekening"></div>
                    <?= form_error('id_tiket','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('no_rekening','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('bank','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('atas_nama','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <?= form_error('email','<div class="alert alert-danger" role="alert">','</div>'); ?>
                    <div class="row">
                    	<div class="col-lg-10">
                		  <a href="" class="btn btn-primary mb-3 newRekeningModalButton" data-toggle="modal" data-target="#newRekeningModal">Tambah Rekening</a>
                        	<table class="table table-hover">
                    			<thead>
                    				<tr>
                    					<th scope="col">#</th>
                                        <th scope="col">ID Tiket</th>
                                        <th scope="col">Nama Acara</th>
                                        <th scope="col">Nomor Rekening</th>
                                        <th scope="col">Bank</th>
                                        <th scope="col">Atas Nama</th>
                                        <th scope="col">Email</th>
                    					<th scope="col">Action</th>
                    				</tr>
                    			</thead>
                    			<tbody>
                					<?php $no=1; ?>
                    				<?php foreach ($rekening as $key): ?>
	                    				<tr>
	                    					<th scope="row"><?= $no ?></th>
                                            <td><?= $key['idt'] ?></td>
                                            <td><?= $key['nama_acara'] ?></td>
                                            <td><?= $key['bank'] ?></td>
                                            <td><?= $key['no_rekening'] ?></td>
                                            <td><?= $key['atas_nama'] ?></td>
                                            <td><?= $key['email'] ?></td>
	                    					<td>
	                    						<a href="<?= base_url("Pengurus/updateRekening/$key[idr]"); ?>" class="badge badge-success updateRekeningModalButton" data-toggle="modal" data-target="#newRekeningModal" data-id="<?=$key['idr']?>">Edit</a>
	                    						<a href="<?= base_url("Pengurus/deleteRekening/$key[idr]"); ?>" class="badge badge-danger tombol-hapus" data-hapus="Rekening">Delete</a>
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
            <div class="modal fade" id="newRekeningModal" tabindex="-1" aria-labelledby="newRekeningModalLabel" aria-hidden="true">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header">
            				<h5 class="modal-title" id="newRekeningModalLabel">Tambah Rekening</h5>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>
            			</div>
            			<form action="<?= base_url('Pengurus/rekening') ?>" method="post">
            				<input type="hidden" name="id" id="id">
	            			<div class="modal-body">
	            				<div class="form-group">
                                    <label for="id_tiket">Tiket</label>
                                    <select class="form-control" id="id_tiket" name="id_tiket">
                                        <option value="" selected disabled>Pilih Tiket</option>
                                        <?php foreach ($tiket as $option): ?>
                                            <option value="<?= $option['idt'] ?>"><?= $option['nama_acara'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?= form_error('id_tiket','<small class="text-danger pl-3">','</small>'); ?>
	            				</div>
                                <div class="form-group">
                                    <label for="no_rekening">No. Rekening</label>
                                    <input type="number" class="form-control" id="no_rekening" name="no_rekening">
                                    <?= form_error('no_rekening','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="bank">Bank</label>
                                    <input type="text" class="form-control" id="bank" name="bank">
                                    <?= form_error('bank','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="atas_nama">Atas Nama</label>
                                    <input type="text" class="form-control" id="atas_nama" name="atas_nama">
                                    <?= form_error('atas_nama','<small class="text-danger pl-3">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                    <?= form_error('email','<small class="text-danger pl-3">','</small>'); ?>
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

