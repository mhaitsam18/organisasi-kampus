<label for="nama_acara">Waktu diakhiri</label>
<div class="row">
	<div class="col">
		<input type="date" class="form-control" name="tanggal_berakhir" id="tanggal_berakhir" min="<?= $date ?>">
		<?= form_error('tanggal_berakhir','<small class="text-danger pl-3">','</small>'); ?>
	</div>
	<div class="col">
		<input type="time" class="form-control" name="waktu_berakhir" id="waktu_berakhir">
		<?= form_error('waktu_berakhir','<small class="text-danger pl-3">','</small>'); ?>
	</div>
</div>