	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
		<?= $this->session->flashdata('message'); ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Profil"></div>
		<?= form_error('password','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<div class="row">
			<div class="col-lg-8">
				<form action="<?= base_url('Pengurus/organisasi') ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" id="id" value="<?= $organisasi['ido'] ?>">
					<div class="form-group row">
						<label for="nama_organisasi" class="col-sm-2 col-form-label">Nama Organisasi</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" value="<?= $organisasi['nama_organisasi'] ?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="singkatan" class="col-sm-2 col-form-label">Singkatan</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="singkatan" name="singkatan" value="<?= $organisasi['singkatan'] ?>">
							<?= form_error('singkatan','<small class="text-danger pl-3">','</small>') ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi Organisasi</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="deskripsi" name="deskripsi"><?= $organisasi['deskripsi'] ?></textarea>
							<?= form_error('deskripsi','<small class="text-danger pl-3">','</small>') ?>
						</div>
					</div>
					<div class="form-group row">
                        <label for="id_kategori_organisasi" class="col-sm-2 col-form-label">Kategori Organisasi</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_kategori_organisasi" id="id_kategori_organisasi">
                                <option value="" selected disabled>Pilih Kategori</option>
                                <?php foreach ($kategori_organisasi as $row): ?>
                                    <?php if ($row['kategori_organisasi']== $organisasi['kategori_organisasi']): ?>
                                        <option value="<?= $row['id'] ?>" selected>
                                            <?= $row['kategori_organisasi']; ?>
                                        </option>
                                    <?php else: ?>
                                        <option value="<?= $row['id'] ?>">
                                            <?= $row['kategori_organisasi']; ?>
                                        </option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            <?= form_error('id_kategori_organisasi','<small class="text-danger pl-3">','</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
        				<div class="col-sm-2">Logo</div>
        				<div class="col-sm-10">
        					<div class="row">
        						<div class="col-sm-3">
        							<img src="<?= base_url("assets/img/logo-organisasi/$organisasi[logo]") ?>" class="img-thumbnail">
        						</div>
        						<div class="col-sm-9">
        							<div class="custom-file">
        								<input type="file" class="custom-file-input" id="logo" name="logo">
        								<label class="custom-file-label" for="logo">Pilih File</label>
        							</div>
        						</div>
        					</div>
        				</div>

        			</div>
        			<div class="form-group row">
        				<div class="col-sm">
        					<a href="<?= base_url2() ?>" class="btn btn-outline-danger float-right ml-2" target="_blank">Buka di Aplikasi Komunitas</a>
        					<button type="button" class="btn btn-info float-right ml-2" data-toggle="modal" data-target="#kirimUndanganModal">Kirim Undangan</button>
        					<button type="submit" class="btn btn-primary float-right">Simpan</button>
        				</div>
        			</div>
        		</form>
        	</div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- Button trigger modal -->

<div class="modal fade" id="kirimUndanganModal" tabindex="-1" aria-labelledby="kirimUndanganModalLabel" aria-hidden="true" style="">
	<div class="modal-dialog" style="overflow-y: initial !important">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="kirimUndanganModalLabel">Kirim Undangan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="oke" style="height: 320px; overflow-y: auto;">
				<?php foreach ($member as $m): ?>
					<img class="img-profile rounded-circle" src="<?= base_url("assets/img/profile/$m[image]"); ?>" style="height: 50px;">
					<span><?= $m['name'] ?></span>
					<?php if (getIkutiOrganisasi($organisasi['ido'], $m['id']) > 0): ?>
						<span class="text-muted float-right">Anggota</span>
					<?php elseif(cekUndangan($organisasi['ido'], $m['id']) > 0): ?>
						<span class="text-secondary float-right">Undangan Terkirim</span>
					<?php else: ?>
						<button class="btn btn-link float-right undangan<?= $m['id'] ?>" onclick="kirimUndangan(<?= $m['id'] ?>, <?= $organisasi['ido'] ?>)" id="klik<?= $m['id'] ?>"><i class="fas fa-paper-plane ikon<?= $m['id'] ?>"></i></button>
					<?php endif ?>
					<hr>
				<?php endforeach ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	<?php foreach ($member as $m): ?>
	 	$("#klik<?= $m['id'] ?>").click(function(){
			// $(".undangan<?= $m['id']; ?>").switchTag("button", "span", 500);
			$(".ikon<?= $m['id']; ?>").switchClass("fa-paper-plane", "", 500);
			$(".ikon<?= $m['id']; ?>").switchClass("", "", 500);
		};
	<?php endforeach ?>
</script>