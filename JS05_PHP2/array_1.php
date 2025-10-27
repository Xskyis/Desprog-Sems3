<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <h2>Array Terindeks</h2>
    <?php 
        $Listdosen=["Elok Nur Hamdana", "Unggul Pemenang", "Bagas Nugraha"];

        echo $Listdosen[2] . "<br>";
        echo $Listdosen[0] . "<br>";
        echo $Listdosen[1] . "<br>";

        echo "<hr>";

        echo "Menggunakan Looping: <br><br>";

        foreach($Listdosen as $dosen) {
            echo $dosen . "<br>";
        }
    ?>
</body>
</html>