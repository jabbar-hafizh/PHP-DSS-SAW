<div>
	<article id="calculate" class="card">
	<!-- <button style="padding: 5px;"><a target="_BLANK" onclick="window.print();">Print Report</a></button> -->
	<iframe src="page/report.php" style="display:none;" name="frame"></iframe>
	<button style="padding: 5px;" type="button" onclick="frames['frame'].print()" value="printletter">Print Report</button>
		<h2>Calculate</h2>

		<p>Berikut adalah hasil kalkulasi Normalisasi dan Rank:</p>
		<div class="content-calculate">
			<?php
			$q = $connection->query("SELECT
			ta.nama_kelurahan, ta.c1, ta.c2, ta.c3, kbts.nilai AS c4,
			(SELECT MAX(c1) FROM tbl_alternatif) AS c1_max,
			(SELECT MAX(c2) FROM tbl_alternatif) AS c2_max,
			(SELECT MAX(c3) FROM tbl_alternatif) AS c3_max,
			(SELECT MIN(nilai) FROM tbl_alternatif t 
			JOIN kondisi_bts k 
			ON t.kondisi_bts_id = k.id_kondisi_bts) AS c4_min
			FROM tbl_alternatif ta
			JOIN kondisi_bts kbts 
			ON ta.kondisi_bts_id = kbts.id_kondisi_bts
			ORDER BY ta.id_alternatif
			");

			$hasil_normalisasi = []; $ranking = [];

			// Normalisasi
			while ($r = $q->fetch_assoc()) {
				$rx1 = round($r['c1'] / $r['c1_max'], 2);
				$rx2 = round($r['c2'] / $r['c2_max'], 2);
				$rx3 = round($r['c3'] / $r['c3_max'], 2);
				$rx4 = round($r['c4'] / $r['c4_min'], 2);

				$hasil_normalisasi[$r['nama_kelurahan']] = [$rx1, $rx2, $rx3, $rx4];
			}

			// Ranking dan Pembobotan
			$q = $connection->query("SELECT bobot FROM bobot_preferensi");
			$bobot = $q->fetch_all();
			
			foreach ($hasil_normalisasi as $nama_kelurahan => $rx) {
				$ranking[$nama_kelurahan] = $rx[0] * $bobot[0][0] + $rx[1] * $bobot[1][0] + $rx[2] * $bobot[2][0] + $rx[3] * $bobot[3][0];
			}
			arsort($ranking);
			?>

			<div>
				<h3>Normalisasi</h3>
				<table id="tabel-data-normalisasi" style="margin-right: 100px;">
					<thead>
					<tr>
						<th>Nama Kelurahan</th>
						<th>rx1</th>
						<th>rx2</th>
						<th>rx3</th>
						<th>rx4</th>
					</tr>
					</thead>
					<?php foreach ($hasil_normalisasi as $nama_kelurahan => $rx): ?>
						<tr>
							<td><?=$nama_kelurahan?></td>
							<td><?=$rx[0]?></td>
							<td><?=$rx[1]?></td>
							<td><?=$rx[2]?></td>
							<td><?=$rx[3]?></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>

			<div>
				<h3>Rank</h3>
				<table id="tabel-data-rank">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama Kelurahan</th>
						<th>Nilai</th>
					</tr>
					</thead>
					<?php $no = 1 ?>						
					<?php foreach ($ranking as $nama_kelurahan => $skor): ?>
						<tr>
							<td><?=$no++?></td>
							<td><?=$nama_kelurahan?></td>
							<td><?=$skor?></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
		<p>
			<?php 
				echo "Jakarta, ".date("d M Y")."<br>";
			?>
		</p>
	</article>
</div>