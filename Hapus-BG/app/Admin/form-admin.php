<?php include("config.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style admin.css">
    <style>
        :root {
            --bg-color: #FAF3E0;
            --primary-color: #C8B6A6;
            --accent-color: #A98467;
            --text-color: #3E3E3E;
            --light-text: #FFFFFF;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Montserrat', sans-serif;
            padding: 20px;
        }

        .admin-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
        }

        .admin-header h1 {
            font: 700 36px/1.23 Montserrat, sans-serif;
            color: var(--text-color);
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 30px;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            table-layout: auto;
        }

        .custom-table td:nth-child(3) { /* Kolom email */
            min-width: 200px;
            word-break: break-all;
        }

        .custom-table thead {
            background-color: var(--accent-color);
            color: var(--light-text);
        }

        /* Tambahkan di bagian style */
        .email-cell {
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .email-cell:hover {
            overflow: visible;
            white-space: normal;
            word-break: break-all;
        }

        .custom-table th {
            padding: 15px;
            font-weight: 700;
            text-align: left;
        }

        .custom-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--primary-color);
        }

        .custom-table tr:last-child td {
            border-bottom: none;
        }

        .custom-table tr:hover {
            background-color: rgba(200, 182, 166, 0.1);
        }

        .btn-custom {
            background-color: var(--accent-color);
            color: var(--light-text);
            border: none;
            border-radius: 25px;
            padding: 8px 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 14px;
        }

        .btn-custom:hover {
            background-color: var(--primary-color);
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(169, 132, 103, 0.3);
        }

        .btn-logout {
            background-color: #8B0000;
            color: white;
            margin-bottom: 20px;
        }

        .btn-logout:hover {
            background-color: #A52A2A;
        }

        #message {
            max-width: 400px;
            word-wrap: break-word;
        }

        .table-switcher {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        .table-switcher .btn {
            min-width: 150px;
        }

        .active-table {
            background-color: var(--accent-color) !important;
            color: white !important;
        }

        .table-container {
            display: none;
        }

        .table-container.active {
            display: block;
        }

        /* ✅ Tambahan untuk gambar history */
        .custom-table img.download-preview {
            max-width: 250px;
            max-height: 250px;
            border-radius: 10px;
            object-fit: cover;
        }

        /* ✅ Membuat kolom mengikuti isi */
        #history-table .custom-table {
            table-layout: auto;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Admin Panel</h1>
    </div>

    <a href="../Revisi2.php" class="btn btn-logout">Logout</a>

    <div class="table-switcher">
        <button class="btn btn-custom active-table" onclick="showTable('feedback')">Feedback</button>
        <button class="btn btn-custom" onclick="showTable('history')">Download History</button>
    </div>

    <!-- Feedback Table -->
    <div id="feedback-table" class="table-container active">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Feedback</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM feedback1";
                    $query = mysqli_query($db, $sql);
                    while($feedback = mysqli_fetch_array($query)){
                        echo "<tr>";
                        echo "<td>" . $feedback['tanggal'] . "</td>";
                        echo "<td>" . $feedback['nama'] . "</td>";
                        echo "<td class='email-cell'>" . $feedback['email'] . "</td>";
                        echo "<td id='message'>" . $feedback['feedback'] . "</td>";
                        echo "<td>";
                        echo "<a href='reply.php?ID=".$feedback['ID']."' class='btn btn-custom'>Reply</a> ";
                        echo "<a href='hapus.php?ID=".$feedback['ID']."' class='btn btn-custom' onclick='return confirmDelete()'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- History Table -->
    <div id="history-table" class="table-container">
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>File Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM history1";
                $query = mysqli_query($db, $sql);
                while($history = mysqli_fetch_array($query)){
                    echo "<tr>";
                    echo "<td>" . $history['tanggal'] . "</td>";
                    echo "<td>" . $history['nama'] . "</td>";
                    echo "<td>";
                    echo "<a href='hapus_history.php?ID=".$history['ID']."' class='btn btn-custom' onclick='return confirmDelete()'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

    <script>
        function confirmDelete() {
            return confirm("Yakin ingin menghapus data?");
        }

        function sensorKataKasar(teks) {
            var kataKasar = ["ancuk","ancok","ajig","anjay","anjg","anjing","anying","anjir","asu","asyu","babangus","babi","bacol","bacot","bagong","bajingan","balegug",
            "banci","bangke","bangsat","bedebah","bedegong","bego","belegug","beloon","bencong","bloon","blo'on","bodoh","boloho","buduk","budug","celeng","cibai","cibay",
            "cocot","cocote","cok","cokil","colai","colay","coli","colmek","conge","congean","congek","congor","cuk","cukima","cukimai","cukimay","dancok","entot","entotan",
            "ewe","ewean","gelo","genjik","germo","gigolo","goblo","goblog","goblok","hencet","henceut","heunceut","homo","idiot","itil","jancuk","jancok","jablay","jalang",
            "jembut","jiancok","jilmek","jurig","kacung","kampang","kampret","kampungan","kehed","kenthu","kentot","kentu","keparat","kimak","kintil","kirik","kunyuk","kurap",
            "konti","kontol","kopet","koplok","lacur","lebok","lonte","maho","meki","memek","monyet","ndas","ndasmu","ngehe","ngentot","nggateli","nyepong","ngewe","ngocok",
            "pante","pantek","patek","pathek","peju","pejuh","pecun","pecundang","pelacur","pelakor","peler","pepek","puki","pukima","pukimae","pukimak","pukimay","sampah",
            "sepong","sial","sialan","silit","sinting","sontoloyo","tai","taik","tempek","tempik","tete","tetek","tiembokne","titit","toket","tolol","ublag","udik","wingkeng"];

            for (var i = 0; i < kataKasar.length; i++) {
                var regex = new RegExp(kataKasar[i], "gi");
                teks = teks.replace(regex, '*');
            }

            return teks;
        }

        function showTable(tableName) {
            document.querySelectorAll('.table-container').forEach(table => {
                table.classList.remove('active');
            });

            document.getElementById(tableName + '-table').classList.add('active');

            document.querySelectorAll('.table-switcher .btn').forEach(btn => {
                btn.classList.remove('active-table');
            });
            event.target.classList.add('active-table');
        }

        document.addEventListener("DOMContentLoaded", function () {
            var messages = document.querySelectorAll('#message');
            messages.forEach(function (message) {
                var teksPesan = message.innerHTML;
                var teksSensor = sensorKataKasar(teksPesan);
                message.innerHTML = teksSensor;
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
