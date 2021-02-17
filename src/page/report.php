<?php
    session_start();
    require_once "../config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="margin: auto;">
<div style="margin: auto; padding: 100px;">
	<article id="" class="">
        <h1 style="text-align: center;">Laporan Kelayakan Titik Lokasi BTS Menggunakan DSS Metode SAW</h1>
        <!-- <h2>Calculate</h2> -->

		<div class="" style="margin: auto;">
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

			<!-- <div style="margin: auto;"> -->
        		<p>Berdasarkan Data Kriteria & Prefensi Bobot dibawah ini:</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Kriteria</th>
                        <th>Bobot</th>
                    </tr>
                    </thead>

                    <?php if ($query = $connection->query("SELECT * FROM bobot_preferensi")): ?>
                        <?php while($row = $query->fetch_assoc()): ?>
                        <tr>
                            <td><?=$row['id_bobot']?></td>
                            <td><?=$row['kriteria']?></td>
                            <td><?=$row['bobot']?></td>
                        </tr>
                        <?php endwhile ?>
                    <?php endif ?>
                </table>
			<!-- </div> -->

			<!-- <div> -->
				<!-- <h3>Rank</h3> -->
                <p style="text-align:justify;">Dan berdasarkan data terakhir di masing-masing kriteria,
                didapat urutan <strong> Referensi Prioritas proses upgrade BTS </strong> sebagai berikut:</p>
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
			<!-- </div> -->
		</div>
		<p>
			<?php 
				echo "Jakarta, ".date("d M Y")."<br>";
			?>
		</p>
	</article>
</div>
</body>
<script>
    $(document).ready(function(){
        // $('#tabel-data-normalisasi').DataTable({
        //     "paging": false
        // }),
        // $('#tabel-data-rank').DataTable({
        //     "paging": false
        // }),
        $('#tabel-data-alternatif').DataTable({
            "paging": false
        });
    });
</script>
</html>