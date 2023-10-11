<!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
        <?= $this->session->flashdata('message'); ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Status Pemesanan"></div>
        <div class="col-lg-12">
			<h3 class="h3 mt-5">Invoice Customer</h3>
			<table class="table table-bordered table-responsive" style="background-color: white;" id="dataTable">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Kode Bayar</th>
						<th scope="col">Nama Penerima</th>
						<th scope="col">Email</th>
						<th scope="col">Total</th>
						<th scope="col">Metode Bayar</th>
						<th scope="col">Status</th>
						<th scope="col" style="max-width: 150px; min-width: 90px;">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=0; ?>
					<?php foreach ($invoice as $row): ?>
						<tr>
							<th scope="row"><?= ++$no ?></th>
							<td><?= $row['kode_bayar'] ?></td>
							<td><?= $row['name'] ?></td>
							<td><?= $row['email'] ?></td>
							<td><?= 'Rp.'.number_format($row['total_harga'],2,',','.') ?></td>
							<td><?= $row['metode_bayar'] ?></td>
							<td><?= $row['status'] ?></td>
							<td>
								<?php if ($row['status'] == 'Belum dibayar'): ?>
									<a href="<?= base_url('Transaksi/updateStatusInvoice/').$row['idi'].'/dibatalkan' ?>" class="badge badge-danger tombol-yakin">Batalkan</a>
									<a href="<?= base_url('Transaksi/updateStatusInvoice/').$row['idi'].'/lunas' ?>" class="badge badge-success">Lunas</a>
								<?php endif ?>
								<?php if ($row['status'] == 'Menunggu konfirmasi pembayaran'): ?>
									<a href="<?= base_url('Transaksi/updateStatusInvoice/').$row['idi'].'/lunas' ?>" class="badge badge-success">Lunas</a>
								<?php endif ?>
								<?php if ($row['status'] == 'Sudah dibayar'): ?>
									<a href="<?= base_url('Transaksi/kirimTiket/').$row['idi'] ?>" class="badge badge-info"  data-toggle="modal" data-target="#kirimTiketModal<?= $row['idi'] ?>">Kirim Tiket</a>
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- Button trigger modal -->

<!-- Modal -->
<?php foreach ($invoice as $row): ?>
	<div class="modal fade" id="kirimTiketModal<?= $row['idi'] ?>" tabindex="-1" aria-labelledby="kirimTiketModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="kirimTiketModalLabel">Kirim Tiket</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('Transaksi/kirimTiket/') ?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<h5>To : <?= $row['email']; ?></h5>
						<input type="hidden" name="to" id="to" value="<?= $row['email'] ?>">
						<input type="hidden" name="nama_acara" id="nama_acara" value="<?= $row['nama_acara'] ?>">
						<div class="form-group">
							<label for="tiket">Upload Tiket</label>
							<input type="file" class="form-control" name="tiket" id="tiket">
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