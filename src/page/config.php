<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Update bobot
	if (isset($_POST["simpan-preferensi-bobot"]))  {
		$sql = "UPDATE bobot_preferensi SET kriteria='$_POST[kriteria]', bobot='$_POST[bobot]' WHERE id_bobot='$_POST[id]'";
	}

	// Update kondisi BTS
	if (isset($_POST["simpan-kondisi-bts"])) {
		$sql = "UPDATE kondisi_bts SET kondisi='$_POST[kondisi]', nilai='$_POST[nilai]' WHERE id_kondisi_bts='$_POST[id]'";
	}

	if ($connection->query($sql)) {
		echo alert("Berhasil!", "?page=config");
	} else {
		echo alert("Gagal!", "?page=config");
	}
}

?>

<aside>
	<article class="card">
		<section>		
			<form method="post">
				<caption><h3 class="text-center">Edit Preferensi Bobot</h3></caption>
				<label>Kriteria</label><br>
				<input type="text" name="kriteria" id="kriteria"><br>
				<label>Bobot</label><br>
				<input type="number" name="bobot" id="bobot" min="0"><br>
				<input type="hidden" name="id" id="id_bobot">
				<button class="button-simpan" name="simpan-preferensi-bobot" type="submit">Simpan</button>
			</form>
		</section>
	</article>

	<article class="card">
		<section>
			<form method="post">
				<caption><h3 class="text-center">Edit Kondisi BTS</h3></caption>
				<label>Kondisi</label><br>
				<input type="text" name="kondisi" id="kondisi"><br>
				<label>Nilai</label><br>
				<input type="number" name="nilai" id="nilai" min="0"><br>
				<input type="hidden" name="id" id="id_kondisi_bts">
				<button class="button-simpan" name="simpan-kondisi-bts" type="submit">Simpan</button>
			</form>
		</section>
	</article>
</aside>

<div id="content">
<article class="card">
	<h2>Config</h2>
	<p>Berikut adalah tabel Preferensi Bobot dan Kondisi BTS:</p>
	<section>
		<h3>Preferensi Bobot</h3>
		<table class="table table-striped table-bordered data">
			<thead>
			<tr>
				<th>No</th>
				<th>Kriteria</th>
				<th>Bobot</th>
				<th colspan="2">Aksi</th>
			</tr>
			</thead>

			<?php if ($query = $connection->query("SELECT * FROM bobot_preferensi")): ?>
				<?php while($row = $query->fetch_assoc()): ?>
				<tr>
					<td><?=$row['id_bobot']?></td>
					<td><?=$row['kriteria']?></td>
					<td><?=$row['bobot']?></td>
					<td>
						<button onclick="getPreferensiBobot(this)"
							data-key="<?=$row['id_bobot']?>"
							data-kriteria="<?=$row['kriteria']?>"
							data-bobot="<?=$row['bobot']?>"
							>
							Edit
						</button>
					</td>
				</tr>
				<?php endwhile ?>
			<?php endif ?>
		</table>
	</section>

	<section>
		<h3>Kondisi BTS</h3>
		<table>
			<thead>
			<tr>
				<th>No</th>
				<th>Kondisi</th>
				<th>Nilai</th>
				<th colspan="2">Aksi</th>
			</tr>
			</thead>
			
			<?php if ($query = $connection->query("SELECT * FROM kondisi_bts")): ?>
				<?php while($row = $query->fetch_assoc()): ?>
				<tr>
					<td><?=$row['id_kondisi_bts']?></td>
					<td><?=$row['kondisi']?></td>
					<td><?=$row['nilai']?></td>
					<td>
						<button onclick="getKondisiBTS(this)"
							data-key="<?=$row['id_kondisi_bts']?>"
							data-kondisi="<?=$row['kondisi']?>"
							data-nilai="<?=$row['nilai']?>"
							>
							Edit
						</button>
					</td>
				</tr>
				<?php endwhile ?>
			<?php endif ?>
		</table>
	</section>
</article>
</div>

<script>
	function getPreferensiBobot(pref) {
		const key = pref.getAttribute("data-key")
		const kriteria = pref.getAttribute("data-kriteria")
		const bobot = pref.getAttribute("data-bobot")

		const inputId = document.getElementById("id_bobot")
		const inputKriteria = document.getElementById("kriteria")
		const inputBobot = document.getElementById("bobot")

		inputId.value = key
		inputKriteria.value = kriteria
		inputBobot.value = bobot
	}

	function getKondisiBTS(kBTS) {
		const key = kBTS.getAttribute("data-key")
		const kondisi = kBTS.getAttribute("data-kondisi")
		const nilai = kBTS.getAttribute("data-nilai")

		const inputId = document.getElementById("id_kondisi_bts")
		const inputKondisi = document.getElementById("kondisi")
		const inputNilai = document.getElementById("nilai")

		inputId.value = key
		inputKondisi.value = kondisi
		inputNilai.value = nilai
	}
</script>