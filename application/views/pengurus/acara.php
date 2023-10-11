	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<!-- <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1> -->
		<?= $this->session->flashdata('message'); ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Data Acara"></div>
		<?= form_error('nama_acara','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('penyelenggara','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('tanggal_dimulai','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('tanggal_berakhir','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('keterangan','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<?= $title ?>
					</div>
					<div class="card-body">
						<a href="" class="btn btn-primary mb-3 newAcaraModalButton" data-toggle="modal" data-target="#newAcaraModal">Add New Event</a>
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nama Acara</th>
									<th scope="col">Penyelenggara</th>
									<th scope="col">Waktu dimulai</th>
									<th scope="col">Waktu berakhir</th>
									<th scope="col">Poster</th>
									<th scope="col">Keterangan</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; ?>
								<?php foreach ($acara as $key): ?>
									<tr>
										<th scope="row"><?= $no ?></th>
										<td><?= $key['nama_acara'] ?></td>
										<td><?= $key['nama_organisasi'] ?></td>
										<td><?= $key['tanggal_dimulai'].' '.$key['waktu_dimulai'] ?></td>
										<td><?= $key['tanggal_berakhir'].' '.$key['waktu_berakhir'] ?></td>
										<td><img src="<?= base_url('assets/img/acara/').$key['poster'] ?>" class="img-thumbnail" style="width: 300px;"></td>
										<td><?= $key['keterangan'] ?></td>
										<td>
											<a href="<?= base_url("Pengurus/rekruitasi/$key[aid]"); ?>" class="badge badge-info">Rekruitasi</a>
											<a href="<?= base_url("Pengurus/panitia/$key[aid]"); ?>" class="badge badge-primary">Data Panitia</a>
											<a href="<?= base_url("Pengurus/tiket/$key[aid]"); ?>" class="badge badge-dark">Tiket</a>
											<a href="<?= base_url("Pengurus/updateAcara/$key[aid]"); ?>" class="badge badge-success updateAcaraModalButton" data-toggle="modal" data-target="#newAcaraModal" data-id="<?=$key['aid']?>">Edit</a>
											<a href="<?= base_url("Pengurus/deleteAcara/$key[aid]"); ?>" class="badge badge-danger tombol-hapus" data-hapus="Acara">Delete</a>
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
<!-- End of Main Content -->
<!-- Modal -->
<div class="modal fade" id="newAcaraModal" tabindex="-1" aria-labelledby="newAcaraModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newAcaraModalLabel">Add New Event</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('Pengurus/acara') ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<label for="id_organisasi">Nama Organisasi</label>
						<select class="form-control" id="id_organisasi" name="id_organisasi">
							<option value="" selected disabled>Pilih Organisasi</option>
							<?php foreach ($organisasi as $or): ?>
								<option value="<?= $or['id'] ?>"><?= $or['nama_organisasi'] ?></option>
							<?php endforeach ?>
						</select>
						<?= form_error('id_organisasi','<small class="text-danger pl-3">','</small>'); ?>
					</div>
					<div class="form-group">
						<label for="nama_acara">Nama Acara</label>
						<input type="text" class="form-control" id="nama_acara" name="nama_acara">
						<?= form_error('nama_acara','<small class="text-danger pl-3">','</small>'); ?>
					</div>
					<!-- <div class="form-group">
						<label for="penyelenggara">Penyelenggara</label>
						<input type="text" class="form-control" id="penyelenggara" name="penyelenggara">
						<?= form_error('penyelenggara','<small class="text-danger pl-3">','</small>'); ?>
					</div> -->
					<div class="form-group">
						<label for="nama_acara">Waktu dimulai</label>
						<div class="row">
							<div class="col">
								<input type="date" class="form-control" name="tanggal_dimulai" id="tanggal_dimulai" min="<?= date('Y-m-d') ?>">
								<?= form_error('tanggal_dimulai','<small class="text-danger pl-3">','</small>'); ?>
							</div>
							<div class="col">
								<input type="time" class="form-control" name="waktu_dimulai" id="waktu_dimulai">
								<?= form_error('waktu_dimulai','<small class="text-danger pl-3">','</small>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group" id="ctn">
						<label for="nama_acara">Waktu diakhiri</label>
						<div class="row">
							<div class="col">
								<input type="date" class="form-control" name="tanggal_berakhir" id="tanggal_berakhir" min="<?= date('Y-m-d') ?>">
								<?= form_error('tanggal_berakhir','<small class="text-danger pl-3">','</small>'); ?>
							</div>
							<div class="col">
								<input type="time" class="form-control" name="waktu_berakhir" id="waktu_berakhir">
								<?= form_error('waktu_berakhir','<small class="text-danger pl-3">','</small>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="poster">Poster</label>
						<input type="file" class="form-control" id="poster" name="poster">
						<?= form_error('poster','<small class="text-danger pl-3">','</small>'); ?>
					</div>
					<div class="form-group">
						<label for="keterangan">Keterangan</label>
						<textarea class="form-control" id="keterangan" name="keterangan"></textarea>
						<?= form_error('keterangan','<small class="text-danger pl-3">','</small>'); ?>
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

<script type="text/javascript">
    // ambil elements yg di buutuhkan
    var keyword = document.getElementById('tanggal_dimulai');

    var container = document.getElementById('ctn');
    // var btn = document.getElementById('button-addon2');

    // tambahkan event ketika keyword ditulis

    keyword.addEventListener('change', function () {


        //buat objek ajax
        var xhr = new XMLHttpRequest();

        // cek kesiapan ajax
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                container.innerHTML = xhr.responseText;
            }
        }
        
        xhr.open('GET', '<?= base_url('pengurus/waktu_diakhiri/') ?>' + keyword.value, true);
        xhr.send();

    })
</script>