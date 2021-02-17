<?php

/**
 * Jika $_POST['id'] kosong, berarti operasi insert (inputKey kosong)
 * Jika $_POST['id'] ada, berarti operasi update
 * 
 * Operasi delete dilakukan dengan $_GET['action'] === 'delete'
 */

// Delete
if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
	$connection->query("DELETE FROM tbl_alternatif WHERE id_alternatif='$_GET[key]'");
	echo alert("Berhasil!", "?page=data");
}

// Insert / Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["simpan-alternatif"]))  {
		if ($_POST['id']) {
			// Update
			$sql = "UPDATE tbl_alternatif SET
					kondisi_bts_id = '$_POST[kondisi_bts_id]',
					kode_random = '$_POST[kode_random]',
					site_name = '$_POST[site_name]',
					nama_kelurahan = '$_POST[nama_kelurahan]',
					c1 = '$_POST[c1]',
					c2 = '$_POST[c2]',
					c3 = '$_POST[c3]'
					WHERE id_alternatif='$_POST[id]'";
		} else {
			// Insert
			$sql = "INSERT INTO tbl_alternatif (
						kondisi_bts_id,
						kode_random,
						site_name,
						nama_kelurahan,
						c1,
						c2,
						c3
					) 
					VALUES (
						'$_POST[kondisi_bts_id]',
						'$_POST[kode_random]',
						'$_POST[site_name]',
						'$_POST[nama_kelurahan]',
						'$_POST[c1]',
						'$_POST[c2]',
						'$_POST[c3]'
					)";
		}
	}

	if ($connection->query($sql)) {
		echo alert("Berhasil!", "?page=data");
	} else {
		echo alert("Gagal!", "?page=data");
	}
}

?>

<div id="content">
<article class="card">
	<h2>Data</h2>
	<table id="tabel-data-alternatif">
		<thead>
		<tr>
			<th>No</th>
			<th>Kode Random</th>
			<th>Tech Ready</th>
			<th>Site Name</th>
			<th>Nama Kelurahan</th>
			<th>C1</th>
			<th>C2</th>
			<th>C3</th>
			<th>C4</th>
			<th>Aksi</th>
			<th>Aksi</th>
		</tr>
		</thead>

		<?php $no = 1 ?>
		<?php if ($query = $connection->query("SELECT * FROM tbl_alternatif ta JOIN kondisi_bts kb ON ta.kondisi_bts_id = kb.id_kondisi_bts ORDER BY id_alternatif")): ?>
		<?php while($row = $query->fetch_assoc()): ?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$row['kode_random']?></td>
				<td><?=$row['kondisi']?></td>
				<td><?=$row['site_name']?></td>
				<td><?=$row['nama_kelurahan']?></td>
				<td><?=$row['c1']?></td>
				<td><?=$row['c2']?></td>
				<td><?=$row['c3']?></td>
				<td><?=$row['nilai']?></td>
				<td>
					<button onclick="getAlternatif(this)"
							data-key="<?=$row['id_alternatif']?>"
							data-kode-random="<?=$row['kode_random']?>"
							data-id-kondisi-bts="<?=$row['id_kondisi_bts']?>"
							data-site-name="<?=$row['site_name']?>"
							data-nama-kelurahan="<?=$row['nama_kelurahan']?>"
							data-c1="<?=$row['c1']?>"
							data-c2="<?=$row['c2']?>"
							data-c3="<?=$row['c3']?>"
							>
							<strong>Edit</strong>
					</button>
				</td>
				<td>
					<button><strong>
						<a href="?page=data&action=delete&key=<?=$row['id_alternatif']?>">Delete</a>		
					</strong></button>
				</td>
			</tr>
		<?php endwhile ?>
		<?php endif ?>
		
	</table>
</article>
</div>

<aside>
	<article class="card">
		<form method="post">
		<caption><h3 class="text-center">Input Alternatif</h3></caption>
		<section>
			<label>Kode Random</label><br>
			<?php
				include "kode_random.php";
				$random = random_string();
			?>
			<input style="background-color: #00c8eb; cursor: default;" required="required" type="text" name="kode_random" id="kode_random" value="<?php echo $random;?>" readonly><br>
			<label>Tech Ready</label><br>

			<?php
				$q = $connection->query("SELECT * FROM kondisi_bts");
				$kondisi_bts = $q->fetch_all(MYSQLI_ASSOC);
			?>
			<select required="required" name="kondisi_bts_id" id="kondisi_bts_id">
				<option>---</option>
				<?php foreach ($kondisi_bts as $index => $kbts): ?>
					<option value="<?= $kbts['id_kondisi_bts'] ?>">
						<?= $kbts['kondisi'] ?>
					</option>
				<?php endforeach; ?>
			</select><br>

			<label>Site Name</label><br>
			<input required="required" type="text" name="site_name" id="site_name" size="27"><br>
			<label>Nama Kelurahan</label><br>
			<input required="required" type="text" name="nama_kelurahan" id="nama_kelurahan" size="27"><br>
		</section>

		<section>
			<!-- C1 - C4 -->
			<label>C1</label><br>
			<input required="required" type="number" name="c1" id="c1" min="0" step=".01"><br>
			<label>C2</label><br>
			<input required="required" type="number" name="c2" id="c2" min="0"><br>
			<label>C3</label><br>
			<input required="required" type="number" name="c3" id="c3" min="0"><br>
			<input type="hidden" name="id" id="id_alternatif">
		</section>
		
		<button class="button-simpan" name="simpan-alternatif" type="submit">Simpan</button>
		</form>
	</article>
</aside>

<script>
	function getAlternatif(alt) {
		const key = alt.getAttribute("data-key")
		const kodeRandom = alt.getAttribute("data-kode-random")
		const idKondisiBTS = alt.getAttribute("data-id-kondisi-bts")
		const siteName = alt.getAttribute("data-site-name")
		const namaKelurahan = alt.getAttribute("data-nama-kelurahan")
		const c1 = alt.getAttribute("data-c1")
		const c2 = alt.getAttribute("data-c2")
		const c3 = alt.getAttribute("data-c3")

		const inputKey = document.getElementById("id_alternatif")
		const inputKodeRandom = document.getElementById("kode_random")
		const inputKondisiBTS = document.getElementById("kondisi_bts_id")
		const inputSiteName = document.getElementById("site_name")
		const inputNamaKelurahan = document.getElementById("nama_kelurahan")
		const inputC1 = document.getElementById("c1")
		const inputC2 = document.getElementById("c2")
		const inputC3 = document.getElementById("c3")

		inputKey.value = key
		inputKodeRandom.value = kodeRandom
		inputKondisiBTS.value = idKondisiBTS
		inputSiteName.value = siteName
		inputNamaKelurahan.value = namaKelurahan
		inputC1.value = c1
		inputC2.value = c2
		inputC3.value = c3
	}
</script>