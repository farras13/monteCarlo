<!-- Page content-->
<?php
$tlp = 0;
$arrayName = [];
$hari = $this->input->get('hari');
$id = $this->input->get('barang');
// print_r($prob); die;
?>

<div style="margin: 5% 8%;">
	<div class="container-fluid">
		<h1 class="mt-4">Prediksi Penjualan</h1>
		<p>Menampilkan prediksi penjualan untuk beberapa hari kedepan bergantung dengan inputan pengguna,dan prediksi penjualan ini menggunakan metode <b>Monte Carlo</b> sederhana.</p>
		<div class="mt-4 mb-4">
			<form action="<?= base_url('Prediksi/index') ?>" method="get">
				<div class="form-group first last mb-4">
					<label for="hari">Barang </label>
					<select name="barang" id="barang" class="form-control">
						<?php foreach ($barang as $b) : ?>
							<option value="<?= $b->id_brg ?>" <?php if ($b->id_brg == $id) {
																	echo 'selected';
																} ?>><?= $b->barang ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group first last mb-4">
					<label for="hari">Prediksi untuk (hari) </label>
					<input type="number" class="form-control mt-3" pattern="[0-9]*" id="hari" name="hari" min='0' placeholder="5 hari" value="<?= $hari ?>" required>
				</div>
				<div class="d-grid gap-2">
					<button type="submit" class="btn btn-primary">Calculate</button>
				</div>
			</form>
		</div>
		<hr>
		<h4>Tabel Probabilitas</h4>
		<hr>
		<div style="margin-top: 30px;">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">#</th>
						<th scope="col">Barang</th>
						<th scope="col">Tanggal</th>
						<th scope="col">Jumlah</th>
						<th scope="col">Probabilitas</th>
						<th scope="col">Komulatif</th>
						<th scope="col">Max Number</th>
					</tr>
				</thead>
				<tbody>
					<?php $n = 1;
					if ($prob != null) :
						foreach ($prob as $p) : ?>
							<tr>
								<th scope="row"><?= $n ?></th>
								<td><?= $p->barang ?></td>
								<td><?= $p->tanggal ?></td>
								<td><?= $p->total ?></td>
								<td><?php $pbl = $p->total / $tl;
									$pro = round($pbl, 2);
									$tlp += $pro;
									echo $pro; ?></td>
								<td><?= $tlp; ?></td>
								<td><?php $max = $tlp * 100;
									echo $max; ?></td>
							</tr>
					<?php $n++;
							array_push($arrayName, $max);
						endforeach;
					endif; ?>
					<tr>
						<td colspan="3">Total</td>
						<td><b><?= $tl ?></b></td>
						<td><b><?= $tlp ?></b></td>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		<h4>Tabel Prediksi</h4>
		<hr>
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th>Periode Permintaan</th>
					<th>Nilai Random</th>
					<th>Prediksi Jumlah Pesanan</th>
				</tr>
			</thead>
			<tbody>
				<?php $pjg = count($arrayName);
				$bts = count($arrayName) - 1;
				for ($y = 0; $y < $pjg; $y++) : ?>
					<tr>
						<td><?= $y + 1 ?></td>
						<td><?php $random = rand(1, 100);
							echo $random; ?></td>
						<td>
							<?php for ($x = 0; $x < $pjg; $x++) :
								if ($x == 0) {
									if ($random > 0 && $random < $arrayName[$x]) :
										echo $prob[0]->total;
									endif;
								} else {
									if ($random > $arrayName[$x - 1] && $random < $arrayName[$x] + 1) :
										echo $prob[$x]->total;
									endif;
								}

							endfor; ?>
						</td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>

	</div>
</div>
