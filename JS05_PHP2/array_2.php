<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        table {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <?php
        $Dosen = [
            'nama' => 'Elok Nur Hamdana',
            'domisili' => 'Malang',
            'jenis_kelamin' => 'Perempuan'];

        echo "Nama: {$Dosen ['nama']} <br>";
        echo "Domisili: {$Dosen ['domisili']} <br>";
        echo "Jenis Kelamin: {$Dosen ['jenis_kelamin']} <br>";

        echo "<hr>";
        echo "<table border='1' cellpadding='10' cellspacing='0'>";
        echo "<tr>";
        echo "<th>Nama</th>";
        echo "<th>Domisili</th>";
        echo "<th>Jenis Kelamin</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>{$Dosen ['nama']}</td>";
        echo "<td>{$Dosen ['domisili']}</td>";
        echo "<td>{$Dosen ['jenis_kelamin']}</td>";
        echo "</tr>";
        echo "</table>";
    ?>
</body>
</html>