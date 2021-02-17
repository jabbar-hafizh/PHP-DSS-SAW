<?php
session_start();
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DSS SAW</title>
    <!-- OLD -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Data Tables -->
    <!-- <script src="https://code.jquery.com/jquery-3.1.0.js"></script> -->
    <script src="assets/dataTables/js/jquery-3.1.0.js"></script>
    <script src="assets/dataTables/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script> -->
    <script src="assets/dataTables/js/dataTables.bootstrap.min.js"></script>
</head>
<body>
    <header>
        <div class="jumbroton">
            <h1>KELAYAKAN TITIK LOKASI BTS METODE DSS SAW</h1>
            <p lang="id" translate="">Program DSS Untuk Mencari Kelayakan Titik Lokasi BTS dengan Metode SAW</p>
        </div>
        <nav>
            <ul>
                <li><a href="?page=data">Data</li></a>
                <li><a href="?page=config">Config</li></a>
                <li><a href="?page=calculate">Calculate</li></a>
            </ul>
        </nav>
    </header>

    
    <main>
        <!-- <div> -->
        <?php include page($_PAGE); ?>
        <!-- </div> -->
    </main>
    
    
    <footer>
        <p style="padding-top: 1rem;">&#169; 2020</p>
    </footer>
</body>
<script>
    $(document).ready(function(){
        $('#tabel-data-normalisasi').DataTable({
            "paging": false
        }),
        $('#tabel-data-rank').DataTable({
            "paging": false
        }),
        $('#tabel-data-alternatif').DataTable({
            "paging": false
        });
    });
</script>
</html>
